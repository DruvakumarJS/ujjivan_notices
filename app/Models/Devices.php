<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $fillable = [
            'region_id',
            'branch_id',
            'bank_id',
            'name',
            'mobile',
            'mac_id',
            'device_details',
            'status',
            'date_of_install',
            'last_updated_date',
            'apk_version',
            'remote_id'
        ];

    public function bank(){
        return $this->belongsTo(Bank::class,'bank_id','id');
    }

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    } 

    public function branchcontact(){
        return $this->belongsTo(BranchInformation::class,'branch_id' , 'branch_id');
    }     
}
