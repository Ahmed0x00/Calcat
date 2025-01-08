<?php

namespace App\Http\Controllers;

use App\Models\Credit;
use Illuminate\Http\Request;

class CreditController extends Controller
{
    public function getAll($company_id)
    {
        $credits = Credit::where('company_id', $company_id)->get();
        return response()->json($credits);
    }

    public function getByName($company_id, $name)
    {
        $credits = Credit::where('company_id', $company_id)
            ->where('contractor_name', $name)
            ->get();

        return response()->json($credits);
    }
}
