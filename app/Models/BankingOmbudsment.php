<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BankingOmbudsment extends Model
{
    use HasFactory;

    protected $fillable = [
    	'state',
        'lang_code',
        'banking_ombudsment',
        'banking_ombudsment_name',
        'center',
        'center_name',
        'area',
        'area_name',
        'address',
        'full_address',
        'tel',
        'tel_number',
        'fax',
        'fax_number',
        'email',
        'email_id',
        'toll_free',
        'toll_free_number',
     ];
}
