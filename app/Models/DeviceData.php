<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeviceData extends Model
{
    use HasFactory;

    protected $fillable = [
    	'device_id',
    	'mac_id',
    	'apk_version',
    	'last_updated_date',
    	'last_updated_time'];
}
