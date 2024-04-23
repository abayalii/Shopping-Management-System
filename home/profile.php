<?php
session_start();
include("../login/connect.php");

$email = $_SESSION['email'];

$sql = "SELECT user_id FROM users WHERE email = '$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_id = $row['user_id'];
}

$sql = "SELECT * FROM users join addresses on users.user_id=addresses.user_id where users.user_id = '$user_id'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['user_name']; // Define $user_name here
    $password = $row['password'];
    $email = $row['email'];
    $address_info = $row['address_info'];
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
      if (isset($_POST["name"]) && isset($_POST["email"]) && isset($_POST["address"])) {
        $user_name = $_POST["user_name"];
        $email = $_POST["email"];
        $address = $_POST["address"];

        // Update profile information in the database
        $update_sql = "UPDATE users SET user_name = '$user_name', email = '$email' WHERE user_id = '$user_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Profile information updated successfully.";
        } else {
            echo "Error updating profile information: " . $conn->error;
        }

        // Update address information in the database
        $update_sql = "UPDATE addresses SET address_info = '$address' WHERE user_id = '$user_id'";
        if ($conn->query($update_sql) === TRUE) {
            echo "Address information updated successfully.";
        } else {
            echo "Error updating address information: " . $conn->error;
        }
    }
}
}





if (isset($_POST["current_password"]) && isset($_POST["new_password"]) && isset($_POST["confirm_password"])) {
        // Handle password change
        $current_password = $_POST["current_password"];
        $new_password = $_POST["new_password"];
        $confirm_password = $_POST["confirm_password"];

        if ($current_password == $password) {
            if ($new_password == $confirm_password) {
                // Update password in the database
                $update_sql = "UPDATE users SET password = '$new_password' WHERE user_id = '$user_id'";
                if ($conn->query($update_sql) === TRUE) {
                    echo "Password updated successfully.";
                } else {
                    echo "Error updating password: " . $conn->error;
                }
            } else {
                echo "New password and confirm password do not match.";
            }
        } else {
            echo "Current password is incorrect.";
        }
    }


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <!-- Navigation -->
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <a class="navbar-brand" href="#">ELECTRONIC SHOP</a>
            <div class="collapse navbar-collapse justify-content-end" id="navbarSupportedContent">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php"><?php echo isset($user_name) ? strtoupper($user_name) : ''; ?></a>
                    </li>
                </ul>
            </div>
        </nav>
        <div class="row mt-5">
        <!-- Current User Information -->
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Profil Information</h5>
                </div>
                <div class="card-body">
                    <p><strong>Name:</strong> <?php echo isset($user_name) ? $user_name : ''; ?></p>
                    <p><strong>Email:</strong> <?php echo isset($email) ? $email : ''; ?></p>
                    <p><strong>Address:</strong> <?php echo isset($address_info) ? $address_info : ''; ?></p>
                </div>
            </div>
        </div>
        <!-- Profile Information Form -->
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5>Change Information</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="<?php echo isset($user_name) ? $user_name : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control" id="email" name="email" value="<?php echo isset($email) ? $email : ''; ?>">
                            </div>
                            <div class="form-group">
                                <label for="address">Address</label>
                                <textarea class="form-control" id="address" name="address"><?php echo isset($address_info) ? $address_info : ''; ?></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        </div>
        
        <!-- Change Password Form -->
        <div class="row mt-5">
            <div class="col-md-6 offset-md-3">
                <div class="card">
                    <div class="card-header">
                        <h5>Change Password</h5>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST">
                            <div class="form-group">
                                <label for="current_password">Current Password</label>
                                <input type="password" class="form-control" id="current_password" name="current_password">
                            </div>
                            <div class="form-group">
                                <label for="new_password">New Password</label>
                                <input type="password" class="form-control" id="new_password" name="new_password">
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
                            </div>
                            <button type="submit" class="btn btn-primary">Change Password</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
