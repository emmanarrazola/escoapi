<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZohoApiModel extends Model
{
    protected $table = 'zoho_api';

    protected $fillable = [
        'description',
        'url',
        'isactive',
        'isdelete'
    ];
}
