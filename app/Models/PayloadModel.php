<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayloadModel extends Model
{
    use HasFactory;

    protected $table = 'payloads';

    protected $guarded = [];
}
