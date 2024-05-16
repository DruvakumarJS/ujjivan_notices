<?php

namespace App\Exports;

use App\Models\Notice;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;

class ExportNotice implements FromCollection,WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public $search ;
    public $lang ;

    public function __construct($lang , $search ) 
    {
    	$this->lang = $lang;  
        $this->search = $search;     
    } 

    public function collection()
    {
    	$search = $this->search;

    	if($search == 'all'){
    		 $data = Notice::select('name','document_id','notice_type','lang_name','status',DB::raw(
            "DATE_FORMAT(created_at, '%d-%m-%Y') as date"),)->where('lang_code', $this->lang)->get();
    	}
    	else{
             $data = Notice::select('name','document_id','notice_type','lang_name','status','created_at')
             ->where('lang_code', $this->lang)
             ->where(function($query)use($search){
                $query->where('document_id','LIKE','%'.$search.'%');
             })
             ->get();
    	}

    	return $data;
      
    }

	public function headings(): array
	{       
	   return [
	     'Notice Name','Document ID','Notice Type','Language Name','Status','Created Date'
	   ];
	}


}
