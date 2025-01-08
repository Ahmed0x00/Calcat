<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class AdminController extends Controller
{
    public function fetchCompanies()
    {
        $companies = Company::all();
        return response()->json($companies);
    }

    // Create a new company with a unique license key
    public function createCompany(Request $request)
    {
        $licenseKey = Str::random(32); // Generate unique license key

        $company = Company::create([
            'license_key' => $licenseKey,
            'owner_name' => null,
            'email' => null,
            'balance' => null,
            'income_types' => [],
            'expenses_types' => [],
        ]);

        return response()->json([
            'message' => 'Company created successfully with a license key.',
            'company' => $company,
        ]);
    }

    // Block a company by ID
    public function blockCompany($id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'blocked' => true,
            'valid_until' => now() // Effectively blocks the company by marking the license as expired
        ]);

        return response()->json([
            'message' => 'Company has been blocked successfully.',
            'company' => $company,
        ]);
    }

    public function unblockCompany($id)
    {
        $company = Company::findOrFail($id);

        $company->update([
            'blocked' => false,
            'valid_until' => now()->addYear()
        ]);

        return response()->json([
            'message' => 'Company has been unblocked successfully.',
            'company' => $company,
        ]);
    }

    // Delete a company and all related data
    public function deleteCompanyWithRelations($id)
    {
        $company = Company::findOrFail($id);

        \DB::transaction(function () use ($company) {
            $tables = [
                'resources',
                'transactions',
                'units',
                'users',
                'clients',
                'employees',
                'credits',
                'debts',
            ];
        
            foreach ($tables as $table) {
                \DB::table($table)->where('company_id', $company->company_id)->delete();
            }
        
            $company->delete();
        });
        

        return response()->json(['message' => 'Company and all related data deleted successfully.']);
    }


}
