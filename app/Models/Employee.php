<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Employee extends Authenticatable
{
    use HasApiTokens, Notifiable;

    protected $fillable = [
        'name',
        'leader',
        'salary',
        'phone',
        'role',
        'email',
        'department_name',
        'password',
        'company_id',
        'employee_id',
    ];

    // Hiding the password field when returned in API responses
    protected $hidden = [
        'password',
    ];
}
