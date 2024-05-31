<?php 
error_reporting(E_ALL);
ini_set('display_errors', 1);

require_once('header.php');
require_once('navbar.php');
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
$driverEmail = $_SESSION['user_ID'];  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $dateTimeOfRide = $_POST['dateTimeOfRide'];
    $departureAddress = $_POST['departureAddress'];
    $destinationAddress = $_POST['destinationAddress'];
    $cost = $_POST['cost'];
    $postContent = $_POST['postContent'];
    $luggage = $_POST['luggage'];
    
    $distance = 0; 

    $driverQuery = "SELECT Driver_ID FROM Driver WHERE VCU_Email = :email";
    $driverStmt = $conn->prepare($driverQuery);
    $driverStmt->bindParam(':email', $driverEmail, PDO::PARAM_STR);
    $driverStmt->execute();
    $driverRow = $driverStmt->fetch(PDO::FETCH_ASSOC);
    $driverId = $driverRow['Driver_ID'];

    $query = "INSERT INTO Ride (Driver_ID, Trip_Status, Distance, Date_Time_Ride_Posted, Date_Time_Of_Ride, Cost, Post_Content, Departure_Address, Destination_Address, Luggage)
              VALUES (:driverId, 'not started', :distance, NOW(), :dateTimeOfRide, :cost, :postContent, :departureAddress, :destinationAddress, :luggage)";
    $stmt = $conn->prepare($query);
    $stmt->bindParam(':driverId', $driverId, PDO::PARAM_INT);
    $stmt->bindParam(':distance', $distance, PDO::PARAM_INT);
    $stmt->bindParam(':dateTimeOfRide', $dateTimeOfRide, PDO::PARAM_STR);
    $stmt->bindParam(':cost', $cost, PDO::PARAM_STR);
    $stmt->bindParam(':postContent', $postContent, PDO::PARAM_STR);
    $stmt->bindParam(':departureAddress', $departureAddress, PDO::PARAM_STR);
    $stmt->bindParam(':destinationAddress', $destinationAddress, PDO::PARAM_STR);
    $stmt->bindParam(':luggage', $luggage, PDO::PARAM_STR);
    $stmt->execute();

    header("Location: ride_listings.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Ride Listing</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/create_ride.css"/>
</head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header">
                <h1>Create a New Ride</h1>
            </div>
            <div class="card-body">
                <form action="create_ride.php" method="POST" class="bg-light p-4">
                    <div class="mb-3">
                        <label for="dateTimeOfRide" class="form-label">Date and Time of Ride:</label>
                        <input type="datetime-local" id="dateTimeOfRide" name="dateTimeOfRide" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="departureAddress" class="form-label">Departure Address:</label>
                        <input type="text" id="departureAddress" name="departureAddress" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="destinationAddress" class="form-label">Destination Address:</label>
                        <input type="text" id="destinationAddress" name="destinationAddress" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="cost" class="form-label">Cost ($):</label>
                        <input type="number" id="cost" name="cost" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="postContent" class="form-label">Post Content:</label>
                        <textarea id="postContent" name="postContent" class="form-control" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="luggage" class="form-label">Luggage Restrictions:</label>
                        <input type="text" id="luggage" name="luggage" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Create Ride</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
