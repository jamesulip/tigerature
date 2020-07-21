<?php

namespace App\Exports;


use App\Models\log;
use Maatwebsite\Excel\Concerns\FromCollection;

class LogDownload implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    private $req;
    public function __construct($d)
    {
        $this->req = $d;

    }
    public function collection()
    {
        $req = $this->req;

        $from   =   \Carbon\Carbon::parse( $req->all()['start_date'])->format('Y-m-d  00:00:00');
        $to     =   \Carbon\Carbon::parse( $req->all()['end_date'])->format('Y-m-d  23:59:59');
        $id     =   $req->employee_id;
        $headers = [

        ];

      return log::with('user','log')->whereBetween('created_at', [$from, $to])
        ->when($id!==null, function ($query) use ($id) {
            return $query->where('employee_id', $id);
        })

        ->get()->map(function($us){
        $lo = new \stdClass();
        $lo->employee_id = $us->user->employee_id;
        $lo->name = "{$us->user->last_name},{$us->user->first_name}";
        $lo->address = $us->address;
        $lo->temperature = $us->temp;
        $lo->log = collect($us->log['answer'])->implode(',');
        return $lo;
        })->sortBy('employee_id');


    }
}
