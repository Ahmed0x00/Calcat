<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="contractorTitle">Contractor List</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Table Styles -->
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
</head>

<body>
    @include('home.navbar') <!-- Placeholder for Navbar -->

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 table-container bg-white shadow">
                @include('contractors.create') <!-- Placeholder for Contractor Create Form -->

                <!-- Dynamic Table Component with search enabled -->
                @include('table-template', [
                    'tableId' => 'contractorTable',
                    'columns' => [
                        ['id' => 'contractorNameHeader', 'name' => 'Name'],
                        ['id' => 'contractorPhoneHeader', 'name' => 'Phone'],
                        ['id' => 'contractorTypeHeader', 'name' => 'Type'],
                        ['id' => 'contractorBillsHeader', 'name' => 'Bills'],
                        ['id' => 'contractorTotalHeader', 'name' => 'Total'],
                    ],
                    'searchPlaceholder' => 'Search for Contractor name',
                    'showSearch' => true,
                ])
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle (includes Popper.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Additional JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Custom JS Files -->
    <script src="js/ContractorsController.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
