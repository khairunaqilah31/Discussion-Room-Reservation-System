<?php
session_start();
include('dbConfiguration.php');

$stmt = null; // Initialize $stmt variable

if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password']; // Raw password input from the user

    // Prepared statement
    $stmt = $conn->prepare("SELECT id, name, role, password FROM user WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    
    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id']; // Store user ID in session
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];
        
        // Redirect based on user role
        switch ($user['role']) {
            case 'admin':
                header('Location: adminDashboard.php');
                exit();
                
            case 'user':
                header('Location: userDashboard.php');
                exit();
                
            // Add more cases for other roles as needed
            default:
                // Handle unexpected roles (optional)
                echo "<script>alert('Unknown role.');</script>";
                break;
        }
    } else {
        echo "<script>alert('Invalid Details.');</script>";          
    }
}

if ($stmt) {
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Discussion Room Reservation System | Sign In</title>
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap" rel="stylesheet">
  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Custom Style -->
  <style>
    body {
      background: linear-gradient(135deg, #667eea, #764ba2);
      font-family: 'Source Sans Pro', sans-serif;
    }
    .login-page {
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
    }
    .login-box {
      width: 400px;
      padding: 15px;
    }
    .login-box .card {
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }
    .login-box .card-header {
      border-bottom: none;
      text-align: center;
      font-size: 24px;
      font-weight: bold;
      color: #007bff;
    }
    .login-box .btn-primary {
      background-color: #007bff;
      border-color: #007bff;
    }
    .login-box .form-control {
      height: calc(2.25rem + 2px);
    }
  </style>
</head>
<body class="login-page">
  <div class="login-box">
    <div class="card card-outline card-primary">
      <div class="card-header text-center">
        DC Room Reservation System
      </div>
      <div class="card-body">
        <p class="login-box-msg">Sign in to start your session</p>
        <form method="post" action="login.php">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="password" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-8">
            </div>
            <div class="col-4">
              <button type="submit" class="btn btn-primary btn-block" name="login">Sign In</button>
            </div>
          </div>
        </form>
        <p class="mb-1">
          <a href="passRecovery.php">I forgot my password</a>
        </p>
        <p class="mb-0">
          Don't have an account yet? <a href="signup.php" class="text-center" style="color: #007bff;">Sign up here</a>
        </p>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
</body>
</html>
