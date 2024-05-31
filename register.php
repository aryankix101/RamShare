<?php
require_once('navbar.php');
require_once('header.php');
if (isset($_SESSION['user_ID'])) {
    header('Location: index.php');
    exit;
} 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Form</title>
    <script src="media/js/register.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/register.css"/>
</head>
<body>
    <div class="container d-flex justify-content-center align-items-center vh-100">
        <div id="registration" style="width: 30rem;">
            <h2 class="text-center mb-4">Register for an Account</h2>
            <form class="form" id="register-form" method="POST">
                <div class="form-group">
                    <input type="text" class="form-control" id="First_Name" placeholder="First Name:">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="Middle_Name" placeholder="Middle Name:">
                </div>
                <div class="form-group">
                    <input type="text" class="form-control" id="Last_Name" placeholder="Last Name:">
                </div>
                <div class="form-group">
                    <input type="email" class="form-control" id="VCU_Email" placeholder="Email:">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="UserPassword" placeholder="Password:">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" id="repeat_password" placeholder="Repeat Password:">
                </div>
                <div class="form-btn">
                    <button type="submit" class="btn btn-primary" name="register" id="register">Register</button>
                </div>
            </form>
            <div><p class="text-center">Already Registered? <a href="login.php">Login Here</a></p></div>
        </div>
    </div>
    <div id="alert-container"></div>
</body>
</html>

