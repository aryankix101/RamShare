<?php
session_start();
require_once('header.php');
require_once('navbar.php');

if (!isset($_SESSION['user_ID'])) {
    header('Location: login.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vehicle Registration</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/vehicle_register.css"/>
    <script src="media/js/vehicle-registration.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Vehicle Registration</h4>
                    </div>
                    <div class="card-body">
                        <form id="vehicle-registration-form">
                            <div class="mb-3">
                                <label for="licenseplate" class="form-label">License Plate:</label>
                                <input type="text" class="form-control" id="licenseplate" placeholder="Enter license plate" required>
                            </div>
                            <div class="mb-3">
                                <label for="state" class="form-label">State:</label>
                                <input type="text" class="form-control" id="state" placeholder="Enter state" required>
                            </div>
                            <div class="mb-3">
                                <label for="model" class="form-label">Model:</label>
                                <input type="text" class="form-control" id="model" placeholder="Enter model" required>
                            </div>
                            <div class="mb-3">
                                <label for="year" class="form-label">Year:</label>
                                <input type="number" class="form-control" id="year" min="1900" max="2050" placeholder="Enter year" required>
                            </div>
                            <div class="mb-3">
                                <label for="color" class="form-label">Color:</label>
                                <input type="text" class="form-control" id="color" placeholder="Enter color" required>
                            </div>
                            <button type="submit" class="btn btn-primary">Register Vehicle</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
