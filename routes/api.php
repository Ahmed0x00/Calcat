<?php

use App\Http\Controllers\UserController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ContractorController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UnitsController;
use App\Http\Controllers\ResourcesController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\DebtController;
use App\Http\Controllers\CreditController;
use App\Http\Controllers\ReportsController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'check.company', 'throttle:60,1'])->group(function () {

    // Client management routes
    Route::controller(ClientController::class)->group(function () {
        Route::get('/{company_id}/clients', 'getClients'); // Get all clients
        Route::get('/{company_id}/clients/{id}', 'getClientById'); // Get client by ID
        Route::post('/{company_id}/clients', 'createClient'); // Create a new client
        Route::put('/{company_id}/clients/{id}', 'updateClient'); // Update client by ID
        Route::delete('/{company_id}/clients/{id}', 'destroyClient'); // Delete client by ID
    });

    // Contractor management routes
    Route::controller(ContractorController::class)->group(function () {
        Route::get('/{company_id}/contractors', 'getContractors'); // Get all contractors
        Route::get('/{company_id}/contractors/{id}', 'getContractorById'); // Get contractor by ID
        Route::post('/{company_id}/contractors', 'createContractor'); // Create a new contractor
        Route::put('/{company_id}/contractors/{id}', 'updateContractor'); // Update contractor by ID
        Route::delete('/{company_id}/contractors/{id}', 'destroyContractor'); // Delete contractor by ID
    });


    // Employee management routes
    Route::controller(EmployeeController::class)->group(function () {
        Route::get('/{company_id}/employees', 'getEmployees'); // Get all employees
        Route::get('/{company_id}/employees/{id}', 'getEmployeeById'); // Get employee by ID
    });

    // Transaction management routes
    Route::controller(TransactionController::class)->group(function () {
        Route::get('/{company_id}/transactions', 'getAllTransactions'); // Get all transactions
        Route::get('/{company_id}/transactions/{id}', 'getTransactionById'); // Get transaction by ID
        Route::get('/{company_id}/incomes', 'getAllIncomes'); // Get all income transactions
        Route::get('/{company_id}/outcomes', 'getAllOutcomes'); // Get all outcome transactions
        Route::delete('/{company_id}/transactions/{id}', 'deleteTransaction'); // Delete a transaction by ID
        Route::post('/{company_id}/transactions/income', 'createIncome'); // Create a new income transaction
        Route::post('/{company_id}/transactions/outcome', 'createOutcome'); // Create a new outcome transaction
        Route::get('/{company_id}/today-summary', 'getTodaySummary'); // Get today's financial summary
        Route::get('/{company_id}/year-summary', 'getYearTransactions'); // Get today's financial summary
        Route::get('/{company_id}/transactions/{id}/update-paid', 'updatePaidStatus'); // Update transaction paid status
    });

    // Report management routes
    Route::controller(ReportsController::class)->group(function () {
        Route::get('/{company_id}/reports/income', 'incomeReport'); // Get income report of a month
        Route::get('/{company_id}/reports/expense', 'expenseReport'); // Get expense report of a month
        Route::get('/{company_id}/reports/credit', 'creditReport'); // Get credit report
        Route::get('/{company_id}/reports/debt', 'debtReport'); // Get debt report
        Route::get('/{company_id}/reports/contractors', 'contractorsReport'); // Get all contractors' transactions report
        Route::get('/{company_id}/reports/contractors/{contractor_name}', 'contractorReport'); // Get transactions report for a specific contractor
        Route::get('/{company_id}/reports/clients', 'clientsReport'); // Get all clients' transactions report
        Route::get('/{company_id}/reports/clients/{client_name}', 'clientReport'); // Get transactions report for a specific client
    });


    // Debt Management Routes
    Route::controller(DebtController::class)->group(function () {
        Route::get('/{company_id}/debts', 'getAll'); // Get all debts for a company
        Route::get('/{company_id}/debts/name/{name}', 'getByName'); // Get debts by client name
    });

    // Credit Management Routes
    Route::controller(CreditController::class)->group(function () {
        Route::get('/{company_id}/credits', 'getAll'); // Get all credits for a company
        Route::get('/{company_id}/credits/name/{name}', 'getByName'); // Get credits by contractor name
    });

    // Unit management routes
    Route::controller(UnitsController::class)->group(function () {
        Route::get('/{company_id}/units', 'getAllUnits'); // Get all units
        Route::post('/{company_id}/units', 'createUnit'); // Create a new unit
        Route::get('/{company_id}/units/{id}', 'getUnitById'); // Get a specific unit by ID
        Route::put('/{company_id}/units/{id}', 'updateUnit'); // Update a specific unit by ID
        Route::delete('/{company_id}/units/{id}', 'deleteUnit'); // Delete a specific unit by ID
    });

    // Resource management routes
    Route::controller(ResourcesController::class)->group(function () {
        Route::get('/{company_id}/resources', 'getAllResources'); // Get all resources
        Route::post('/{company_id}/resources', 'createResource'); // Create a new resource
        Route::get('/{company_id}/resources/{id}', 'getResourceById'); // Get a specific resource by ID
        Route::put('/{company_id}/resources/{id}', 'updateResource'); // Get a specific resource by ID
        Route::delete('/{company_id}/resources/{id}', 'deleteResource'); // Delete a specific resource by ID
    });
});

// Routes that require the 'owner' middleware in addition to 'web' and 'auth'
Route::middleware(['web', 'auth', 'owner', 'check.company', 'throttle:60,1'])->controller(EmployeeController::class)->group(function () {
    Route::post('/{company_id}/employees', 'createEmployee'); // Create a new employee
    Route::put('/{company_id}/employees/{id}', 'updateEmployee'); // Update employee by ID
    Route::delete('/{company_id}/employees/{id}', 'destroyEmployee'); // Delete employee by ID
});


Route::middleware(['web', 'auth', 'admin', 'throttle:60,1'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('/companies', 'fetchCompanies'); // Fetch all companies
        Route::post('/companies', 'createCompany'); // Create a new company
        Route::delete('/companies/{id}', 'deleteCompanyWithRelations'); // Delete a company by ID
        Route::patch('/companies/{id}/block', 'blockCompany'); // Block a company by ID
        Route::patch('/companies/{id}/unblock', 'unblockCompany'); // Unblock a company by ID
    });

    Route::controller(UserController::class)->group(function () {
        Route::get('/users/{id}', 'show'); // Get a specific user by ID
        Route::get('/users', 'index'); // Get all users
        Route::delete('/users/{id}', 'destroy'); // Delete a user by ID
    });
});

Route::fallback(function () {
    return response()->json(['message' => 'Invalid URL or Company ID is required.'], 404);
});

