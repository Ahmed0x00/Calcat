<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    public function index()
    {
        try {
            $users = User::select('id', 'name', 'email', 'role', 'phone', 'actions')->get();
            return response()->json(['users' => $users]);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve users: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching users.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $user = User::findOrFail($id);
            return response()->json(['user' => $user]);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve user: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching the user.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
            return response()->json(['message' => 'User deleted successfully']);
        } catch (\Exception $e) {
            Log::error("Failed to delete user: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the user.'], 500);
        }
    }
}
