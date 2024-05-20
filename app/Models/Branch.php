<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

     protected $fillable=[
     	'region_id',
    	'name',
    	'branch_code',
        'area',
        'ifsc',
    	'state',
    	'district',
    	'city',
    	'pincode',
    	'description',
        'lattitude',
        'longitude',
        'ct_name',
        'ct_mobile',
        'ct_email',
        'ct_designation'];

    public function region(){
        return $this->belongsTo(Region::class,'region_id','id');
    }  

    public function banks(){
        return $this->hasMany(Bank::class,'id','branch_id');
    }

    public function devices(){
        return $this->hasMany(Device::class,'id','branch_id');
    } 

    public function notice(){
        return $this->hasMany(Notices::class,'id','branch_code');
    } 

    public function branchInformation(){
        return $this->hasOne(BranchInformation::class,'id' , 'branch_id');
    } 
}
