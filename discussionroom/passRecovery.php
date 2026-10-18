<?php
include('dbConfiguration.php');

$stmt = null; // Initialize $stmt variable

if(isset($_POST['resetpwd'])) {
    $email = $_POST['email'];
    $mobile = $_POST['mobileno'];
    $newpassword = $_POST['newpassword']; // Raw new password input

    // Hash the new password securely
    $hashed_password = password_hash($newpassword, PASSWORD_DEFAULT);

    // Select the user based on email and mobile number
    $sql = mysqli_query($conn, "SELECT id FROM user WHERE email='$email' AND contact_number='$mobile'");
    $rowcount = mysqli_num_rows($sql);

    if($rowcount > 0) {
        // Update the user's password
        $stmt = $conn->prepare("UPDATE user SET password=? WHERE email=? AND contact_number=?");
        $stmt->bind_param("sss", $hashed_password, $email, $mobile);
        $query = $stmt->execute();

        if($query) {
            echo "<script>alert('Your Password successfully changed');</script>";
            echo "<script type='text/javascript'> document.location = 'login.php'; </script>";
        } else {
            echo "<script>alert('Failed to update password. Please try again later.');</script>";
        }
    } else {
        echo "<script>alert('User not found. Please check your email and mobile number.');</script>";
    }
}

if ($stmt) {
    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Meeting and Conference Booking System | Password Recovery</title>
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
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
      color: #007bff; /* Adjust color as needed */
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
        <p class="login-box-msg">Reset your password</p>
        <form name="passwordrecovery" method="post" action="passRecovery.php" onsubmit="return valid();">
          <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="text" class="form-control" placeholder="Mobile Number" name="mobileno" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-phone"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Password" name="newpassword" id="newpassword" required>
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="password" class="form-control" placeholder="Confirm Password" name="confirmpassword" id="confirmpassword" required>
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
              <button type="submit" class="btn btn-primary btn-block" name="resetpwd">Reset</button>
            </div>
          </div>
        </form>
        <p class="mb-1">
          <a href="login.php">Signin</a>
        </p>
      </div>
    </div>
  </div>
  <!-- jQuery -->
  <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
  <!-- Validation Script -->
  <script type="text/javascript">
    function valid() {
      if (document.passwordrecovery.newpassword.value != document.passwordrecovery.confirmpassword.value) {
        alert("New Password and Confirm Password Field do not match!!");
        document.passwordrecovery.confirmpassword.focus();
        return false;
      }
      return true;
    }
  </script>
</body>
</html>
