<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DealsModel extends Model
{
    use HasFactory;

    protected $table = 'crm_deals';

    protected $guarded = [];
}
