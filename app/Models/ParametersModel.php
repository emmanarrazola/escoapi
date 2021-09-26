<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParametersModel extends Model
{
    use HasFactory;

    protected $table = 'zoho_api_params';

    protected $fillable = [
        'zoho_api_id',
        'params_type_id',
        'params_key',
        'params_value',
        'isactive',
        'isdelete',
    ];
}
