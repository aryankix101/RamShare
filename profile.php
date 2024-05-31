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
    <title>User Profile</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi" crossorigin="anonymous">
    <link rel="stylesheet" href="media/css/style.css"/>
    <link rel="stylesheet" href="media/css/profile.css"/>
    <script src="media/js/profile.js"></script>
</head>
<body>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card mt-5">
                    <div class="card-header">
                        <h4>Account Info</h4>
                    </div>
                    <div class="card-body">
                        <form id="profile-form">
                            <div class="form-group">
                                <label for="fullName">Name:</label>
                                <input type="text" class="form-control" id="fullName" disabled>
                            </div>
                            <div class="form-group">
                                <label for="email">Email:</label>
                                <input type="email" class="form-control" id="email" value="<?php echo $_SESSION['user_ID']; ?>" disabled>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number:</label>
                                <input type="text" class="form-control" id="phoneNumber" maxlength="10">
                            </div>
                            <div class="form-group">
                                <label for="profilePicture">Profile Picture:</label>
                                <div class="profile-picture-container">
                                    <div class="rounded-circle profile-picture-placeholder">
                                        <img src="data:image/jpeg;base64,..." class="rounded-circle profile-picture" alt="Profile Picture">
                                    </div>
                                    <div class="custom-file">
                                        <input type="file" class="form-control" id="pictureInput" style="display: none;">
                                        <label class="btn btn-primary" for="pictureInput">Choose file</label>
                                    </div>
                                </div>
                            </div>
                            <button type="button" class="btn btn-primary save-changes" id="saveChanges">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://kit.fontawesome.com/your-font-awesome-kit.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.getElementById('pictureInput').addEventListener('change', function() {
        var fileName = this.files[0].name;
        document.getElementById('file-chosen').textContent = fileName;
    });
    </script>

</body>
</html>