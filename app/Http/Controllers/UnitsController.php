<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Unit;
use Illuminate\Http\Request;

class UnitsController extends Controller
{
    public function getAllUnits($company_id)
    {
        $units = Unit::where('company_id', $company_id)->get();
        $totalUnits = $units->count();

        return response()->json([
            'totalUnits' => $totalUnits,
            'units' => $units
        ]);
    }

    public function getUnitById($company_id, $id)
    {
        try {
            $unit = Unit::where('company_id', $company_id)->findOrFail($id);
            return response()->json($unit);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    }

    public function createUnit(Request $request, $company_id)
    {
        $request->validate([
            'code' => 'required|string',
            'area' => 'required|numeric',
            'price' => 'required|numeric',
            'site' => 'required|string'
        ]);

        if (Unit::where('company_id', $company_id)->where('code', $request->code)->exists()) {
            return response()->json(['message' => 'Code already exists for this company'], 400);
        }
        $unit = Unit::create([
            'company_id' => $company_id,
            'code' => $request->code,
            'area' => $request->area,
            'price' => $request->price,
            'site' => $request->site,
        ]);

        return response()->json([
            'message' => 'Unit created successfully',
            'unit' => $unit
        ]);
    }

    public function updateUnit(Request $request, $company_id, $id)
    {
        try {
            $unit = Unit::where('company_id', $company_id)->findOrFail($id);

            $request->validate([
                'code' => 'required|string',
                'area' => 'required|numeric',
                'price' => 'required|numeric',
                'site' => 'required|string'
            ]);
            if (Unit::where('company_id', $company_id)->where('code', $request->code)->where('id', '!=', $id)->exists()) {
                return response()->json(['message' => 'Code already exists for this company'], 400);
            }
            
            $unit->update($request->all());
            return response()->json([
                'message' => 'Unit updated successfully',
                'unit' => $unit
            ]);

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    }

    public function deleteUnit($company_id, $id)
    {
        try {
            $unit = Unit::where('company_id', $company_id)->findOrFail($id);
            $unit->delete();

            return response()->json(['message' => 'Unit deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Unit not found'], 404);
        }
    }
}
