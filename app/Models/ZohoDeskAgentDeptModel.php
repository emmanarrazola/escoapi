<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZohoDeskAgentDeptModel extends Model
{
    use HasFactory;

    protected $table = 'zoho_desk_agent_dept';

    protected $fillable = [
        'desk_agent_id',
        'desk_dept_id',
        'selected'
    ];
}
