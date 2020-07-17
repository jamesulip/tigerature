<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreatelogAPIRequest;
use App\Http\Requests\API\UpdatelogAPIRequest;
use App\Models\log;
use App\Repositories\logRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use App\Models\employees;
use App\Models\users;
use Carbon\Carbon;
use Response;

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
    public function allLog(Request $req){
        $from   =   \Carbon\Carbon::parse( $req->all()['start_date'])->format('Y-m-d  00:00:00');
        $to     =   \Carbon\Carbon::parse( $req->all()['end_date'])->format('Y-m-d  23:59:59');
        $id     =   $req->all()['employee_id'];

        return employees::with(array('logs'=>function($log) use ($from,$to){
            return $log->whereBetween('created_at', [$from, $to]);
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

            $log = $this->logRepository->create($input);

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
