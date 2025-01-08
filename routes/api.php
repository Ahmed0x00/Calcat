<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'check.company', 'throttle:60,1'])->group(function () {

    // Client management routes
    Route::controller(ClientController::class)->group(function () {
        Route::get('/{company_id}/clients', 'getClients');
        Route::get('/{company_id}/clients/{id}', 'getClientById');
        Route::post('/{company_id}/clients', 'createClient');
        Route::put('/{company_id}/clients/{id}', 'updateClient');
        Route::delete('/{company_id}/clients/{id}', 'destroyClient');
    });

    // Contractor management routes
    Route::controller(ContractorController::class)->group(function () {
        Route::get('/{company_id}/contractors', 'getContractors');
        Route::get('/{company_id}/contractors/{id}', 'getContractorById');
        Route::post('/{company_id}/contractors', 'createContractor');
        Route::put('/{company_id}/contractors/{id}', 'updateContractor');
        Route::delete('/{company_id}/contractors/{id}', 'destroyContractor');
    });

    // Employee management routes (For all `employees` and the `owner`) 
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/{company_id}/employees', 'getEmployees');
        Route::get('/{company_id}/employees/{id}', 'getEmployeeById');
    });

    // Transaction management routes
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/{company_id}/transactions', 'getAllTransactions');
        Route::get('/{company_id}/transactions/{id}', 'getTransactionById');
        Route::get('/{company_id}/incomes', 'getAllIncomes');
        Route::get('/{company_id}/outcomes', 'getAllOutcomes');
        Route::delete('/{company_id}/transactions/{id}', 'deleteTransaction');
        Route::post('/{company_id}/transactions/income', 'createIncome');
        Route::post('/{company_id}/transactions/outcome', 'createOutcome');
        Route::get('/{company_id}/today-summary', 'getTodaySummary');
        Route::get('/{company_id}/year-summary', 'getYearTransactions');
        Route::get('/{company_id}/transactions/{id}/update-paid', 'updatePaidStatus');
    });

    // Report management routes
    Route::controller(ReportsController::class)->group(function () {
        Route::get('/{company_id}/reports/income', 'incomeReport');
        Route::get('/{company_id}/reports/expense', 'expenseReport');
        Route::get('/{company_id}/reports/credit', 'creditReport');
        Route::get('/{company_id}/reports/debt', 'debtReport');
        Route::get('/{company_id}/reports/contractors', 'contractorsReport');
        Route::get('/{company_id}/reports/contractors/{contractor_name}', 'contractorReport');
        Route::get('/{company_id}/reports/clients', 'clientsReport');
        Route::get('/{company_id}/reports/clients/{client_name}', 'clientReport');
    });

    // Debt Management Routes
    Route::controller(DebtController::class)->group(function () {
        Route::get('/{company_id}/debts', 'getAll');
        Route::get('/{company_id}/debts/name/{name}', 'getByName');
    });

    // Credit Management Routes
    Route::controller(CreditController::class)->group(function () {
        Route::get('/{company_id}/credits', 'getAll');
        Route::get('/{company_id}/credits/name/{name}', 'getByName');
    });

    // Unit management routes
    Route::controller(UnitsController::class)->group(function () {
        Route::get('/{company_id}/units', 'getAllUnits');
        Route::post('/{company_id}/units', 'createUnit');
        Route::get('/{company_id}/units/{id}', 'getUnitById');
        Route::put('/{company_id}/units/{id}', 'updateUnit');
        Route::delete('/{company_id}/units/{id}', 'deleteUnit');
    });

    // Resource management routes
    Route::controller(ResourcesController::class)->group(function () {
        Route::get('/{company_id}/resources', 'getAllResources');
        Route::post('/{company_id}/resources', 'createResource');
        Route::get('/{company_id}/resources/{id}', 'getResourceById');
        Route::put('/{company_id}/resources/{id}', 'updateResource');
        Route::delete('/{company_id}/resources/{id}', 'deleteResource');
    });
});

// Routes that require the `owner` middleware
// Only for `owner` of the company or an `admin` inside it
Route::middleware(['web', 'auth', 'owner', 'check.company', 'throttle:60,1'])->controller(EmployeeController::class)->group(function () {
    Route::post('/{company_id}/employees', 'createEmployee');
    Route::put('/{company_id}/employees/{id}', 'updateEmployee');
    Route::delete('/{company_id}/employees/{id}', 'destroyEmployee');
});


// Web application Admin management routes
Route::middleware(['web', 'auth', 'admin', 'throttle:60,1'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/companies', 'fetchCompanies');
        Route::post('/companies', 'createCompany');
        Route::delete('/companies/{id}', 'deleteCompanyWithRelations');
        Route::patch('/companies/{id}/block', 'blockCompany');
        Route::patch('/companies/{id}/unblock', 'unblockCompany');
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/{id}', 'show');
        Route::get('/users', 'index');
        Route::delete('/users/{id}', 'destroy');
    });
});

Route::fallback(function () {
    return response()->json(['message' => 'Invalid URL or Company ID is required.'], 404);
});
