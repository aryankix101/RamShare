<?php
    error_reporting(E_ALL);
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
    session_start(); 
    $Birthdate = date("Y-m-d", strtotime($_POST["Birthdate"]));
    $Bio = $_POST["Bio"];
    $Phone_Number = $_POST["Phone_Number"];
    $Gender = $_POST["Gender"];
    $Type_Of_User = $_POST["Type_Of_User"];
    $Session_VCU_Email = $_SESSION['user_ID'];
    $sqlQuery  = "UPDATE UserProfile SET Birthdate='$Birthdate', Bio='$Bio', Phone_Number='$Phone_Number', Gender='$Gender', Type_Of_User='$Type_Of_User' WHERE VCU_Email='$Session_VCU_Email'";

    if ($Type_Of_User == 'driver') {
    $sqlDriver = "INSERT INTO Driver (VCU_Email) VALUES (:VCU_Email)";
    $stmtDriver = $conn->prepare($sqlDriver);
    try {
        $stmtDriver->execute([':VCU_Email' => $Session_VCU_Email]);
        echo "Driver profile created successfully.";
    } catch (PDOException $e) {
        echo "Failed to create driver profile: " . $e->getMessage();
    }
    } 
    elseif ($Type_Of_User == 'rider') {
        $sqlRider = "INSERT INTO Rider (VCU_Email) VALUES (:VCU_Email)";
        $stmtRider = $conn->prepare($sqlRider);
        try {
            $stmtRider->execute([':VCU_Email' => $Session_VCU_Email]);
            echo "Rider profile created successfully.";
        } catch (PDOException $e) {
            echo "Failed to create rider profile: " . $e->getMessage();
        }
    }
    $stmt2 = $conn->prepare($sqlQuery);
    $stmt2->execute();
    echo "You have Successfully Registered....."; 
    exit();
    

?>