<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="clientTitle">Client List</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/table.css') }}">
</head>

<body>
    @include('home.navbar')

    <div class="container-fluid">
        <div class="row">
            <div class="col-12 table-container bg-white shadow">
                @include('clients.create') 
                @include('table-template', [
                    'tableId' => 'clientTable',
                    'columns' => [
                        ['id' => 'clientNameHeader', 'name' => 'Name'],
                        ['id' => 'clientPhoneHeader', 'name' => 'Phone'],
                        ['id' => 'clientPurchasesHeader', 'name' => 'Purchases'],
                        ['id' => 'clientTotalHeader', 'name' => 'Total'],
                    ],
                    'searchPlaceholder' => 'Search for Client name',
                    'showSearch' => true,
                ])
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/ClientsController.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
