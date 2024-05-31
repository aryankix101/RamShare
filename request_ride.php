<?php
session_start();
error_reporting(E_ALL);
require_once('header.php');
require_once('navbar.php');
ini_set('display_errors', 1);

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


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rideId = $_POST['rideId'];
    $riderEmail = $_SESSION['user_ID']; 

    $query = "INSERT INTO RamShare_Request (Ride_ID, Rider, Request_Status, Time_Request_Was_Made) VALUES (?, ?, 'pending', NOW())";
    $stmt = $conn->prepare($query);
    $stmt->execute([$rideId, $riderEmail]);

    echo json_encode(['message' => 'Request submitted successfully']);
}
?>
