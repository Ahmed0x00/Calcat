<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'purchases_count',
        'total',
        'company_id',
        'client_id',
    ];
}
