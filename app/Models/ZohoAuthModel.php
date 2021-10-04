<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ZohoAuthModel extends Model
{
    use HasFactory;

    protected $table = 'zoho_auth';

    protected $guarderd = [];
}
