<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $fillable = [
    	'branch_id',
    	'bank_name',
    	'bank_code',
    	'ifsc',
    	'area',
    	'building',
    	'pincode',
    	'lattitude',
    	'longitude'];

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','id');
    } 

    public function devices(){
        return $this->hasMany(Device::class,'id','bank_id');
    }	
}
