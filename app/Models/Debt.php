<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Debt extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id', 'transaction_id', 'amount', 'details', 'type', 'client_name', 'client_phone', 'due_date',
    ];
}
