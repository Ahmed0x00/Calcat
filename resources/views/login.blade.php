<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estate Earnings - Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/login.css">
    
</head>

<body>
    <div id="alertContainer" class="mt-3"></div>
    <div class="language-toggle">
        <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="languageDropdown" data-bs-toggle="dropdown" aria-expanded="false">
            <i class="fa-solid fa-globe"></i> Language
        </button>
        <ul class="dropdown-menu" aria-labelledby="languageDropdown">
            <li><a class="dropdown-item" onclick="setLanguage('ar');">Arabic</a></li>
            <li><a class="dropdown-item" onclick="setLanguage('en');">English</a></li>
        </ul>
    </div>

    <div class="container">
        <div class="login-container">
            <div class="login-header">
                <h2 id="sub">Login</h2>
            </div>
            <div class="login-form">
                <form id="loginForm">
                    <div class="form-group">
                        <label id="emailLogin" for="email">Email</label>
                        <input id="email" type="email"  name="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label id="passwordLogin" for="password">Password</label>
                        <div class="position-relative">
                            <input type="password" id="password" name="password" class="form-control" required>
                            <i onclick=" togglePasswordVisibility()"
                                class="fas fa-eye-slash position-absolute end-0 top-50 translate-middle-y me-3"
                                style="color: gray" id="passwordToggle"></i>
                        </div>
                    </div>
                    <button type="submit" id="LoginButton" class="btn-login">Login</button>
                </form>
                <div class="login-footer">
                    <p id="dontHaveAccountBtn">Don't have an account? <a href="register">Register now</a></p>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://kit.fontawesome.com/5e41048616.js" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
    <script src="js/login.js"></script>
    
</body>

</html>
