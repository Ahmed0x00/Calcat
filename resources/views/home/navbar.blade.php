<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title id="dashboardTitle">Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />   
    <link rel="stylesheet" href='css/navbar.css'>
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="owner-badge"><span id="ownerBadge">{{ Auth::User()->role }}</span></div>
        </div>
            <a onclick="Route('home')" class="{{ Request::is('home') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-home"></i> <span id="dashboardLink">Dashboard</span>
            </a>
            <a onclick="Route('employees')" class="{{ Request::is('employees') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-users"></i> <span id="employeesLink">Employees</span>
            </a>
            <a onclick="Route('clients')" class="{{ Request::is('clients') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-user"></i> <span id="clientsLink">Clients</span>
            </a>
            <a onclick="Route('transactions')" class="{{ Request::is('transactions') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-file-invoice-dollar"></i> <span id="transactionsLink">Transactions</span>
            </a>
            <a onclick="Route('resources')" class="{{ Request::is('resources') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-box"></i> <span id="resourcesLink">Resources</span>
            </a>
            <a onclick="Route('units')" class="{{ Request::is('units') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-cubes"></i> <span id="unitsLink">Units</span>
            </a>
            <a onclick="Route('contractors')" class="{{ Request::is('contractors') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-hard-hat"></i> <span id="contractorsLink">Contractors</span>
            </a>
            <a onclick="Route('reports')" class="{{ Request::is('reports') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-chart-bar"></i> <span id="reportsLink">Reports</span>
            </a>
            <a onclick="Route('balance')" class="{{ Request::is('balance') ? 'active' : '' }}" style="font-size: 1.2rem;">
                <i class="fas fa-wallet"></i> <span id="balanceLink">Balance</span>
            </a>
        </div>

    <!-- Main content area -->
    <div class="navbar-container">

        <!-- Navbar -->
        <div class="navbar d-flex justify-content-between align-items-center">
            <h1><span id="appName">CALCAT</span></h1>
            <div class="right-section d-flex align-items-center gap-3">
                
                <!-- Language buttons-->
                <div class="language-toggle">
                    <button class="lang-btn" id="en-btn" onclick="setLanguage('en')">EN</button>
                    <button class="lang-btn active" id="ar-btn" onclick="setLanguage('ar')">AR</button>
                </div>

                <!-- Settings icon without a box -->
                <div class="dropdown">
                    <i class="fas fa-cog fs-4" data-bs-toggle="dropdown" aria-expanded="false" style="cursor: pointer;"></i>
                    <ul class="dropdown-menu" style="margin-left: 30px;">
                        <li>
                            <a class="dropdown-item" onclick="Route('profile')">
                                <i class="fa-regular fa-user px-2"></i>
                                <span id="profileLink">Profile</span>
                            </a>
                        </li>
                    </ul>
                </div>
                
                <!-- Red Logout icon and link -->
                <a class="logout-link" onclick="logout()" style="color: #dc3545;">
                    <i class="fas fa-sign-out-alt fs-4"></i>
                    <span id="logoutLink">Logout</span>
                </a>
            </div>
        </div>
        <div id="alertContainer" class="container my-3"></div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="js/script.js"></script>
</body>
</html>
