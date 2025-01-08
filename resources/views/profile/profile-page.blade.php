<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title id="profilePageTitle">Profile</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css" />
    </head>
    
<body>

@include('home.navbar')

<div id="alertContainer">
    @include('profile.change-password')
</div>

<div class="content mt-3">
    <div class="row gap-3">
        <!-- Name Card -->
        <div class="col-sm-3">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-dark" >
                        <i class="fas fa-user text-secondary"></i> <span id="userNameHeader"></span>
                    </h5>
                    <p class="card-text text-secondary" id="userName"></p>
                </div>
            </div>
        </div>

        <!-- Email Card -->
        <div class="col-sm-3">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-dark">
                        <i class="fas fa-envelope text-secondary"></i> <span id="userEmailHeader"></span>
                    </h5>
                    <p class="card-text text-secondary" id="userEmail"></p>
                </div>
            </div>
        </div>

        <!-- Role Card -->
        <div class="col-sm-3">
            <div class="card shadow-sm p-3 mb-5 bg-white rounded">
                <div class="card-body">
                    <h5 class="card-title text-dark">
                        <i class="fas fa-user-tag text-secondary"></i> <span id="userRoleHeader"></span>
                    </h5>
                    <p class="card-text text-secondary" id="userRole"></p>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Optional Cards for Employee-specific fields -->
    <div class="row gap-3" id="optionalCards"></div>

    <!-- Change Password Button -->
    <button id="changePassword" type="button" class="btn btn-lg btn-outline-dark ms-3 export-btn" data-bs-toggle="modal" data-bs-target="#changePasswordModal">
        Change Password
    </button>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="js/profile.js"></script>
</body>
</html>
