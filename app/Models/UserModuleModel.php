<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserModuleModel extends Model
{
    use HasFactory;

    protected $table = 'user_modules';

    protected $fillable = [
        'user_id',
        'module_id',
        'selected'
    ];
}
