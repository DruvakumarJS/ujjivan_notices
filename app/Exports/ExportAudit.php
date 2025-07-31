<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Audit;

class ExportAudit implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data = Audit::orderBy('id','desc')->get();

        $dataarray=array();

        foreach ($data as $key => $value) {
        	$dataarray[]=[
	        	date('d M Y', strtotime($value->created_at)),
	        	date('H:i:s', strtotime($value->created_at)),
	        	$value->user->name ,
	        	$value->module,
	            ($value->module == 'Notice')? ($value->track_id.' - '.$value->action):($value->action) ,
	            $value->pan_india,
	            $value->regions,
	            $value->states,
	            $value->branch
	        ];
        }

       // print_r(json_encode($dataarray));die();

        return collect($dataarray);
    }

    public function headings(): array
	{       
	   return [
	     'Date','Time','User Name','Module','Action','PAN India','Region','State','Branch'
	   ];
	}

}
