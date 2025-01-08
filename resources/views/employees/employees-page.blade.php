<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="employeeTitle">Employee List</title>

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
                @include('employees.create') <!-- Placeholder for Employee Create Form -->

                <!-- Dynamic Table Component with search enabled -->
                @include('table-template', [
                    'tableId' => 'employeeTable',
                    'columns' => [
                        ['id' => 'employeeIdHeader', 'name' => 'ID'],
                        ['id' => 'employeeNameHeader', 'name' => 'Name'],
                        ['id' => 'employeeLeaderHeader', 'name' => 'Leader'],
                        ['id' => 'employeeSalaryHeader', 'name' => 'Salary'],
                        ['id' => 'employeeEmailHeader', 'name' => 'Email'],
                        ['id' => 'employeePhoneHeader', 'name' => 'Phone'],
                        ['id' => 'employeeRoleHeader', 'name' => 'Role'],
                        ['id' => 'employeeDepartmentHeader', 'name' => 'Department'],
                    ],
                    'searchPlaceholder' => 'Search for Employee name',
                    'showSearch' => true,
                ])

            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery and Custom JS Files -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="js/EmployeesController.js"></script>
    <script src="js/script.js"></script>
</body>

</html>
