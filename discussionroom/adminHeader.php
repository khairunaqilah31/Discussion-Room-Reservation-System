<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Room Reservation System | Dashboard</title>
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/css/adminlte.min.css">
    <!-- Custom CSS -->
    <style>
        .main-header.navbar {
            background: linear-gradient(135deg, #667eea, #764ba2);
        }
        
        .sidebar .user-panel {
            padding: 20px;
            overflow: hidden;
        }
        .sidebar .user-panel .info {
            text-align: center;
            margin-top: 10px;
        }
        .sidebar .user-panel .info p {
            margin-bottom: 0;
            color: white;
            font-weight: bold;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <ul class="navbar-nav ml-auto">
            <!-- Navbar icons -->
            <li class="nav-item dropdown">
                <a class="nav-link" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <i class="fas fa-user"></i>
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" aria-labelledby="navbarDropdown">
                    <a href="adminProfile.php" class="dropdown-item">My Profile</a>
                    <a href="adminChangePassword.php" class="dropdown-item">Change Password</a>
                    <a href="logout.php" class="dropdown-item">Logout</a>
                </div>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Scripts should be placed at the end of the body to ensure they load after the HTML content -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
      $(document).ready(function(){
        $('.dropdown-toggle').dropdown();
      });
    </script>
</div>
</body>
</html>
