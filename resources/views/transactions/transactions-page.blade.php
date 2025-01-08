<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="transactionTitle">Transaction List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <style>
        .filter-container {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        @media (min-width: 576px) {
            .filter-container {
                flex-direction: row;
                align-items: center;
            }
        }

        .filter-item {
            display: flex;
            flex-direction: column;
        }

        .filter-label {
            color: grey;
            font-weight: 500;
            margin-bottom: 0.25rem;
        }

        .filter-btn-group .btn {
            margin-right: 0.5rem;
        }
    </style>
</head>

<body>
    @include('home.navbar')
    @include('transactions.create')
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 table-container bg-white shadow">
                <!-- Filters -->
                <div class="filter-container mb-3">
                    <!-- Type Filter -->
                    <div class="filter-item">
                        <label for="filterByType" class="filter-label" id="filterByTypeLabel">Filter by Type:</label>
                        <div class="btn-group filter-btn-group" role="group" aria-label="Filter by Type"
                            id="filterByType">
                            <button type="button" class="btn btn-outline-secondary filter-btn" id="filterIncomeBtn"
                                data-filter="income">Income</button>
                            <button type="button" class="btn btn-outline-secondary filter-btn" id="filterExpenseBtn"
                                data-filter="expense">Expense</button>
                            <button type="button" class="btn btn-outline-secondary filter-btn active" id="filterAllBtn"
                                data-filter="all">All</button>
                        </div>
                    </div>

                    <!-- Date Filter -->
                    <div class="filter-item">
                        <label for="filterByDate" class="filter-label" id="filterByDateLabel">Filter by Date:</label>
                        <div class="input-group w-auto" id="filterByDate">
                            <input type="date" id="transactionDateFilter" class="form-control date-filter"
                                placeholder="mm / dd / yyyy" aria-label="Filter by Date">
                        </div>
                    </div>

                    <!-- Unpaid Filter -->
                    <div class="filter-item">
                        <label for="filterUnpaid" class="filter-label" id="filterUnpaidLabel">Unpaid
                            Transactions:</label>
                        <div class="input-group w-auto" id="filterUnpaid">
                            <select id="unpaidFilter" class="form-select">
                                <option value="none">Select Filter</option>
                                <option value="today">Due Today</option>
                                <option value="month">Due by Month</option>
                            </select>
                            <select id="unpaidMonthFilter" class="form-select" style="display: none;">
                                <option value="none">Select Month</option>
                                <option value="1">January</option>
                                <option value="2">February</option>
                                <option value="3">March</option>
                                <option value="4">April</option>
                                <option value="5">May</option>
                                <option value="6">June</option>
                                <option value="7">July</option>
                                <option value="8">August</option>
                                <option value="9">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <p id="unpaidCountLabel" class="text-muted mt-1">Number of unpaid transactions: <span
                                id="unpaidCount"></span></p>
                    </div>


                </div>

                <!-- Dynamic Table Component -->
                @include('table-template', [
                    'tableId' => 'transactionTable',
                    'columns' => [
                        ['id' => 'transactionTypeHeader', 'name' => 'Transaction Type'],
                        ['id' => 'amountHeader', 'name' => 'Amount'],
                        ['id' => 'detailsHeader', 'name' => 'Details'],
                        ['id' => 'typeHeader', 'name' => 'Type'],
                        ['id' => 'NameHeader', 'name' => 'Name'],
                        ['id' => 'PhoneHeader', 'name' => 'Phone'],
                        ['id' => 'dateHeader', 'name' => 'Due Date'],
                        ['id' => 'paidHeader', 'name' => 'Paid'],
                    ],
                    'showSearch' => false,
                ])
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/TransactionsController.js"></script>
</body>

</html>
