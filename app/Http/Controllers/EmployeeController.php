<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class EmployeeController extends Controller
{
    public function createEmployee(Request $request, $company_id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'salary' => 'required|numeric',
                'phone' => 'required|string|max:15',
                'leader' => 'nullable|string|max:255',
                'department_name' => 'nullable|string|max:255',
                'password' => 'required|string',
                'role' => 'required|string|in:admin,employee',
            ]);

            $existingEmployee = User::where('email', $request->email)->first();
            if ($existingEmployee) {
                return response()->json(['message' => 'The email has already been taken.'], 409);
            }

            $employee = Employee::create([
                'company_id' => $company_id,
                'name' => strip_tags($request->name),
                'email' => $request->email,
                'phone' => $request->phone,
                'salary' => $request->salary,
                'leader' => $request->leader,
                'department_name' => $request->department_name,
                'role' => $request->role,
                'password' => bcrypt($request->password),
                'employee_id' => Employee::where('company_id', $company_id)->max('employee_id') + 1,
            ]);

            User::create([
                'name' => strip_tags($request->name),
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role' => 'employee', // Set role to employee by default
                'company_id' => $company_id,
            ]);

            return response()->json([
                'message' => 'Employee created successfully',
                'employee' => $employee
            ], 201);
        } catch (\Exception $e) {
            Log::error("Failed to create employee: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the employee.'], 500);
        }
    }

    public function updateEmployee(Request $request, $company_id, $employee_id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255',
                'phone' => 'required|string|max:15',
                'salary' => 'required|numeric',
                'leader' => 'nullable|string|max:255',
                'department_name' => 'nullable|string|max:255',
                'role' => 'required|string|in:admin,employee',
                'password' => 'nullable|string',
            ]);

            $employee = Employee::where('company_id', $company_id)
                ->where('employee_id', $employee_id)
                ->firstOrFail();

            $user = User::where('email', $employee->email)->first();
            $existingUser = User::where('email', $request->email)
                ->where('id', '!=', $user ? $user->id : null) // Check if user exists and exclude their id
                ->first();

            if ($existingUser) {
                return response()->json(['message' => 'The email has already been taken.'], 409);
            }

            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->phone = $request->phone;
            $employee->salary = $request->salary;
            $employee->leader = $request->leader;
            $employee->department_name = $request->department_name;
            $employee->role = $request->role;

            if ($request->filled('password')) {
                $employee->password = bcrypt($request->password);
            }

            $employee->save();

            // Update the employee record in the (users) table
            $user = User::where('email', $employee->email)->first();
            if ($user) {
                $user->name = $request->name;
                $user->email = $request->email;

                if ($request->filled('password')) {
                    $user->password = bcrypt($request->password);
                }

                $user->save();
            }

            return response()->json(['message' => 'Employee updated successfully', 'employee' => $employee], 200);
        } catch (\Exception $e) {
            Log::error("Failed to update employee: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the employee.'], 500);
        }
    }


    public function destroyEmployee($company_id, $employee_id)
    {
        try {
            $employee = Employee::where('company_id', $company_id)
                ->where('employee_id', $employee_id)
                ->firstOrFail();
    
            $user = User::where('email', $employee->email)->first();
            if ($user) {
                $user->delete();
            }

            // Delete the employee
            $employee->delete();
    
            return response()->json(['message' => 'Employee and associated user deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Employee not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to delete employee: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the employee.'], 500);
        }
    }


    public function getEmployees($company_id)
    {
        try {
            $employees = Employee::where('company_id', $company_id)->get()->makeHidden(['password']);
            return response()->json($employees);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve employees: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching employees.'], 500);
        }
    }

    public function getEmployeeById($company_id, $employee_id)
    {
        try {
            $employee = Employee::where('company_id', $company_id)
                ->where('employee_id', $employee_id)
                ->firstOrFail();

            return response()->json(['employee' => $employee], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Employee not found'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve employee: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving the employee.'], 500);
        }
    }

}
