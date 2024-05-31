<?php
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
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
    $First_Name = $_POST["First_Name"];
    $Middle_Name = $_POST["Middle_Name"];
    $Last_Name = $_POST["Last_Name"];
    $VCU_Email = $_POST["VCU_Email"];
    $UserPassword = $_POST["UserPassword"];
    $passwordRepeat = $_POST["passwordRepeat"];
    $passwordHash = crypt($UserPassword, '$2a$09$anexamplestringforsalt$');
    $typeOfUser = 0;

    $sqlQueryChecking = "SELECT * FROM UserProfile WHERE VCU_Email = '$VCU_Email'";
    $stmt = $conn->prepare($sqlQueryChecking);
    $stmt->execute();
    $data = $stmt->rowCount();
    if ($data>0) 
    {
        echo "You already have an account!"; 
        exit();
    }
    else
    {
        $sqlQuery  = "INSERT INTO UserProfile (First_Name, Middle_Name, Last_Name, VCU_Email, UserPassword, First_Time_User, Date_Joined) VALUES ( ?, ?, ?, ?, ?, ?, CURRENT_TIMESTAMP)";
        $stmt2 = $conn->prepare($sqlQuery);
        $stmt2->bindParam(1, $First_Name, PDO::PARAM_STR);
        $stmt2->bindParam(2, $Middle_Name, PDO::PARAM_STR);
        $stmt2->bindParam(3, $Last_Name, PDO::PARAM_STR);
        $stmt2->bindParam(4, $VCU_Email, PDO::PARAM_STR);
        $stmt2->bindParam(5, $passwordHash, PDO::PARAM_STR);
        $stmt2->bindParam(6, $typeOfUser, PDO::PARAM_INT);
        $stmt2->execute();
        echo "You have Successfully Registered....."; 
        exit();
    } 

?>