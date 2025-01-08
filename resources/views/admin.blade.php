<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Companies List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">

    <style>
        .add-btn { color: #fff; height: 38px; }
        .table-container { padding: 20px; margin-top: 20px; }
    </style>
</head>
<body>

@include('home.navbar') 
<div id="alertContainer"></div>
<div class="container-fluid">
    <div class="row">
        <div class="col-12 table-container bg-white shadow"> <!-- Removed col-md-10 -->
            @include('table-template', [
                'tableId' => 'companyTable',
                'columns' => [
                    ['id' => 'owner_name', 'name' => 'Owner Name'],
                    ['id' => 'email', 'name' => 'Email'],
                    ['id' => 'license_key', 'name' => 'License Key'],
                    ['id' => 'blocked', 'name' => 'Blocked'],
                    ['id' => 'valid_until', 'name' => 'Valid Until'],
                ],
                'searchPlaceholder' => 'Search for Owner Name or Email',
                'showSearch' => true,
            ])
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/a000000000000.js"></script>
<script src="js/script.js"></script>
</body>
</html>
