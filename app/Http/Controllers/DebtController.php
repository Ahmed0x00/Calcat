<?php

namespace App\Http\Controllers;

use App\Models\Debt;
use Illuminate\Http\Request;

class DebtController extends Controller
{
    public function getAll($company_id)
    {
        $debts = Debt::where('company_id', $company_id)->get();
        return response()->json($debts);
    }

    public function getByName($company_id, $name)
    {
        $debts = Debt::where('company_id', $company_id)
            ->where('client_name', $name)
            ->get();

        return response()->json($debts);
    }
}
