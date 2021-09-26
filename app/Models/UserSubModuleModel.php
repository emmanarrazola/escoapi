<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserSubModuleModel extends Model
{
    use HasFactory;

    protected $table = 'user_sub_modules';

    protected $fillable = [
        'user_id',
        'sub_module_id',
        'selected'
    ];
}
