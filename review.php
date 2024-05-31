<?php
session_start();
/*error_reporting(E_ALL);
ini_set('display_errors', 1);*/

require_once('header.php'); 
require_once('navbar.php'); 
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

$rideId = $_GET['ride_id'] ?? null;
$riderId = $_GET['rider_id'] ?? null;
$reviewerType = $_GET['type'] ?? '';
$userEmail = $_SESSION['user_ID'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rideId = $_POST['ride_id'];
    $riderId = $_POST['rider_id'];
    $reviewerType = $_POST['reviewer_type'];
    $rating = $_POST['rating'];
    $content = $_POST['content'];

    $stmt = $conn->prepare("SELECT Driver_ID FROM Driver WHERE VCU_Email = :email");
    $stmt->bindParam(':email', $userEmail);
    $stmt->execute();
    $reviewerId = $stmt->fetchColumn();

    if ($reviewerType === 'driver') {
        $stmt = $conn->prepare("SELECT Rider_ID FROM Rider WHERE VCU_Email= :riderEmail");
        $stmt->bindParam(':riderEmail', $riderId);
        $stmt->execute();
        $otherPartyId = $stmt->fetchColumn();
    } else {
        $stmt = $conn->prepare("SELECT Driver_ID FROM Ride WHERE Ride_ID = :rideId");
        $stmt->bindParam(':rideId', $rideId);
        $stmt->execute();
        $otherPartyId = $stmt->fetchColumn();
    }

    $stmt = $conn->prepare("INSERT INTO Reviews_Ratings (Rider, Driver, Ride_ID, Content, Rating) VALUES (?, ?, ?, ?, ?)");
    $stmt->bindParam(1, $otherPartyId);
    $stmt->bindParam(2, $reviewerId);
    $stmt->bindParam(3, $rideId);
    $stmt->bindParam(4, $content);
    $stmt->bindParam(5, $rating);
    $stmt->execute();

    echo "<p>Review submitted successfully.</p>";
} else {
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Review</title>
</head>
<body>
    <h1>Submit Rating/Review</h1>
    <form action="review.php" method="post">
        <input type="hidden" name="ride_id" value="<?= htmlspecialchars($rideId); ?>">
        <input type="hidden" name="reviewer_type" value="<?= htmlspecialchars($reviewerType); ?>">
        <input type="hidden" name="rider_id" value="<?= htmlspecialchars($riderId); ?>">
        <div class="form-group">
            <label for="rating">Rating (1-5):</label>
            <input type="number" name="rating" id="rating" min="1" max="5" required>
        </div>
        <div class="form-group">
            <label for="content">Review:</label>
            <textarea name="content" id="content" required></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Submit Review</button>
    </form>
</body>
</html>
<?php } ?>
