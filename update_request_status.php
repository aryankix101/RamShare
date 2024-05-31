<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);
if (!isset($_SESSION['user_ID'])) {
    http_response_code(401);
    echo 'Unauthorized';
    exit;
}

$servername = "cmsc508.com";
$username = "24SP_kumawatar";
$password = "V01034333";
$database = "24SP_kumawatar_pr";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$database", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);    
} catch (PDOException $e) {
    http_response_code(500);
    echo "Connection failed: " . $e->getMessage();
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['rideId'], $_POST['riderId'], $_POST['status'])) {
    $rideId = $_POST['rideId'];
    $riderId = $_POST['riderId'];
    $status = $_POST['status'];

    try {
        $stmt = $conn->prepare("UPDATE RamShare_Request SET Request_Status = :status WHERE Ride_ID = :rideId AND Rider = :riderId");
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':rideId', $rideId, PDO::PARAM_INT);
        $stmt->bindParam(':riderId', $riderId, PDO::PARAM_STR);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Request status updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update the request status. No rows affected.']);
        }
    } catch (PDOException $e) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Required parameters are missing.']);
}

?>
