<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Devices extends Model
{
    use HasFactory;

    protected $fillable = [
            'region',
            'branch',
            'branch_code',
            'city',
            'area',
            'state',
            'ifsc',
            'pincode',
            'name',
            'mobile',
            'device_id',
            'model',
            'status',
            'date_of_install',
            'last_updated_date',
            'apk_version',
            'remote_id'
        ];
}
