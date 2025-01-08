<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dashboardTitle">Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    @include('home.navbar')

    <div class="container mt-5">
        <!-- Top Row of Stats Cards -->
        <div class="row mb-3">
            <div class="col-md-4" onclick="Route('transactions')">
                <div class="card custom-card card-transactions" style="border-left: 5px solid #007bff;">
                    <div class="card-header">
                        <i class="fas fa-exchange-alt"></i>
                        <span id="todayTransactions">Today's Transactions</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-value" id="transactions-value">123132</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4" onclick="Route('transactions?type=income')">
                <div class="card custom-card card-income" style="border-left: 5px solid #28a745;">
                    <div class="card-header">
                        <i class="fas fa-arrow-up"></i>
                        <span id="todayIncome">Today's Income</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-value" id="income-value">123132</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-4" onclick="Route('transactions?type=outcome')">
                <div class="card custom-card card-expense" style="border-left: 5px solid #dc3545;">
                    <div class="card-header">
                        <i class="fas fa-arrow-down"></i>
                        <span id="todayExpense">Today's Expense</span>
                    </div>
                    <div class="card-body">
                        <h3 class="card-value" id="expense-value">123132</h3>
                    </div>
                </div>
            </div>
        </div>
    
        <!-- Bottom Row of Charts -->
        <div class="row">
            <div class="col-md-8">
                <div class="card h-100 chart-container">
                    <div class="card-body">
                        <h5 id="yearsTransactions">Year's Transactions</h5>
                        <canvas id="barChart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card h-100 chart-container">
                    <div class="card-body">
                        <h5 class="card-title" id="incomeVsExpense">Income vs Expense (Today)</h5>
                        <canvas id="pieChart"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="js/script.js"></script>
<script src="js/home.js"></script>
<script src="js/chart.js"></script>
</body>

</html>
