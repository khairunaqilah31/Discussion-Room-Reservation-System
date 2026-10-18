<?php
session_start();

include('dbConfiguration.php');
//include('adminHeader.php');
//include('adminSidebar.php');


// Database configuration settings
//$dbHost = 'localhost';  // Assuming localhost
//$dbUsername = 'root';  // Your database username
//$dbPassword = '';  // Your database password
//$dbName = 'dcroomdb';  // Database name as per your information

// Create database connection
//$conn = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

// Check connection
//if ($conn->connect_error) {
 //   die("Connection failed: " . $conn->connect_error);
//}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$error = '';
$success_message = '';

// Handle form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['changepwd'])) {
    $newPassword = $_POST['new_password'];
    $confirmPassword = $_POST['confirm_password'];

    if ($newPassword !== $confirmPassword) {
        $error = "New password and confirm password do not match.";
    } elseif (strlen($newPassword) < 8) {
        $error = "New password must be at least 8 characters long.";
    } else {
        // Hash the new password
        $newPasswordHash = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $stmt = $conn->prepare("UPDATE user SET password = ? WHERE id = ?");
        $stmt->bind_param("si", $newPasswordHash, $user_id);
        if ($stmt->execute()) {
            $success_message = "Password changed successfully.";
            // Redirect to another page after successful update
            header("Location: adminProfile.php?success=" . urlencode($success_message));
            exit();
        } else {
            $error = "Error updating password: " . $stmt->error;
        }
        $stmt->close();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password</title>
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- Custom Style -->
    <style>
        .profile-container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .profile-header {
            text-align: center;
            margin-bottom: 20px;
        }
        .profile-header h1 {
            margin: 0;
        }
        .form-group label {
            font-weight: bold;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Header -->
        <?php include 'adminHeader.php'; ?>

        <!-- Sidebar -->
        <?php include 'adminSidebar.php'; ?>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Change Password</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>

            <!--<section class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1>Change Password</h1>
                            <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">Change Pssword</li>
                        </ol>
                    </div>
                        </div>
                    </div>
                </div>
            </section> -->

            

            <!-- Main content -->
            <section class="content">
                <div class="container">
                    <div class="profile-container">
                        <div class="profile-header">
                            <h1>Change Password</h1>
                        </div>
                        <?php if (!empty($error)): ?>
                            <div class="alert alert-danger">
                                <?php echo $error; ?>
                            </div>
                        <?php endif; ?>
                        <form name="changepassword" method="post" action="" onsubmit="return valid();">
                            <div class="form-group">
                                <label for="new_password">New Password:</label>
                                <input type="password" class="form-control" id="new_password" name="new_password" required>
                            </div>
                            <div class="form-group">
                                <label for="confirm_password">Confirm New Password:</label>
                                <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                            </div>
                            <button type="submit" class="btn btn-primary btn-block" name="changepwd">Change Password</button>
                        </form>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php 
        //include 'adminFooter.php'; 
        include('adminFooter.php');
        ?>
    </div>

    <!-- jQuery and Bootstrap Bundle (includes Popper) -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.notice-title').click(function() {
        var targetId = $(this).data('target');
        $(targetId).collapse('toggle');
    });
});

    <!-- Password Validation Script -->
    <script type="text/javascript">
        function valid() {
            if (document.changepassword.new_password.value != document.changepassword.confirm_password.value) {
                alert("New Password and Confirm Password do not match!");
                document.changepassword.confirm_password.focus();
                return false;
            }
            return true;
        }
    </script>
</body>
</html>
