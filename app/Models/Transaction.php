<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'amount',
        'type_of_trans',
        'type',
        'details',
        'name',
        'phone',
        'date',
        'company_id',
        'transaction_id',
        'due_date',
        'paid'
    ];
}
