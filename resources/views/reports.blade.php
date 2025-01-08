<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <title id="reportsTitle">Reports</title>
    <style>
        body {
            background-color: #f7f9fc;
        }

        .report-section {
            border: 1px solid #ddd;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            background: #fff;
            box-shadow: 0px 2px 5px rgba(0, 0, 0, 0.1);
        }

        .report-title {
            font-weight: bold;
            margin-bottom: 20px;
            font-size: 20px;
            color: #495057;
        }

        .filter-group {
            margin-bottom: 10px;
        }

        .filter-group label {
            font-weight: 500;
        }

        .action-buttons button {
            margin-right: 5px;
        }

        .header-note {
            background-color: #e9f7fe;
            border: 1px solid #bee5eb;
            padding: 15px;
            border-radius: 5px;
            color: #31708f;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: 500;
        }
    </style>
</head>

<body>
    @include('home.navbar')

    <div class="container mt-5">
        <h1 class="text-center mb-4">Reports</h1>

        <!-- Header Note -->
        <div class="header-note text-center">
            <p>All inputs are optional. Leave them blank to include all records in the report.</p>
        </div>

        <!-- Income Report -->
        <div class="report-section">
            <div class="report-title">Income Report</div>
            <div class="row g-3">
                <div class="col-md-3 filter-group">
                    <label for="incomeMonth">Month:</label>
                    <input type="number" id="incomeMonth" class="form-control" placeholder="MM">
                </div>
                <div class="col-md-3 filter-group">
                    <label for="incomeYear">Year:</label>
                    <input type="number" id="incomeYear" class="form-control" placeholder="YYYY">
                </div>
                <div class="col-md-6 action-buttons text-end">
                    <button class="btn btn-primary" id="printIncome">Print</button>
                    <button class="btn btn-success" id="downloadIncomeExcel">Download as Excel</button>
                </div>
            </div>
        </div>

        <!-- Expense Report -->
        <div class="report-section">
            <div class="report-title">Expense Report</div>
            <div class="row g-3">
                <div class="col-md-3 filter-group">
                    <label for="expenseMonth">Month:</label>
                    <input type="number" id="expenseMonth" class="form-control" placeholder="MM">
                </div>
                <div class="col-md-3 filter-group">
                    <label for="expenseYear">Year:</label>
                    <input type="number" id="expenseYear" class="form-control" placeholder="YYYY">
                </div>
                <div class="col-md-6 action-buttons text-end">
                    <button class="btn btn-primary" id="printExpense">Print</button>
                    <button class="btn btn-success" id="downloadExpenseExcel">Download as Excel</button>
                </div>
            </div>
        </div>

        <!-- Credit Report -->
        <div class="report-section">
            <div class="report-title">Credit Report</div>
            <div class="row g-3">
                <div class="col-md-12 action-buttons text-end">
                    <button class="btn btn-primary" id="printCredit">Print</button>
                    <button class="btn btn-success" id="downloadCreditExcel">Download as Excel</button>
                </div>
            </div>
        </div>

        <!-- Debt Report -->
        <div class="report-section">
            <div class="report-title">Debt Report</div>
            <div class="row g-3">
                <div class="col-md-12 action-buttons text-end">
                    <button class="btn btn-primary" id="printDebt">Print</button>
                    <button class="btn btn-success" id="downloadDebtExcel">Download as Excel</button>
                </div>
            </div>
        </div>

        <!-- Contractor Report -->
        <div class="report-section">
            <div class="report-title">Contractor Report</div>
            <div class="row g-3">
                <div class="col-md-6 filter-group">
                    <label for="contractorName">Name:</label>
                    <input type="text" id="contractorName" class="form-control" placeholder="Contractor Name">
                </div>
                <div class="col-md-6 action-buttons text-end">
                    <button class="btn btn-primary" id="printContractor">Print</button>
                    <button class="btn btn-success" id="downloadContractorExcel">Download as Excel</button>
                </div>
            </div>
        </div>

        <!-- Client Report -->
        <div class="report-section">
            <div class="report-title">Client Report</div>
            <div class="row g-3">
                <div class="col-md-6 filter-group">
                    <label for="clientName">Name:</label>
                    <input type="text" id="clientName" class="form-control" placeholder="Client Name">
                </div>
                <div class="col-md-6 action-buttons text-end">
                    <button class="btn btn-primary" id="printClient">Print</button>
                    <button class="btn btn-success" id="downloadClientExcel">Download as Excel</button>
                </div>
            </div>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/reports.js"></script>
</body>

</html>
