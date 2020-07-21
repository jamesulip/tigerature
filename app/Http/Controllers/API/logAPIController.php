<?php

namespace App\Http\Controllers\API;

use App\Exports\LogDownload;
use Response;
use stdClass;
use Carbon\Carbon;
use App\Models\log;
use App\Models\users;
use App\Models\employees;
use Illuminate\Http\Request;
use App\Models\question_answers;
use App\Repositories\logRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\AppBaseController;
use App\Http\Requests\API\CreatelogAPIRequest;
use App\Http\Requests\API\UpdatelogAPIRequest;

/**
 * Class logController
 * @package App\Http\Controllers\API
 */

class logAPIController extends AppBaseController
{
    /** @var  logRepository */
    private $logRepository;

    public function __construct(logRepository $logRepo)
    {
        $this->logRepository = $logRepo;
    }

    /**
     * Display a listing of the log.
     * GET|HEAD /logs
     *
     * @param Request $request
     * @return Response
     */
    public function export(Request $req){
        // return "assd";
        return Excel::download(new LogDownload($req), 'users.xlsx');

        $from   =   \Carbon\Carbon::parse( $req->all()['start_date'])->format('Y-m-d  00:00:00');
        $to     =   \Carbon\Carbon::parse( $req->all()['end_date'])->format('Y-m-d  23:59:59');
        $id     =   $req->employee_id;
        $headers = [

        ];

       $rows= log::with('user','log')->whereBetween('created_at', [$from, $to])
        ->when($id!==null, function ($query) use ($id) {
            return $query->where('employee_id', $id);
        })
        ->get()->map(function($us){
            $lo = new stdClass();
            $lo->employee_id = $us->user->employee_id;
            $lo->name = "{$us->user->last_name},{$us->user->first_name}";
            $lo->address = $us->address;
            $lo->temperature = $us->temp;
            $lo->log = collect($us->log['answer'])->implode(',');
            return $lo;
        })->toArray();

        return $rows;
    //     $csv = $formatter->toCsv();

    //     header('Content-Disposition: attachment; filename="export.csv"');
    //     header("Cache-control: private");
    //     header("Content-type: application/force-download");
    //     header("Content-transfer-encoding: binary\n");

    //     echo $csv;

    //     exit;


    }
    public function allLog(Request $req){
        $from   =   \Carbon\Carbon::parse( $req->all()['start_date'])->format('Y-m-d  00:00:00');
        $to     =   \Carbon\Carbon::parse( $req->all()['end_date'])->format('Y-m-d  23:59:59');
        $id     =   $req->all()['employee_id'];

        return employees::with(array('logs'=>function($log) use ($from,$to){
            return $log->with('log')->whereBetween('created_at', [$from, $to]);
        }))
        ->when($id!==null, function ($query) use ($id) {
            return $query->where('employee_id', $id);
        })
        ->get();
    }
    public function index(Request $request)
    {
        $logs = $this->logRepository->all(
            $request->except(['skip', 'limit']),
            $request->get('skip'),
            $request->get('limit')
        );

        return $this->sendResponse($logs->toArray(), 'Logs retrieved successfully');
    }

    /**
     * Store a newly created log in storage.
     * POST /logs
     *
     * @param CreatelogAPIRequest $request
     *
     * @return Response
     */
    public function store(CreatelogAPIRequest $request)
    {
        try {
           $input = $request->all();

            $log = $this->logRepository->create($request->except('answers'));

            if( $input["answers"]){
                $ans =new question_answers();
                $ans->user_id = $log->user_id;
                $ans->log_id = $log->id;
                $ans->answer = $request->answers;
                $ans->save();
            }
            return $this->sendResponse($log->toArray(), 'Log saved successfully');
        } catch (\Throwable $th) {
            //throw $th;
            return $th;
        }

    }

    /**
     * Display the specified log.
     * GET|HEAD /logs/{id}
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var log $log */
        $log = $this->logRepository->find($id);

        if (empty($log)) {
            return $this->sendError('Log not found');
        }

        return $this->sendResponse($log->toArray(), 'Log retrieved successfully');
    }

    /**
     * Update the specified log in storage.
     * PUT/PATCH /logs/{id}
     *
     * @param int $id
     * @param UpdatelogAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdatelogAPIRequest $request)
    {
        $input = $request->all();

        /** @var log $log */
        $log = $this->logRepository->find($id);

        if (empty($log)) {
            return $this->sendError('Log not found');
        }

        $log = $this->logRepository->update($input, $id);

        return $this->sendResponse($log->toArray(), 'log updated successfully');
    }

    /**
     * Remove the specified log from storage.
     * DELETE /logs/{id}
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var log $log */
        $log = $this->logRepository->find($id);

        if (empty($log)) {
            return $this->sendError('Log not found');
        }

        $log->delete();

        return $this->sendSuccess('Log deleted successfully');
    }
}
