<?php 
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', 1);
*/
require_once('header.php'); 
$servername = "cmsc508.com";
$username = "24SP_kumawatar";
$password = "V01034333";
$database = "24SP_kumawatar_pr";
try 
{
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} 
catch (PDOException $e) 
{
    echo "Connection failed: " . $e->getMessage();
}
global $conn;
if (isset($_SESSION['user_ID']) && $_SESSION['user_ID']) {
    $Session_VCU_Email = $_SESSION['user_ID'];
    $query = "SELECT Type_Of_User FROM UserProfile WHERE VCU_Email = '$Session_VCU_Email'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $userType=$stmt->fetchColumn();
    $stmt->fetch();
}

?>
<!DOCTYPE html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/navbar.css"/>
</head>
<nav class="navbar navbar-dark bg-dark py-3">
    <a class="navbar-brand brand-link" href="index.php">RamShare</a>
    <?php if (isset($_SESSION['user_ID']) && $_SESSION['user_ID']): ?>
        <div class="nav-right">
            <a class="nav-link ride-listings" href="ride_listings.php">Ride Listings</a>
            <div class="dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Account
                </a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="profile.php">Profile</a>
                    <?php if ($userType == 'driver'): ?>
                        <a class="dropdown-item" href="vehicle_registration.php">Vehicle Registration</a>
                        <a class="dropdown-item" href="create_ride.php">Create Ride</a>
                    <?php endif; ?>
                    <a class="dropdown-item" href="manage_rides.php">Manage Rides</a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    <?php else: ?>
        <a class="nav-link sign-in" href="login.php">Sign In<i class="fa-solid fa-user"></i></a>
    <?php endif; ?>
</nav>
