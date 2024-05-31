<html>
<head>
<?php require_once('header.php'); ?>
<link rel="stylesheet" href="media/css/style.css"/>
<link rel="stylesheet" href="media/css/login_style.css"/>
<?php require_once('navbar.php'); ?>
<?php require_once('connection.php'); ?>
</head>

<body>
    <div class="container">
        <div class="login-box"> 
            <h2>Login</h2>
            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="emailInput">VCU Email</label>
                    <input type="email" name="VCU_Email" placeholder="rodney@vcu.edu">
                </div>
                <div class="form-group">
                    <label for="passInput">Password</label>
                    <input type="password" name="UserPassword" placeholder="RodneyRam2024!">
                </div>
                <button type="submit">Log in</button>
                <p class="signup-prompt">Need an account? <a href="register.php">Sign up</a></p>
            </form>
        </div>
    </div>
</body>
</html>
