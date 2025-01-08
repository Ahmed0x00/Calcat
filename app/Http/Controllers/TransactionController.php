<?php

namespace App\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Models\Transaction;
use App\Models\Company;
use App\Models\Client;
use App\Models\Contractor;
use App\Models\Credit;
use App\Models\Debt;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Traits\HandlesModelNotFound;
use Illuminate\Support\Facades\Log;

class TransactionController extends Controller
{
    use HandlesModelNotFound;

    public function getAllTransactions($company_id)
    {
        $transactions = Transaction::where('company_id', $company_id)
            ->orderBy('id', 'desc')  // Sort by id in descending order
            ->get();
        $totalTransactions = $transactions->count();

        return response()->json([
            'totalTransactions' => $totalTransactions,
            'transactions' => $transactions
        ]);
    }

    public function getTransactionById($company_id, $transaction_id)
    {
        try {
            $transaction = Transaction::where('company_id', $company_id)
                ->where('transaction_id', $transaction_id)
                ->firstOrFail();

            return response()->json($transaction);
        } catch (ModelNotFoundException $e) {
            return $this->returnNotFound('Transaction');
        }
    }

    public function deleteTransaction($company_id, $id)
    {
        try {
            $transaction = Transaction::findOrFail($id);
            if ($transaction->company_id !== $company_id) {
                return response()->json(['message' => 'Transaction does not belong to this company'], 403);
            }
    
            $company = Company::where('company_id', $company_id)->firstOrFail();
            if (!$transaction->paid) {
                $this->deleteRelatedRecords($transaction->id); // Delete related records
                $transaction->delete();
                return response()->json(['message' => 'Transaction deleted successfully']);
            }
    
            if ($transaction->type_of_trans === 'income') {
                $company->balance -= $transaction->amount;
                if ($transaction->name) {
                    $client = Client::where('company_id', $company_id)
                        ->where('name', $transaction->name)
                        ->first();
    
                    if ($client) {
                        $client->decrement('purchases_count');
                        $client->total -= $transaction->amount;
                        $client->save();
                        Log::info("Client {$client->name} updated after deleting income transaction.");
                    }
                }
            }
    
            if ($transaction->type_of_trans === 'outcome') {
                $company->balance += $transaction->amount;
                if ($transaction->name) {
                    $contractor = Contractor::where('company_id', $company_id)
                        ->where('name', $transaction->name)
                        ->first();
    
                    if ($contractor) {
                        $contractor->decrement('bills');
                        $contractor->total -= $transaction->amount;
                        $contractor->save();
                        Log::info("Contractor {$contractor->name} updated after deleting outcome transaction.");
                    }
                }
            }
            $company->save();
            $this->deleteRelatedRecords($transaction->id);
            $transaction->delete();
            return response()->json(['message' => 'Transaction deleted successfully']);
    
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Transaction not found'], 404);
        } catch (\Exception $e) {
            Log::error("Error deleting transaction: " . $e->getMessage());
            return response()->json(['message' => 'An error occurred while deleting the transaction.'], 500);
        }
    }

    private function deleteRelatedRecords($transactionId)
    {
        try {
            Credit::where('transaction_id', $transactionId)->delete();
            Debt::where('transaction_id', $transactionId)->delete();
            Log::info("Related records in credits and debts deleted for transaction ID: $transactionId.");
        } catch (\Exception $e) {
            Log::error("Error deleting related records for transaction ID $transactionId: " . $e->getMessage());
        }
    }
    
    public function createIncome(Request $request, $company_id)
    {
        return $this->createTransaction($request, $company_id, 'income');
    }
    public function createOutcome(Request $request, $company_id)
    {
        return $this->createTransaction($request, $company_id, 'outcome');
    }

    public function createTransaction(Request $request, $company_id, $type_of_trans)
{
    try {
        $request->validate([
            'amount' => 'required|numeric',
            'type' => 'required|string',
            'name' => 'nullable|string',
            'phone' => 'nullable|string',
            'details' => 'nullable|string',
            'date' => 'nullable|date',
        ]);

        Log::info("Starting transaction creation for company ID: {$company_id} - Type: {$type_of_trans}");
        $company = Company::where('company_id', $company_id)->first();
        $transactionDate = $request->has('date') ? Carbon::parse($request->date) : Carbon::today();
        $isPaid = $transactionDate <= Carbon::today();

        if ($type_of_trans === 'outcome' && $isPaid && $request->amount > $company->balance) {
            Log::warning("Insufficient balance for outcome transaction. Company ID: {$company_id}, Balance: {$company->balance}, Requested Amount: {$request->amount}");
            return response()->json([
                'message' => 'Insufficient balance for this transaction.',
                'balance' => $company->balance,
            ], 400);
        }

        $lastTransaction = Transaction::where('company_id', $company_id)->orderBy('transaction_id', 'desc')->first();
        $newTransactionId = $lastTransaction ? $lastTransaction->transaction_id + 1 : 1;

        Log::info("New transaction ID generated: {$newTransactionId}");
        $data = [
            'transaction_id' => $newTransactionId,
            'company_id' => $company_id,
            'type_of_trans' => $type_of_trans,
            'amount' => $request->amount,
            'type' => $request->type,
            'details' => $request->details,
            'due_date' => $transactionDate,
            'name' => $request->name,
            'phone' => $request->phone,
            'paid' => $isPaid,
        ];

        $transaction = Transaction::create($data);
        Log::info("Transaction created successfully with ID: {$transaction->transaction_id}");
        if ($isPaid) {
            $company->balance += $type_of_trans === 'income'
                ? $request->amount
                : -$request->amount;
            $company->save();
            Log::info("Company balance updated. New balance: {$company->balance}");
        } else {
            if ($type_of_trans === 'income') {
                $this->handleClientAndDebt($transaction, $company, false);
            } elseif ($type_of_trans === 'outcome') {
                $this->handleContractorAndCredit($transaction, $company, false);
            }
        }

        $this->updateRelatedData($type_of_trans, $company_id, $request, $isPaid);
        return response()->json([
            'message' => ucfirst($type_of_trans) . ' transaction created successfully',
            'transaction' => $transaction,
            'balance' => $company->balance,
        ]);

    } catch (\Exception $e) {
        Log::error("Error occurred while creating {$type_of_trans} transaction: " . $e->getMessage());
        return response()->json([
            'message' => "An error occurred while creating {$type_of_trans} transaction"
        ], 500);
    }
}

    /**
     * Update related data (client or contractor) based on the transaction type.
     */
    private function updateRelatedData($type_of_trans, $company_id, $request, $isPaid)
    {
        // for income type (clients)
        if ($type_of_trans === 'income' && $request->name) {
            $client = Client::where('company_id', $company_id)
                ->where('name', $request->name)
                ->first();

            if ($client) {
                Log::info("Updating client information for client: {$client->name}");
                if ($isPaid) {
                    $client->increment('purchases_count');
                    $client->total += $request->amount;
                    $client->save();
                }
            } else {
                Log::info("Client not found for name: {$request->name}");
            }
        }

        if ($type_of_trans === 'outcome' && $request->name) {
            $contractor = Contractor::where('company_id', $company_id)
                ->where('name', $request->name)
                ->first();

            if ($contractor) {
                Log::info("Updating contractor information for contractor: {$contractor->name}");
                if ($isPaid) {
                    $contractor->increment('bills');
                    $contractor->total += $request->amount;
                    $contractor->save();
                }
            } else {
                Log::info("Contractor not found for name: {$request->name}");
            }
        }
    }

    public function updatePaidStatus($company_id, $transaction_id)
{
    try {
        $transaction = Transaction::where('company_id', $company_id)
            ->where('transaction_id', $transaction_id)
            ->firstOrFail();

        $company = Company::where('company_id', $company_id)->firstOrFail();

        if (!$transaction->paid) {
            $transaction->paid = true;
            if ($transaction->type_of_trans === 'income') {
                $this->handleClientAndDebt($transaction, $company, true);
            } elseif ($transaction->type_of_trans === 'outcome') {
                $this->handleContractorAndCredit($transaction, $company, true);
            }

            $transaction->save();
            $company->save();
            return response()->json([
                'message' => 'Transaction marked as paid successfully',
                'transaction' => $transaction,
                'balance' => $company->balance,
            ]);
        }

        return response()->json([
            'error' => 'You can\'t update paid status to not paid'
        ]);
    } catch (ModelNotFoundException $e) {
        return response()->json(['message' => 'Transaction not found'], 404);
    } catch (\Exception $e) {
        Log::error("Error updating transaction paid status: {$e->getMessage()}");
        return response()->json(['message' => 'An error occurred'], 500);
    }
}

    private function handleClientAndDebt($transaction, $company, $isPaid)
{
    $client = $transaction->name 
        ? Client::where('company_id', $transaction->company_id)
            ->where('name', $transaction->name)
            ->first() 
        : null;

    if ($isPaid) {
        if ($client) {
            $client->increment('purchases_count');
            $client->increment('total', $transaction->amount);
            $client->save();
        }
        $company->balance += $transaction->amount;

        Debt::where('transaction_id', $transaction->id)->delete();
    } else {
        if ($client) {
            $client->decrement('purchases_count');
            $client->decrement('total', $transaction->amount);
            $client->save();
        }
        $company->balance -= $transaction->amount;

        // Add transaction to debts table
        Debt::create([
            'company_id' => $transaction->company_id,
            'amount' => $transaction->amount,
            'details' => $transaction->details,
            'type' => $transaction->type,
            'client_name' => $transaction->name,
            'client_phone' => $transaction->phone,
            'due_date' => $transaction->due_date,
            'transaction_id' => $transaction->id,
        ]);
    }
}

private function handleContractorAndCredit($transaction, $company, $isPaid)
{
    $contractor = $transaction->name 
        ? Contractor::where('company_id', $transaction->company_id)
            ->where('name', $transaction->name)
            ->first() 
        : null;

    if ($isPaid) {
        if ($contractor) {
            $contractor->increment('bills');
            $contractor->increment('total', $transaction->amount);
            $contractor->save();
        }
        $company->balance -= $transaction->amount;

        // Remove transaction from credits table
        Credit::where('transaction_id', $transaction->id)->delete();
    } else {
        if ($contractor) {
            $contractor->decrement('bills');
            $contractor->decrement('total', $transaction->amount);
            $contractor->save();
        }
        $company->balance += $transaction->amount;

        Credit::create([
            'company_id' => $transaction->company_id,
            'amount' => $transaction->amount,
            'details' => $transaction->details,
            'type' => $transaction->type,
            'contractor_name' => $transaction->name,
            'contractor_phone' => $transaction->phone,
            'due_date' => $transaction->due_date,
            'transaction_id' => $transaction->id,
        ]);
    }
}

    public function getAllIncomes($company_id)
    {
        $incomes = Transaction::where('company_id', $company_id)->where('type_of_trans', 'income')->get();
        $totalIncomes = $incomes->sum('amount');

        return response()->json([
            'totalIncomes' => number_format($totalIncomes, 0, '.', ','),
            'incomes' => $incomes
        ]);
    }

    public function getAllOutcomes($company_id)
    {
        $outcomes = Transaction::where('company_id', $company_id)->where('type_of_trans', 'outcome')->get();
        $totalOutcomes = $outcomes->sum('amount');

        return response()->json([
            'totalExpenses' => number_format($totalOutcomes, 0, '.', ','),
            'outcomes' => $outcomes
        ]);
    }

    public function getTodaySummary($company_id)
    {
        $today = Carbon::today();
        $transactions = Transaction::where('company_id', $company_id)->whereDate('created_at', $today)->get();
        $income = $transactions->where('type_of_trans', 'income')->sum('amount');
        $expenses = $transactions->where('type_of_trans', 'outcome')->sum('amount');
        $company = Company::where('company_id', $company_id)->first();
        $balance = $company->balance;
        
        $lastTransactions = Transaction::where('company_id', $company_id)->latest()->take(12)->get()->map(function ($transaction) {
            $transaction->amount = number_format($transaction->amount, 0, '.', ',');
            return $transaction;
        });

        $lastIncomeTransactions = Transaction::where('company_id', $company_id)->where('type_of_trans', 'income')->latest()->take(10)->get()->map(function ($transaction) {
            $transaction->amount = number_format($transaction->amount, 0, '.', ',');
            return $transaction;
        });

        $lastOutcomeTransactions = Transaction::where('company_id', $company_id)->where('type_of_trans', 'outcome')->latest()->take(10)->get()->map(function ($transaction) {
            $transaction->amount = number_format($transaction->amount, 0, '.', ',');
            return $transaction;
        });

        return response()->json([
            'todayTransactions' => $transactions->count() > 0 ? $transactions->count() : 'N/A',
            'todayIncome' => $income > 0 ? number_format($income, 0, '.', ',') : 'N/A',
            'todayExpenses' => $expenses > 0 ? number_format($expenses, 0, '.', ',') : 'N/A',
            'balance' => $balance > 0 ? number_format((int) $balance, 0, '.', ',') : 'N/A',
            'lastTransactions' => $lastTransactions,
            'lastIncomeTransactions' => $lastIncomeTransactions,
            'lastOutcomeTransactions' => $lastOutcomeTransactions
        ]);
    }

    public function getYearTransactions($company_id)
    {
        $year = Carbon::now()->year;
        $monthlySummary = [];

        for ($month = 1; $month <= 12; $month++) {
            $monthlyIncome = Transaction::where('company_id', $company_id)
                ->where('type_of_trans', 'income')
                ->whereYear('due_date', $year)
                ->whereMonth('due_date', $month)
                ->sum('amount');

            $monthlyExpense = Transaction::where('company_id', $company_id)
                ->where('type_of_trans', 'outcome')
                ->whereYear('due_date', $year)
                ->whereMonth('due_date', $month)
                ->sum('amount');

            $netIncome = $monthlyIncome - $monthlyExpense;
            $monthlySummary[] = [
                'month' => Carbon::createFromDate(null, $month)->format('F'),
                'income' => number_format($monthlyIncome, 0, '.', ','),
                'expenses' => number_format($monthlyExpense, 0, '.', ','),
                'netIncome' => number_format($netIncome, 0, '.', ',')
            ];
        }

        return response()->json([
            'year' => $year,
            'monthlySummary' => $monthlySummary
        ]);
    }
}
