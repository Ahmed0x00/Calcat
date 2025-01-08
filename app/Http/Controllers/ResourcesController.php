<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Resource;
use Illuminate\Http\Request;

class ResourcesController extends Controller
{
    public function getAllResources($company_id)
    {
        $resources = Resource::where('company_id', $company_id)->get()->map(function ($resource) {
            $resource->price = number_format($resource->price, 0, '', ''); // Removes decimals
            return $resource;
        });

        $totalResources = $resources->count();

        return response()->json([
            'totalResources' => $totalResources,
            'resources' => $resources
        ]);
    }

    public function getResourceById($company_id, $id)
    {
        try {
            $resource = Resource::where('company_id', $company_id)->findOrFail($id);
            $resource->price = number_format($resource->price, 0, '', ''); // Removes decimals
            return response()->json($resource);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }


    public function createResource(Request $request, $company_id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'quantity' => 'required|numeric',
            'price' => 'required|numeric',
        ]);

        $name = strip_tags($request->name);
        $resource = Resource::create([
            'company_id' => $company_id,
            'name' => $name,
            'quantity' => $request->quantity,
            'price' => $request->price,
        ]);

        return response()->json([
            'message' => 'Resource created successfully',
            'resource' => $resource
        ]);
    }

    public function updateResource(Request $request, $company_id, $id)
    {
        try {
            $resource = Resource::where('company_id', $company_id)->findOrFail($id);

            $request->validate([
                'required' => 'sometimes|string|max:255', // Use 'sometimes' for optional fields
                'quantity' => 'sometimes|numeric',
                'price' => 'sometimes|numeric',
            ]);

            $name = strip_tags($request->name);
            $resource->update($request->only('name', 'quantity', 'price'));

            return response()->json([
                'message' => 'Resource updated successfully',
                'resource' => $resource
            ]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }

    public function deleteResource($company_id, $id)
    {
        try {
            $resource = Resource::where('company_id', $company_id)->findOrFail($id);
            $resource->delete();

            return response()->json(['message' => 'Resource deleted successfully']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Resource not found'], 404);
        }
    }
}
