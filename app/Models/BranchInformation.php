<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BranchInformation extends Model
{
    use HasFactory;

    protected $fillable = [
	    'branch_id',
        'bm_name',
        'bm_number',
        'bm_email',
        'bm_designation',
        'bo_name',
        'bo_number',
        'bo_email',
        'bo_designation',
        'medical',
        'ambulance',
        'fire',
        'police',

        ];

    public function branch(){
    	return $this->belongsTo(Branch::class,'branch_id' , 'id');
    }  

    public function branchcotact(){
        return $this->hasMany(Devices::class,'branch_id' , 'branch_id');
    }  
}
