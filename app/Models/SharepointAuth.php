<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SharepointAuth extends Model
{
    use HasFactory;

    protected $table = 'sharepoint_auth';

    protected $guarded = [];
}
