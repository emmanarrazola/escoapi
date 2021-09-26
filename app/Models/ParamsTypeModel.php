<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParamsTypeModel extends Model
{
    use HasFactory;

    protected $table = 'zoho_api_params_type';

    protected $fillable = [
        'id',
        'description',
        'isactive',
        'isdelete'
    ];
}
