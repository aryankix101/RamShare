<?php

// Display all errors, very useful for PHP debugging (disable in production)
//error_reporting(E_ALL);
//ini_set('display_errors', 1);

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

session_start();

// If the user_ID session is not set, then the user has not logged in yet
if (!isset($_SESSION['user_ID']))
{
    
    // If the page is receiving the email and password from the login form then verify the login data
    if (isset($_POST['VCU_Email']) && isset($_POST['UserPassword']))
    {
        $stmt = $conn->prepare("SELECT VCU_Email, UserPassword FROM UserProfile WHERE VCU_Email=:VCU_Email");
        $stmt->bindValue(':VCU_Email', $_POST['VCU_Email']);
        $stmt->execute();
        
        $queryResult = $stmt->fetch();
        
        // Verify password submitted by the user with the hash stored in the database
        if (!empty($queryResult) && password_verify($_POST["UserPassword"], $queryResult['UserPassword'])) {
            // Create session variable
            $_SESSION['user_ID'] = $queryResult['VCU_Email'];
            $sqlQuery = "SELECT First_Time_User FROM UserProfile WHERE VCU_Email = :VCU_Email";
            $stmt2 = $conn->prepare($sqlQuery);
            $stmt2->bindValue(':VCU_Email', $queryResult['VCU_Email']);
            $stmt2->execute();
            $result = $stmt2->fetch(PDO::FETCH_ASSOC);
            if ($result) {
                $determineUser = $result['First_Time_User'];
                if ($determineUser == 0) {
                    // Redirect the user as they just created an account
                    header('Location: new-user-registration.php');
                    $userEmail = $_SESSION['user_ID'];
                    $typeOfUser = 1;
                    $stmt3 = $conn->prepare("UPDATE UserProfile SET First_Time_User = ? WHERE VCU_Email = ?");
                    $stmt3->bindParam(1, $typeOfUser);
                    $stmt3->bindParam(2, $userEmail);
                    $stmt3->execute();
                    exit;
                } else {
                    // Already a user, so redirect to main page
                    header("Location: index.php");
                    exit;
                }
            } else {
                // Error fetching Date_Joined, redirect to index.php
                header("Location: index.php");
                exit;
            }
        } else {
            // Password mismatch, show login page
            require('login.php');
            exit();
        }
    }
    else
    {
        // Show login page
        require('login.php');
        exit();
    }
}




?>