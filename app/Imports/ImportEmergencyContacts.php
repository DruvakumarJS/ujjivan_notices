<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\EmergencyContactDetail;
use App\Models\BranchInformation;
use App\Models\Branch;
use App\Models\Notice;


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
          $Branch = Branch::where('branch_code',$row[0])->first();

         if(EmergencyContactDetail::where('branch_id',$branchcode)->where('lang_code',$row[19])->exists()){
            $info = EmergencyContactDetail::where('branch_id',$branchcode)->where('lang_code',$row[19])->first();
  
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
                'lang_code' => $row[19],
            ]);

            $BranchManager= explode('/', $row[9]);

            if($row[19]=='en'){
                $updateBranchInformation = BranchInformation::where('branch_id',$Branch->id)->update([
                'bm_name' => $BranchManager[1],
                'bm_number' => $row[10]]);
            }

           

         } 
         else{
            
             $insertBranch = EmergencyContactDetail::create([
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
                'lang_code' => $row[19],
              ]);

             $BranchManager= explode('/', $row[9]);
              if($row[19]=='en'){
                $updateBranchInformation = BranchInformation::where('branch_id',$Branch->id)->update([
                'bm_name' => $BranchManager[1],
                'bm_number' => $row[10]]);
                }


            
         }

          $updateNotice = Notice::where('template_id','3')->update([]);

         
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
