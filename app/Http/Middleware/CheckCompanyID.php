<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Company;

class CheckCompanyID
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();
        $companyId = $request->company_id;
        $company = Company::where('company_id', $companyId)->first();
        
        if (!$company) {
            return response()->json(['message' => 'Company not found.'], 403);
        }
        if ($user->company_id !== $companyId) {
            return response()->json(['message' => 'You do not have access to this company.'], 403);
        }
        if ($company->blocked) {
            return response()->json(['message' => 'Your company is currently blocked. Please contact support for assistance.'], 403);
        }

        return $next($request);
    }
}
