<?php
include('dbConfiguration.php');

//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "najihahnew20062024";

// Create connection
//$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $fullName = $_POST['fullName'];
    $email = $_POST['email'];
    $contactNumber = $_POST['contactNumber'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO user (name, email, contact_number, password) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $fullName, $email, $contactNumber, $password);

    if ($stmt->execute()) {
        echo "New record created successfully";
        header("Location: login.php");
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
}

//$conn->close();
?>

<!--html codes sini-->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Discussion Room Reservation System | Sign Up</title>
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=swap" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
    <!-- Bootstrap CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom Style -->
    <style>
        body {
            /*background-color: #f4f6f9;*/
            background: linear-gradient(135deg, #667eea, #764ba2);
            font-family: 'Source Sans Pro', sans-serif;
        }
        .signup-page {
            display: flex;
            align-items: center;
            justify-content: center;
            height: 100vh;
        }
        .signup-box {
            width: 400px;
            padding: 15px;
        }
        .signup-box .card {
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .signup-box .card-header {
            border-bottom: none;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            color: #007bff; /* Adjust color as needed */
        }
        .signup-box .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .signup-box .form-control {
            height: calc(2.25rem + 2px);
        }
        .signup-box .input-group-text {
            background-color: #ffffff;
        }
        .error {
            color: red;
            font-size: 0.9em;
            margin-bottom: 10px;
            display: none;
        }
    </style>
</head>
<body class="signup-page">
    <div class="signup-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                DC Room Reservation System
            </div>
            <div class="card-body">
                <p class="signup-box-msg">Sign up to create your account</p>
                <form id="signupForm" method="post" action="signup.php">
                    <div class="error" id="errorMessage"></div>
                    <div class="input-group mb-3">
                        <input type="text" id="fullName" class="form-control" placeholder="Full Name" name="fullName" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-user"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="email" id="email" class="form-control" placeholder="Email" name="email" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="text" id="contactNumber" class="form-control" placeholder="Contact Number" name="contactNumber" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-phone"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" id="password" class="form-control" placeholder="Password" name="password" required>
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-lock"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <p>Already a member? <a href="login.php">Log in here</a></p>
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap 4 -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('signupForm').addEventListener('submit', function(event) {
            const email = document.getElementById('email').value;
            const password = document.getElementById('password').value;
            const errorMessage = document.getElementById('errorMessage');

            // Basic email pattern validation
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                errorMessage.textContent = "Please enter a valid email address.";
                errorMessage.style.display = "block";
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Password strength validation
            if (password.length < 8) {
                errorMessage.textContent = "Password must be at least 8 characters long.";
                errorMessage.style.display = "block";
                event.preventDefault(); // Prevent form submission
                return;
            }

            // Hide error message if validation passes
            errorMessage.style.display = "none";
        });
    </script>
</body>
</html>


<?php
$conn->close();
?>
