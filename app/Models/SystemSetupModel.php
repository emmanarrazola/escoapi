<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SystemSetupModel extends Model
{
    use HasFactory;

    protected $table = 'systemsetup';

    protected $guarded = [];
}
