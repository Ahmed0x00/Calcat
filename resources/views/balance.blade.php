<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/balance.css">
    <title id="pageTitle">Balance</title>
</head>

<body>
    @include('home.navbar')

    <div class="content">
        <div class="stats-container">
            <div class="stat bg-gradient-green">
                <h4>Balance</h4>
                <p id="balance" class="value">0</p>
            </div>
            <div class="stat bg-gradient-green">
                <h4>Total Income</h4>
                <p id="totalIncome" class="value">0</p>
            </div>
            <div class="stat bg-gradient-blue">
                <h4>Net Income</h4>
                <p id="netIncome" class="value">0</p>
            </div>
            <div class="stat bg-gradient-red">
                <h4>Total Expenses</h4>
                <p id="totalExpenses" class="value">0</p>
            </div>
        </div>
        
    
        <div class="transactions-section">
            <div class="chart income-chart">
                <h5>Income - Last 10 Transactions</h5>
                <div id="lastIncomeTransactions" class="transaction-list"></div> <!-- Container for income transactions -->
            </div>
        
            <div class="chart expense-chart">
                <h5>Outcome - Last 10 Transactions</h5>
                <div id="lastOutcomeTransactions" class="transaction-list"></div> <!-- Container for expense transactions -->
            </div>
        </div>
        
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/balance.js"></script>
</body>

</html>
