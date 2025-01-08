<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="unitsTitle">Units List</title>

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
                @include('units.create-unit') <!-- Placeholder for Unit Create Form -->
                
                <!-- Dynamic Table Component -->
                @include('table-template', [
                    'tableId' => 'unitsTable',
                    'columns' => [
                        ['id' => 'codeHeader', 'name' => 'Code'],
                        ['id' => 'areaHeader', 'name' => 'Area (sq ft)'],
                        ['id' => 'siteHeader', 'name' => 'Site'],
                        ['id' => 'priceHeader', 'name' => 'Price'],
                    ],
                    'searchPlaceholder' => 'Search for Unit Code',
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
    <script src="js/UnitsController.js"></script>
    <script src="js/script.js"></script>
</body>

</html>

