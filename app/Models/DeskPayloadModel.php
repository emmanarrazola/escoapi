<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeskPayloadModel extends Model
{
    use HasFactory;

    protected $table = 'desk_payloads';

    protected $guarded = [];
}
