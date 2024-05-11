<?php

namespace App\Imports;

use App\Models\Branch;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ImportBranches implements  ToModel, WithStartRow
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

         $save = Branch::create([
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

         ]);
    }

    public function getRowCount(): int
    {
        return $this->rowCount;
    }
}
