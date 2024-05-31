<?php require_once('header.php'); ?>
<?php require_once('navbar.php'); ?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New User Registration Form Further Details</title>
    <script src="media/js/new-user-register-details.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/additional_registration_form.css"/>
</head>
<body>
    <h2 style="text-align: center; padding-top:20px;">Before you join, we still have some more questions for you</h2>
    <div class="additional-info-form">
        <form method="POST">
            <div class="mb-3">
                <label for="birthdate" class="form-label">Birth Date:</label>
                <input type="date" class="form-control" name="birthdate" id="birthdate" required>
            </div>
            <div class="mb-3">
                <label for="phone_number" class="form-label">Phone Number:</label>
                <input type="tel" class="form-control" name="phone_number" id="phone_number" pattern="[0-9]{10}" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gender:</label>
                <div class="form-check">
    <input class="form-check-input" type="radio" name="gender" id="gender_male" value="male" required>
    <label class="form-check-label" for="gender_male">Male</label>
</div>
<div class="form-check">
    <input class="form-check-input" type="radio" name="gender" id="gender_female" value="female" required>
    <label class="form-check-label" for="gender_female">Female</label>
</div>

            </div>
            <div class="mb-3">
                <label for="type_of_user" class="form-label">Do you want to be a driver or join rides?</label>
                <select class="form-select" name="type_of_user" id="type_of_user" required>
                    <option value="driver">Driver</option>
                    <option value="rider">Rider</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="bio" class="form-label">Bio:</label>
                <textarea class="form-control" name="bio" id="bio" rows="5"></textarea>
            </div>
            <a href="ride_listings.php">
                <input type="button" class="btn btn-primary" value="Submit" name="submit-second-round-information" id="submit-second-round-information">
            </a>
        </form>
    </div>
</body>
</html>
