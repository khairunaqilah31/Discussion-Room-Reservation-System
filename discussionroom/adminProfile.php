<?php
session_start();

include('dbConfiguration.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get current user ID
$user_id = $_SESSION['user_id'];

// Query user details
$sql = "SELECT name, email, contact_number, role FROM user WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

// Close connection
$conn->close();

// Get success message from URL
$success_message = isset($_GET['success']) ? htmlspecialchars($_GET['success']) : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Profile</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- Custom CSS -->
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
        .profile-details {
            margin-bottom: 20px;
        }
        .profile-details dt {
            font-weight: bold;
        }
        .profile-actions {
            text-align: center;
        }
        .notification {
            display: none;
            background-color: #4caf50;
            color: white;
            padding: 10px;
            position: fixed;
            top: 0;
            width: 100%;
            text-align: center;
            z-index: 1000;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <?php include('adminHeader.php'); ?>
    <?php include('adminSidebar.php'); ?>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">My Profile</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                            <li class="breadcrumb-item active">My Profile</li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        <!-- Main content -->
        <section class="content">
            <div class="container">
                <div class="profile-container">
                    <div class="profile-header">
                        <h1><?php echo htmlspecialchars($user['name']); ?></h1>
                    </div>
                    <dl class="profile-details row">
                        <dt class="col-sm-4">Email</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['email']); ?></dd>
                        
                        <dt class="col-sm-4">Contact Number</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['contact_number']); ?></dd>
                        
                        <dt class="col-sm-4">Role</dt>
                        <dd class="col-sm-8"><?php echo htmlspecialchars($user['role']); ?></dd>
                    </dl>
                    <div class="profile-actions">
                        <a href="adminEditProfile.php" class="btn btn-primary">Update Profile</a>
                        <a href="adminChangePassword.php" class="btn btn-secondary">Change Password</a>
                    </div>
                </div>
            </div>
        </section>
        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <?php include('userFooter.php'); ?>
</div>

<!-- Ensure scripts are included here -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<script>
    <?php if (!empty($success_message)): ?>
        $(document).ready(function() {
            $(".notification").text("<?php echo $success_message; ?>").slideDown().delay(3000).slideUp();
        });
    <?php endif; ?>
</script>
<div class="notification"></div>
</body>
</html>
