<?php
session_start();

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
    echo "Connection failed: " . $e->getMessage();
}
global $conn;

if (isset($_GET['action']) && $_GET['action'] === 'fetch_user_data') {
    $userEmail = $_SESSION['user_ID'];

    $stmt = $conn->prepare("SELECT First_Name, Middle_Name, Last_Name, Phone_Number, Profile_Picture FROM UserProfile WHERE VCU_Email = ?");
    $stmt->bindParam(1, $userEmail);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        $user['Profile_Picture'] = base64_encode($user['Profile_Picture']);
        echo json_encode($user);
    } else {
        http_response_code(404);
        echo 'User not found';
    }
    exit;
}

if (isset($_POST['action']) && $_POST['action'] === 'update_phone_number') {
    $phoneNumber = $_POST['phoneNumber'];
    $userEmail = $_SESSION['user_ID'];

    $stmt = $conn->prepare("UPDATE UserProfile SET Phone_Number = ? WHERE VCU_Email = ?");
    $stmt->bindParam(1, $phoneNumber);
    $stmt->bindParam(2, $userEmail);

    if ($stmt->execute()) {
        http_response_code(200);
        echo 'Updates made succesfully!';
    } else {
        http_response_code(500);
        echo 'Error updating phone number';
    }
    exit;
}

if (isset($_FILES['picture'])) {
    $picture = file_get_contents($_FILES['picture']['tmp_name']);
    $userEmail = $_SESSION['user_ID'];

    $stmt = $conn->prepare("UPDATE UserProfile SET Profile_Picture = ? WHERE VCU_Email = ?");
    $stmt->bindParam(1, $picture, PDO::PARAM_LOB);
    $stmt->bindParam(2, $userEmail);

    if ($stmt->execute()) {
        http_response_code(200);
        echo 'Profile picture updated successfully';
    } else {
        http_response_code(500);
        echo 'Error updating profile picture';
    }
    exit;
}
