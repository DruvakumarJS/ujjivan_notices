<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use App\Models\BankingOmbudsment;
use App\Models\Branch;
use App\Models\Notice;

class ImporteBankingOmbudsment implements ToModel, WithStartRow
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

         
         if(BankingOmbudsment::where('state',$row[0])->where('lang_code',$row[1])->exists()){
            $info = BankingOmbudsment::where('state',$row[0])->where('lang_code',$row[1])->first();
  
            $updateBranch = BankingOmbudsment::where('id',$info->id)->update([
                'banking_ombudsment' => $row[2],
                'banking_ombudsment_name' => $row[3],
                'center' => $row[4],
                'center_name' => $row[5],
                'area' => $row[6],
                'area_name' => $row[7],
                'address' => $row[8],
                'full_address' => $row[9],
                'tel' => $row[10],
                'tel_number' => $row[11],
                'fax' => $row[12],
                'fax_number' => $row[13],
                'email' => $row[14],
                'email_id' => $row[15],
                'toll_free' => $row[16],
                'toll_free_number' => $row[17]
            ]);

            
           

         } 
         else{
            
             $insert = BankingOmbudsment::create([
             	'state'=> $row[0],
             	'lang_code' => $row[1],
                'banking_ombudsment' => $row[2],
                'banking_ombudsment_name' => $row[3],
                'center' => $row[4],
                'center_name' => $row[5],
                'area' => $row[6],
                'area_name' => $row[7],
                'address' => $row[8],
                'full_address' => $row[9],
                'tel' => $row[10],
                'tel_number' => $row[11],
                'fax' => $row[12],
                'fax_number' => $row[13],
                'email' => $row[14],
                'email_id' => $row[15],
                'toll_free' => $row[16],
                'toll_free_number' => $row[17]
            ]);

            
         }

          $updateNotice = Notice::where('template_id','4')->update([]);

         
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
