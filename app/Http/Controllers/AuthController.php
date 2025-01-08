<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\User;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;


class AuthController extends Controller
{
    public function register(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255',
        'password' => 'required|string|confirmed',
        'balance' => 'required|numeric|min:0',
        'license_key' => 'required|string|exists:companies,license_key', // Validate license key existence
    ]);

    $company = Company::where('license_key', $request->license_key)->first();
    if (!$company) {
        return response()->json([
            'message' => 'Invalid license key provided.'
        ], 404);
    }

    if ($company->owner_name || $company->email) {
        return response()->json([
            'message' => 'This license key is already registered.'
        ], 409);
    }

    // Register the owner user and populate the company details
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => 'owner',
        'company_id' => $company->company_id,
    ]);

    // Update the company with the owner's details
    $company->update([
        'owner_name' => $request->name,
        'email' => $request->email,
        'balance' => $request->balance,
    ]);

    return response()->json([
        'message' => 'Registration successful',
        'user' => $user,
    ], 201);
}

public function login(Request $request)
{
    $request->validate([
        'email' => 'required|string|email',
        'password' => 'required|string',
    ]);

    $user = User::where('email', $request->email)->first();
    if (!$user || !Hash::check($request->password, $user->password)) {
        return response()->json([
            'message' => 'The provided credentials do not match our records.'
        ], 401);
    }

    if ($user->role == 'super admin'){
        Auth::login($user);
        return response()->json([
            'message' => 'Login successful',
            'user' => $user
        ]);
    }

    $company = Company::where('company_id', $user->company_id)->first();
    if (!$company || $company->blocked) { 
        return response()->json([
            'message' => 'Company access is restricted or the company is blocked.'
        ], 403);
    }

    // Log in the user only if all checks pass
    Auth::login($user);

    return response()->json([
        'message' => 'Login successful',
        'user' => $user
    ]); 
}

    public function logout(Request $request)
    {
        Auth::logout();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|confirmed',
        ]);

        $user = Auth::user();
        if (!Hash::check($request->current_password, $user->password)) {
            throw ValidationException::withMessages([
                'current_password' => ['The provided password does not match your current password.'],
            ]);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();
        return response()->json([
            'message' => 'Password changed successfully'
        ]);
    }

    public function getUserData()
    {
        $user = Auth::user();
        $employeeData = Employee::where('email', $user->email)->first();
        if ($employeeData) {
            return response()->json([
                'user' => $user->makeHidden('password')->toArray() + [
                    'employee_id' => $employeeData->id,
                    'phone' => $employeeData->phone
                ]
            ]);
        }
    
        return response()->json(['user' => $user->makeHidden('password')]);
    }
    
}
