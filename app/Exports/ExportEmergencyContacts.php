<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use DB;
use App\Models\EmergencyContactDetail;

class ExportEmergencyContacts implements FromCollection,  WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $contact = EmergencyContactDetail::get();

        return $contact;
    }

     public function headings(): array
     {       
       return [
         'Sl No','Branch Id','Language','Police Station address','Police Station Contact','Medical Support address','Medical Support Contact','Ambulance','Ambulance Contact','Fire Station address','Fire Station Contact','Branch Manager','Branch Manager Contact','RNO','RNO Contact','PNO address','PNO Contact','Conatct Center','Conatct Center Contact','Cyber Dost','Cyber Dost Contact','Created Date','Last Modified Date'
       ];
     }
}
