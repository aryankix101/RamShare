<?php
session_start();
error_reporting(E_ALL);
require_once('header.php');
require_once('navbar.php');
ini_set('display_errors', 1);

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

$query = "SELECT Ride.*, UserProfile.First_Name, UserProfile.Last_Name, UserProfile.Profile_Picture, UserProfile.VCU_Email 
          FROM Ride 
          JOIN Driver ON Ride.Driver_ID = Driver.Driver_ID
          JOIN UserProfile ON Driver.VCU_Email = UserProfile.VCU_Email
          ORDER BY Date_Time_Ride_Posted DESC";

$stmt = $conn->prepare($query);
$stmt->execute();
$rides = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Rides</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/ride_listings.css"/>
</head>
<body>
<div class="container my-4">
    <h1 class="text-center mb-3">Available Rides</h1>
    <div class="row">
        <?php foreach ($rides as $ride): ?>
        <div class="col-md-4 mb-4">
            <div class="card">
                <img src="data:image/jpeg;base64,<?= base64_encode($ride['Profile_Picture']) ?>" class="card-img-top" alt="Driver Image" style="width: 100%; height: 130px; object-fit: scale-down;">
                <div class="card-body">
                    <h5 class="card-title">
                        <a href="user_info.php?email=<?= urlencode($ride['VCU_Email']) ?>">
                            <?= htmlspecialchars($ride['First_Name'] . ' ' . $ride['Last_Name']); ?>
                        </a>
                    </h5>
                    <p class="card-text">
                        <strong>From:</strong> <?= htmlspecialchars($ride['Departure_Address']); ?><br>
                        <strong>To:</strong> <?= htmlspecialchars($ride['Destination_Address']); ?><br>
                        <strong>On:</strong> <?= date("F j, Y, g:i a", strtotime($ride['Date_Time_Of_Ride'])); ?><br>
                        <strong>Cost:</strong> $<?= number_format($ride['Cost'], 2); ?><br>
                        <strong>Luggage:</strong> <?= htmlspecialchars($ride['Luggage']); ?><br>
                        <strong>Details:</strong> <?= htmlspecialchars($ride['Post_Content']); ?>
                    </p>
                    <?php if ($userType == 'rider'): ?>
                    <button class="btn btn-primary" onclick="requestRide(<?= $ride['Ride_ID']; ?>)">Request Ride</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js"></script>
<script>
function requestRide(rideId) {
    fetch('request_ride.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: 'rideId=' + rideId
    })
    .then(response => response.json())
    .then(data => alert("Success!" + data.message));
}
</script>
</body>
</html>

