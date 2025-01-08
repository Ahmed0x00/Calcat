<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Models\Employee;
use App\Models\Credit;
use App\Models\Debt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReportsController extends Controller
{
    // Helper method to query and format transactions
    private function queryTransactions($company_id, $type, $filters = [], $fields = ['*'], $excludePaid = false)
    {
        try {
            $query = Transaction::where('company_id', $company_id)
                ->where('type_of_trans', $type);

            foreach ($filters as $key => $value) {
                if ($key === 'month') $query->whereMonth('due_date', $value);
                if ($key === 'year') $query->whereYear('due_date', $value);
                if ($key === 'paid') $query->where('paid', $value);
                if ($key === 'name') $query->where('name', $value);
            }

            $transactions = $query->get($fields);

            if ($transactions->isEmpty()) {
                return ['error' => 'No data found for the specified filters.'];
            }

            // Transform paid field only if it's included
            if (!$excludePaid) {
                $transactions->map(function ($transaction) {
                    $transaction->paid = $transaction->paid ? 'yes' : 'no';
                    return $transaction;
                });
            }

            return $transactions;
        } catch (\Exception $e) {
            Log::error("Error querying transactions: " . $e->getMessage());
            return ['error' => 'An error occurred while fetching transactions. Please try again later.'];
        }
    }

    public function incomeReport(Request $request, $company_id)
    {
        $filters = [
            'month' => $request->query('month', now()->month),
            'year' => $request->query('year', now()->year),
            'paid' => true,
        ];
        $transactions = $this->queryTransactions(
            $company_id,
            'income',
            $filters,
            ['amount', 'details', 'type', 'name', 'phone', 'due_date'],
            true
        );

        if (isset($transactions['error'])) {
            return response()->json(['message' => $transactions['error']], 404);
        }

        return response()->json([
            'data' => $transactions,
            'total_income' => $transactions->sum('amount'),
        ]);
    }

    public function expenseReport(Request $request, $company_id)
    {
        $filters = [
            'month' => $request->query('month', now()->month),
            'year' => $request->query('year', now()->year),
            'paid' => true,
        ];
        $transactions = $this->queryTransactions(
            $company_id,
            'outcome',
            $filters,
            ['amount', 'details', 'type', 'name', 'phone', 'due_date'],
            true
        );

        if (isset($transactions['error'])) {
            return response()->json(['message' => $transactions['error']], 404);
        }

        return response()->json([
            'data' => $transactions,
            'total_outcome' => $transactions->sum('amount'),
            'total_salaries' => Employee::where('company_id', $company_id)->sum('salary'),
        ]);
    }

    // Generic Report Method for Contractors and Clients
    private function entityReport($company_id, $type, $name = null)
    {
        try {
            $filters = $name ? ['name' => $name] : [];
            $transactions = $this->queryTransactions(
                $company_id,
                $type,
                $filters,
                ['amount', 'details', 'type', 'name', 'phone', 'due_date', 'paid']
            );

            if (isset($transactions['error'])) {
                return response()->json(['message' => $transactions['error']], 404);
            }

            if ($name && $transactions->isEmpty()) {
                return response()->json(['message' => ucfirst($type) . " transactions for '$name' not found."], 404);
            }

            return response()->json(['data' => $transactions]);
        } catch (\Exception $e) {
            Log::error("Error generating entity report: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred. Please try again later.'], 500);
        }
    }

    public function contractorsReport($company_id)
    {
        return $this->entityReport($company_id, 'outcome');
    }

    public function contractorReport($company_id, $contractor_name)
    {
        return $this->entityReport($company_id, 'outcome', $contractor_name);
    }

    public function clientsReport($company_id)
    {
        return $this->entityReport($company_id, 'income');
    }

    public function clientReport($company_id, $client_name)
    {
        return $this->entityReport($company_id, 'income', $client_name);
    }

    public function creditReport($company_id)
    {
        try {
            $credits = Credit::where('company_id', $company_id)
                ->get(['amount', 'details', 'type', 'contractor_name', 'contractor_phone', 'due_date']);

            if ($credits->isEmpty()) {
                return response()->json(['message' => 'No credit records found.'], 404);
            }

            return response()->json(['data' => $credits]);
        } catch (\Exception $e) {
            Log::error("Error fetching credit report: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching credits.'], 500);
        }
    }

    public function debtReport($company_id)
    {
        try {
            $debts = Debt::where('company_id', $company_id)
                ->get(['amount', 'details', 'type', 'client_name', 'client_phone', 'due_date']);

            if ($debts->isEmpty()) {
                return response()->json(['message' => 'No debt records found.'], 404);
            }

            return response()->json(['data' => $debts]);
        } catch (\Exception $e) {
            Log::error("Error fetching debt report: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while fetching debts.'], 500);
        }
    }
}
