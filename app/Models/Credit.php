<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Credit extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'transaction_id', 'amount', 'details', 'type', 'contractor_name', 'contractor_phone', 'due_date',
    ];
}
