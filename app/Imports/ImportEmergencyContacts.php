<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\EmergencyContactDetail;


class ImportEmergencyContacts implements ToModel, WithStartRow
{
    /**
    * @param Collection $collection
    */
    public $rowCount = 0;

    public function startRow(): int
    {
        return 2;
    }

    public function  model(array $row)
    {
         ++$this->rowCount;

         $branchcode = $row[0];

         if(EmergencyContactDetail::where('branch_id',$branchcode)->exists()){
            $info = EmergencyContactDetail::where('branch_id',$branchcode)->first();
  
            $updateBranch = EmergencyContactDetail::where('id',$info->id)->update([
                'police' => $row[1],
                'police_contact' => $row[2],
                'medical' => $row[3],
                'medical_contact' => $row[4],
                'ambulance' => $row[5],
                'ambulance_contact' => $row[6],
                'fire' => $row[7],
                'fire_contact' => $row[8],
                'manager' => $row[9],
                'manager_contact' => $row[10],
                'rno' => $row[11],
                'rno_contact' => $row[12],
                'pno' => $row[13],
                'pno_contact' => $row[14],
                'contact_center' => $row[15],
                'contact_center_number' => $row[16],
                'cyber_dost' => $row[17],
                'cyber_dost_number' => $row[18],
            ]);

           
         } 
         else{
            
             $updateBranch = EmergencyContactDetail::create([
                'branch_id' => $row[0],
                'police' => $row[1],
                'police_contact' => $row[2],
                'medical' => $row[3],
                'medical_contact' => $row[4],
                'ambulance' => $row[5],
                'ambulance_contact' => $row[6],
                'fire' => $row[7],
                'fire_contact' => $row[8],
                'manager' => $row[9],
                'manager_contact' => $row[10],
                'rno' => $row[11],
                'rno_contact' => $row[12],
                'pno' => $row[13],
                'pno_contact' => $row[14],
                'contact_center' => $row[15],
                'contact_center_number' => $row[16],
                'cyber_dost' => $row[17],
                'cyber_dost_number' => $row[18],
            ]);


            
         }

         
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
