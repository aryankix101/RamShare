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

$licensePlate = $_POST['licenseplate'];
$state = $_POST['state'];
$model = $_POST['model'];
$year = date("Y", strtotime($_POST["year"]));
$color = $_POST['color'];
$driverEmail = $_SESSION['user_ID'];

$sqlQueryGetDriverID = $conn->prepare("SELECT Driver_ID FROM Driver WHERE VCU_Email = ?");
$sqlQueryGetDriverID->bindParam(1, $driverEmail, PDO::PARAM_STR);
$sqlQueryGetDriverID->execute();
$driverResult = $sqlQueryGetDriverID->fetch(PDO::FETCH_ASSOC);

$driver_ID = $driverResult['Driver_ID'];

$sqlQuery = "INSERT INTO Vehicle (License_Plate, Vehicle_State, Model, Vehicle_Year, Color, Driver_ID) VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($sqlQuery);
$stmt->bindParam(1, $licensePlate, PDO::PARAM_STR);
$stmt->bindParam(2, $state, PDO::PARAM_STR);
$stmt->bindParam(3, $model, PDO::PARAM_STR);
$stmt->bindParam(4, $year, PDO::PARAM_STR);
$stmt->bindParam(5, $color, PDO::PARAM_STR);
$stmt->bindParam(6, $driver_ID, PDO::PARAM_INT);

if ($stmt->execute()) {
    http_response_code(200);
    echo 'Vehicle registered successfully';
} else {
    http_response_code(500);
    echo 'Error registering vehicle';
}
?>
