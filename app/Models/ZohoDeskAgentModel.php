<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class ZohoDeskAgentModel extends Model
{
    use HasFactory;

    protected $table = 'zoho_desk_agent';

    protected $guarded = [];
}
