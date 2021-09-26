<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScopeModel extends Model
{
    use HasFactory;

    protected $table = 'scopes';

    protected $fillable = [
        'id',
        'description',
        'zoho_scope',
        'isactive',
        'isdelete'
    ];
}
