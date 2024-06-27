<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmergencyContactDetail extends Model
{
    use HasFactory;

    protected $fillable=[
            'branch_id',
            'police',
            'police_contact',
            'medical',
            'medical_contact',
            'ambulance',
            'ambulance_contact',
            'fire',
            'fire_contact',
            'manager',
            'manager_contact',
            'rno',
            'rno_contact',
            'pno',
            'pno_contact',
            'contact_center',
            'contact_center_number',
            'cyber_dost',
            'cyber_dost_number',
            'lang_code'
        ];

    public function branch(){
        return $this->belongsTo(Branch::class,'branch_id','branch_code');
    }    
}
