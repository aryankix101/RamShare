<?php
session_start();

if (!isset($_SESSION['user_ID'])) {
    header('Location: login.php');
    exit;
}

require_once('header.php'); 
require_once('navbar.php'); 
$servername = "cmsc508.com";
$username = "24SP_kumawatar";
$password = "V01034333";
$database = "24SP_kumawatar_pr";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (!isset($_GET['email']) || empty(trim($_GET['email']))) {
    die('No user specified.');
}

$email = trim($_GET['email']);

try {
    $userQuery = $conn->prepare("SELECT * FROM UserProfile WHERE VCU_Email = ?");
    $userQuery->bindParam(1, $email, PDO::PARAM_STR);
    $userQuery->execute();
    $userDetails = $userQuery->fetch(PDO::FETCH_ASSOC);

    if (!$userDetails) {
        die('User not found.');
    }

    $statsQuery = $conn->prepare("SELECT COUNT(DISTINCT rr.Ride_ID) AS Total_Rides, AVG(rr.Rating) AS Average_Rating FROM Reviews_Ratings rr
                                  WHERE rr.Rider = (SELECT Rider_ID FROM Rider WHERE VCU_Email = ? LIMIT 1)
                                  OR rr.Driver = (SELECT Driver_ID FROM Driver WHERE VCU_Email = ? LIMIT 1)");
    $statsQuery->bindParam(1, $email, PDO::PARAM_STR);
    $statsQuery->bindParam(2, $email, PDO::PARAM_STR);
    $statsQuery->execute();
    $stats = $statsQuery->fetch(PDO::FETCH_ASSOC);

    if ($userDetails['Type_Of_User'] === 'driver') {
        $vehicleQuery = $conn->prepare("SELECT Model, Vehicle_Year, Color FROM Vehicle v
                                        JOIN Driver d ON v.Driver_ID = d.Driver_ID
                                        WHERE d.VCU_Email = ? LIMIT 1");
        $vehicleQuery->bindParam(1, $email, PDO::PARAM_STR);
        $vehicleQuery->execute();
        $vehicleInfo = $vehicleQuery->fetch(PDO::FETCH_ASSOC);
    }
} catch (PDOException $e) {
    die('Database error: ' . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile of <?= htmlspecialchars($userDetails['First_Name'] . ' ' . $userDetails['Last_Name']) ?></title>
    <style>
        .profile-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            width: 350px;
            padding: 20px;
            margin: auto; 
        }
        .profile-header {
            display: flex;
            align-items: center;
            margin-bottom: 20px;
        }
        .profile-header img {
            border-radius: 50%;
            margin-right: 20px;
            width: 100px;
            height: 100px;
        }
        .profile-info, .profile-stats {
            margin-bottom: 20px;
        }
        .profile-stats h2 {
            margin-top: 0;
        }
    </style>
</head>
<body>
    <div class="profile-card">
    <div class="profile-header">
    <img src="data:image/jpeg;base64,<?= base64_encode($userDetails['Profile_Picture']) ?>" alt="Profile Picture">        
    <h1><?= htmlspecialchars($userDetails['First_Name'] . ' ' . $userDetails['Last_Name']) ?></h1>
    </div>
        <p>Phone: <?= htmlspecialchars($userDetails['Phone_Number']) ?></p>
        <p>Gender: <?= htmlspecialchars($userDetails['Gender']) ?></p>
        <p>Bio: <?= htmlspecialchars($userDetails['Bio']) ?></p>

        <?php if ($vehicleInfo): ?>
            <div class="vehicle-info">
                <h2>Vehicle</h2>
                <p><?= htmlspecialchars($vehicleInfo['Color']) ?> <?= htmlspecialchars($vehicleInfo['Vehicle_Year']) ?> <?= htmlspecialchars($vehicleInfo['Model']) ?></p>
            </div>
        <?php endif; ?>

        <div class="statistics">
            <h2>Statistics</h2>
            <?php if ($userDetails['Type_Of_User'] === 'driver'): ?>
                <p><strong>Total Rides:</strong> <?= htmlspecialchars($stats['Total_Rides']) ?></p>
            <?php endif; ?>
            <p><strong>Average Rating:</strong> <?= number_format($stats['Average_Rating'], 2) ?></p>
        </div>
    </div>
</body>
</html>


