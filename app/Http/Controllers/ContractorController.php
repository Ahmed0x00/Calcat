<?php

namespace App\Http\Controllers;

use App\Models\Contractor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ContractorController extends Controller
{
    public function createContractor(Request $request, $company_id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'type' => 'nullable|string|max:50',
            ]);

            $existingContractor = Contractor::where('company_id', $company_id)
                ->where(function ($query) use ($request) {
                    $query->where('name', $request->name)
                          ->orWhere('phone', $request->phone);
                })
                ->first();

            if ($existingContractor) {
                return response()->json(['message' => 'A contractor with the same name or phone already exists.'], 409);
            }

            $contractor = Contractor::create([
                'company_id' => $company_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'type' => $request->type,
            ]);

            return response()->json(['message' => 'Contractor created successfully', 'contractor' => $contractor], 201);
        } catch (\Exception $e) {
            Log::error("Failed to create contractor: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while creating the contractor.'], 500);
        }
    }

    public function updateContractor(Request $request, $company_id, $contractor_id)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'phone' => 'required|string|max:15',
                'type' => 'nullable|string|max:50',
            ]);

            $contractor = Contractor::where('company_id', $company_id)
                ->where('id', $contractor_id)
                ->firstOrFail();

            $existingContractor = Contractor::where('company_id', $company_id)
                ->where(function ($query) use ($request, $contractor) {
                    $query->where('name', $request->name)
                          ->orWhere('phone', $request->phone);
                })
                ->where('id', '!=', $contractor->id)
                ->first();

            if ($existingContractor) {
                return response()->json(['message' => 'A contractor with the same name or phone already exists.'], 409);
            }

            $contractor->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'type' => $request->type,
            ]);

            return response()->json(['message' => 'Contractor updated successfully', 'contractor' => $contractor], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Contractor not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to update contractor: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while updating the contractor.'], 500);
        }
    }

    public function destroyContractor($company_id, $contractor_id)
    {
        try {
            $contractor = Contractor::where('company_id', $company_id)
                ->where('id', $contractor_id)
                ->firstOrFail();

            $contractor->delete();

            return response()->json(['message' => 'Contractor deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Contractor not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to delete contractor: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the contractor.'], 500);
        }
    }

    public function getContractors($company_id)
    {
        try {
            $contractors = Contractor::where('company_id', $company_id)->get();
            return response()->json($contractors);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve contractors: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching contractors.'], 500);
        }
    }

    public function getContractorById($company_id, $contractor_id)
    {
        try {
            $contractor = Contractor::where('company_id', $company_id)
                ->where('id', $contractor_id)
                ->firstOrFail();

            return response()->json(['contractor' => $contractor], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Contractor not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve contractor: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving the contractor.'], 500);
        }
    }
}
