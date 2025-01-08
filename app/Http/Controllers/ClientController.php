<?php

namespace App\Http\Controllers;

use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ClientController extends Controller
{
    public function createClient(Request $request, $company_id)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);
        $existingClient = Client::where('company_id', $company_id)
            ->where(function ($query) use ($request) {
                $query->where('name', $request->name)
                      ->orWhere('phone', $request->phone);
            })
            ->first();

        if ($existingClient) {
            return response()->json(['message' => 'A client with the same name or phone already exists.'], 409);
        }

        $client = Client::create([
            'company_id' => $company_id,
            'name' => strip_tags($request->name),
            'phone' => $request->phone,
            'purchases_count' => 0,
            'total' => 0.0,
            'client_id' => Client::where('company_id', $company_id)->max('client_id') + 1,
        ]);

        return response()->json(['message' => 'Client created successfully', 'client' => $client], 201);
    } catch (\Exception $e) {
        Log::error("Failed to create client: " . $e->getMessage());
        return response()->json(['message' => 'An error occurred while creating the client.'], 500);
    }
}

public function updateClient(Request $request, $company_id, $client_id)
{
    try {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
        ]);

        $client = Client::where('company_id', $company_id)
            ->where('client_id', $client_id)
            ->firstOrFail();

        $existingClient = Client::where('company_id', $company_id)
            ->where(function ($query) use ($request, $client) {
                $query->where('name', $request->name)
                      ->orWhere('phone', $request->phone);
            })
            ->where('client_id', '!=', $client->client_id) // Exclude current client
            ->first();

        if ($existingClient) {
            return response()->json(['message' => 'A client with the same name or phone already exists.'], 409);
        }

        $client->name = $request->name;
        $client->phone = $request->phone;
        $client->save();

        return response()->json(['message' => 'Client updated successfully', 'client' => $client], 200);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Client not found.'], 404);
    } catch (\Exception $e) {
        Log::error("Failed to update client: " . $e->getMessage());
        return response()->json(['message' => 'An error occurred while updating the client.'], 500);
    }
}

    public function destroyClient($company_id, $client_id)
    {
        try {
            $client = Client::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->firstOrFail();

            $client->delete();

            return response()->json(['message' => 'Client deleted successfully'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Client not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to delete client: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the client.'], 500);
        }
    }

    public function getClients($company_id)
    {
        try {
            $clients = Client::where('company_id', $company_id)->get();
            return response()->json($clients);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve clients: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching clients.'], 500);
        }
    }

    public function getClientById($company_id, $client_id)
    {
        try {
            $client = Client::where('company_id', $company_id)
                ->where('client_id', $client_id)
                ->firstOrFail();

            return response()->json(['client' => $client], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Client not found.'], 404);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve client: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while retrieving the client.'], 500);
        }
    }
}
