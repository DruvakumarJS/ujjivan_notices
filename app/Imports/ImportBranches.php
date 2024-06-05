<?php

namespace App\Imports;

use App\Models\Branch;
use App\Models\BranchInformation;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportBranches implements  ToModel, WithStartRow
{
    /**
    * @param array $row
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

        /* $save = Branch::create([
         	'region_id' => $row[0],
         	'name' => $row[1],
         	'branch_code' => $row[2],
         	'ifsc' => $row[3],
         	'area' => $row[4],
         	'city' => $row[5],
         	'district' => $row[6],
         	'state' => $row[7],
         	'pincode' => $row[8],
         	'ct_name' => $row[9],
         	'ct_mobile' => $row[10],
         	'ct_email' => $row[11],
         	'ct_designation' => $row[12],

         ]);*/

         $branchcode = $row[2];

         if(BranchInformation::where('branch_id',$branchcode)->exists()){
            $info = BranchInformation::where('branch_id',$branchcode)->first();

            $updateBranch = Branch::where('id',$info->id)->update([
                'region_id' => $row[0],
                'name' => $row[1],
                'ifsc' => $row[3],
                'area' => $row[4],
                'city' => $row[5],
                'district' => $row[6],
                'state' => $row[7],
                'pincode' => $row[8],
            ]);

            if($updateBranch){
                $update_info = BranchInformation::where('branch_id',$info->id)->update([
                     'bm_name' => $row[9],
                     'bm_number' => $row[10],
                     'bm_designation' => $row[12],
                ]);
            }
         } 
         else{
             $branch  = new Branch();
             $branch->region_id = $row[0];
             $branch->name = $row[1];
             $branch->branch_code = $row[2];
             $branch->ifsc = $row[3];
             $branch->area = $row[4];
             $branch->city = $row[5];
             $branch->district = $row[6];
             $branch->state = $row[7];
             $branch->pincode = $row[8];

             $branch->save();

             $branchID = $branch->id;

             $branchinfo = new BranchInformation();
             $branchinfo->branch_id = $branchID;
             $branchinfo->bm_name = $row[9];
             $branchinfo->bm_number = $row[10];
             $branchinfo->bm_designation = $row[12];

             $branchinfo->save();
         }

         
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
