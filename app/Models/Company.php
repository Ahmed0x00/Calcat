<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Carbon\Carbon;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'license_key',
        'owner_name',
        'email',
        'balance',
        'blocked',
        'valid_until'
    ];

    // Automatically generate UUID for company_id and set valid_until
    protected static function boot()
    {
        parent::boot();

        // Set the `company_id` and `valid_until` when creating a new company
        static::creating(function ($model) {
            $model->company_id = (string) Str::uuid();
            $model->valid_until = Carbon::now()->addYear();
            $model->blocked = false;
        });
    }

    protected static function booted()
    {
        static::retrieved(function ($company) {
            if ($company->valid_until < now() && !$company->blocked) {
                $company->blocked = true;
                $company->save();
            }
        });
    }

}
