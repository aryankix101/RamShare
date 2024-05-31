<?php
session_start();
$driverEmail = $_SESSION['user_ID'];  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    require_once 'connection.php';
    
    $dateTimeOfRide = $_POST['dateTimeOfRide'];
    $departureAddress = $_POST['departureAddress'];
    $destinationAddress = $_POST['destinationAddress'];
    $cost = $_POST['cost'];
    $postContent = $_POST['postContent'];
    $luggage = $_POST['luggage'];
    
    // Calculating distance - need to be done
    $distance = 0; 

    $query = "INSERT INTO Ride (Driver, Trip_Status, Distance, Date_Time_Ride_Posted, Date_Time_Of_Ride, Cost, Post_Content, Departure_Address, Destination_Address, Luggage)
              VALUES (?, 'not started', ?, NOW(), ?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->execute([$driverEmail, $distance, $dateTimeOfRide, $cost, $postContent, $departureAddress, $destinationAddress, $luggage]);

    header("Location: view_rides.php");
    exit;
}
?>
