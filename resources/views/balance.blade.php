<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title id="pageTitle">RealEstate - Balance</title>
</head>

<body>
    @include('home.navbar')

    <div class="content mt-1">
        <!-- Balance Card -->
        <div class="stat bg-success text-white rounded-3 p-3 mb-3" id="balanceCard">
            <div class="d-flex gap-2 align-items-center" id="balanceHeader">
                <i class="fa-solid fa-dollar-sign fs-4" id="balanceIcon"></i>
                <h4 class="mb-0" id="balanceTitle">Balance</h4>
            </div>
            <div id="balance" class="value display-4"></div>
        </div>

        <!-- Income, Net Income, and Expenses Cards -->
        <div class="stats d-flex gap-3" id="statsSection">
            <!-- Total Income Card -->
            <div class="stat bg-success text-white p-3 rounded-3 flex-fill" id="totalIncomeCard">
                <div class="d-flex gap-2 align-items-center" id="totalIncomeHeader">
                    <i class="fa-solid fa-arrow-trend-up fs-4" id="totalIncomeIcon"></i>
                    <h4 class="mb-0" id="totalIncomeTitle">Total Income</h4>
                </div>
                <div id="totalIncome" class="value display-4"></div>
            </div>

            <!-- Net Income Card -->
            <div class="stat bg-primary text-white p-3 rounded-3 flex-fill" id="netIncomeCard">
                <div class="d-flex gap-2 align-items-center" id="netIncomeHeader">
                    <i class="fa-solid fa-calculator fs-4" id="netIncomeIcon"></i>
                    <h4 class="mb-0" id="netIncomeTitle">Net Income</h4>
                </div>
                <div id="netIncome" class="value display-4"></div>
            </div>

            <!-- Total Expenses Card -->
            <div class="stat bg-danger text-white p-3 rounded-3 flex-fill" id="totalExpensesCard">
                <div class="d-flex gap-2 align-items-center" id="totalExpensesHeader">
                    <i class="fa-solid fa-arrow-trend-down fs-4" id="totalExpensesIcon"></i>
                    <h4 class="mb-0" id="totalExpensesTitle">Total Expenses</h4>
                </div>
                <div id="totalExpenses" class="value display-4"></div>
            </div>
        </div>

        <!-- New Section: Income and Expenses Transaction Lists -->
        <div class="container" id="transactionsSection">
            <div class="row" id="transactionsRow">
                <!-- Income Container for Last 10 Transactions -->
                <div onclick="Route('transactions?type=income')" class="chart3 col-md-6 flex-column rounded-3 gap-1 p-3 bg-white flex-fill mb-3" id="incomeTransactions">
                    <h2 id="incomeTransactionsTitle">Income - Last 10 transactions</h2>
                    <div id="lastIncomeTransactions" class="transactions-list">
                        <!-- Income transactions will be dynamically added here -->
                    </div>
                </div>

                <!-- Outcome Container for Last 10 Transactions -->
                <div onclick="Route('transactions?type=outcome')" class="chart3 col-md-6 flex-column rounded-3 gap-1 p-3 bg-white flex-fill mb-3" id="outcomeTransactions">
                    <h2 id="outcomeTransactionsTitle">Outcome - Last 10 Transactions</h2>
                    <div id="lastOutcomeTransactions" class="transactions-list">
                        <!-- Outcome transactions will be dynamically added here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/script.js"></script>
    <script src="js/balance.js"></script>
</body>

</html>
