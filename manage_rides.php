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
$userType = '';
$userEmail = '';
if (isset($_SESSION['user_ID']) && $_SESSION['user_ID']) {
    $userEmail = $_SESSION['user_ID'];
    $query = "SELECT Type_Of_User FROM UserProfile WHERE VCU_Email = '$userEmail'";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $userType=$stmt->fetchColumn();
    $stmt->fetch();
}

echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Rides</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/manage_rides.css"/>
    <style>
    .center-heading {
        text-align: center;
    }
</style>
</head>
<body>
<div class="center-heading">
    <h1>Manage Rides</h1>
</div>';

if ($userType === 'driver') {
    echo '<h2>Your Hosted Rides</h2>';
    $stmt = $conn->prepare("SELECT * FROM Ride WHERE Driver_ID IN (SELECT Driver_ID FROM Driver WHERE VCU_Email = ?)");
    $stmt->bindParam(1, $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $rides = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo '<div class="card-columns">';
    foreach ($rides as $ride) {
        echo '<div class="card">';
        echo '<div class="card-body">';
        echo '<h5 class="card-title">Ride from ' . htmlspecialchars($ride['Departure_Address']) . 
             ' to ' . htmlspecialchars($ride['Destination_Address']) . '</h5>';
        echo '<p class="card-text"><small class="text-muted">On ' . date("F j, Y, g:i a", strtotime($ride['Date_Time_Of_Ride'])) . '</small></p>';
        echo '<p class="card-text">Status: ' . htmlspecialchars($ride['Trip_Status']) . '</p>';
    
        echo '</li>';        
        $requestStmt = $conn->prepare("SELECT * FROM RamShare_Request rr JOIN Rider r ON rr.Rider=r.VCU_Email JOIN UserProfile u ON r.VCU_Email=u.VCU_Email  WHERE Ride_ID = ?");
        $requestStmt->bindParam(1, $ride['Ride_ID'], PDO::PARAM_INT);
        $requestStmt->execute();
        $requests = $requestStmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($requests as $request) {
            $buttonsId = 'buttons-' . htmlspecialchars($ride['Ride_ID']) . '-' . htmlspecialchars($request['Rider']);
        
            echo '<div id="' . $buttonsId . '">';
            echo 'Request by <a href="user_info.php?email=' . urlencode($request['VCU_Email']) . '">' . htmlspecialchars($request['First_Name'] . ' ' . $request['Last_Name']) . '</a> - Status: ' . htmlspecialchars($request['Request_Status']);

            if ($request['Request_Status'] == 'accepted' && $ride['Trip_Status'] === 'In Progress') 
            {
                echo '<a href="review.php?ride_id=' . htmlspecialchars($ride['Ride_ID']) . 
                '&type=driver&rider_id=' . htmlspecialchars($request['Rider']) . '" class="btn btn-primary">Submit Review</a>';
            }

            if ($request['Request_Status'] == 'pending') {

            echo '<span id="action-buttons-' . $buttonsId . '">
                    <button onclick="updateRequestStatus(' . htmlspecialchars(json_encode($ride['Ride_ID']), ENT_QUOTES) . 
                    ', ' . htmlspecialchars(json_encode($request['Rider']), ENT_QUOTES) . 
                    ', ' . htmlspecialchars(json_encode('accepted'), ENT_QUOTES) . ', \'action-buttons-' . $buttonsId . '\')">Accept</button>
                    <button onclick="updateRequestStatus(' . htmlspecialchars(json_encode($ride['Ride_ID']), ENT_QUOTES) . 
                    ', ' . htmlspecialchars(json_encode($request['Rider']), ENT_QUOTES) . 
                    ', ' . htmlspecialchars(json_encode('declined'), ENT_QUOTES) . ', \'action-buttons-' . $buttonsId . '\')">Decline</button>
                  </span>';
            }
            echo '</div>';
        }
        echo '</div>'; 
        echo '</div>';
    }
    echo '</div>';
} 

elseif ($userType === 'rider') {
    echo '<h2>Your Requests</h2>';

    $stmt = $conn->prepare("
    SELECT r.*, rr.Request_Status
    FROM Ride r
    JOIN RamShare_Request rr ON r.Ride_ID = rr.Ride_ID
    JOIN Rider rd ON rr.Rider = rd.VCU_Email
    WHERE rd.VCU_Email = ?
    ");
    $stmt->bindParam(1, $userEmail, PDO::PARAM_STR);
    $stmt->execute();
    $rides = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $pendingRides = [];
    $acceptedRides = [];
    $rejectedRides = [];

    foreach ($rides as $ride) {
        switch ($ride['Request_Status']) {
            case 'pending':
                $pendingRides[] = $ride;
                break;
            case 'accepted':
                $acceptedRides[] = $ride;
                break;
            case 'declined':
                $rejectedRides[] = $ride;
                break;
        }
    }

    function displayRides($rides, $includeButtons = false) {
        echo '<div class="card-columns">';
        foreach ($rides as $ride) {
            echo '<div class="card">';
            echo '<div class="card-body">';
            echo '<h5 class="card-title">Ride from ' . htmlspecialchars($ride['Departure_Address']) . ' to ' . htmlspecialchars($ride['Destination_Address']) . '</h5>';
            echo '<p class="card-text"><small class="text-muted">On ' . date("F j, Y, g:i a", strtotime($ride['Date_Time_Of_Ride'])) . '</small></p>';
            echo '<p class="card-text">Status: ' . htmlspecialchars($ride['Trip_Status']) . '</p>';
            if ($includeButtons && $ride['Trip_Status'] === 'In Progress') {
                echo '<a href="review.php?ride_id=' . htmlspecialchars($ride['Ride_ID']) . 
                     '&type=rider" class="btn btn-primary">Rate your driver</a>';
            }
            echo '</div>'; 
            echo '</div>';
        }
        echo '</div>';
    }

    if (!empty($pendingRides)) {
        echo '<h3>Pending Requests</h3>';
        displayRides($pendingRides);
    }

    if (!empty($acceptedRides)) {
        echo '<h3>Accepted Requests</h3>';
        displayRides($acceptedRides, true);
    }

    if (!empty($rejectedRides)) {
        echo '<h3>Rejected Requests</h3>';
        displayRides($rejectedRides);
    }
}

echo '</body>
</html>';
?>

<script>
function updateRequestStatus(rideId, riderId, status, buttonsId) {
    $.ajax({
        type: "POST",
        url: "update_request_status.php",
        data: {
            rideId: rideId,
            riderId: riderId,
            status: status
        },
        success: function(response) {
            var data = JSON.parse(response);
            if (!data.success) {
                alert('Error: ' + data.message);
            } else {
                alert('Success: ' + data.message);
                document.getElementById(buttonsId).remove();
                location.reload();
            }
        },
        error: function(xhr, status, error) {
            console.error('AJAX Error:', status, error);
            alert('Failed to update request status.');
        }
    });
}
</script>
