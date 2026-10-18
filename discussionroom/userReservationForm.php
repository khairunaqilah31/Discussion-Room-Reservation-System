<?php
// Start the session
session_start();

// Set the default time zone
date_default_timezone_set('Asia/Kuala_Lumpur');

// Enable error reporting for debugging
// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if the user is not logged in
    header("Location: login.php");
    exit();
}

include('dbConfiguration.php');

// Retrieve user details
$userID = $_SESSION['user_id'];
$stmt = $conn->prepare("SELECT name, email, contact_number FROM user WHERE id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $userID);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();
$stmt->close();

if (!$user) {
    die("User not found.");
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Form</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
        }
        #sidebar-wrapper {
            width: 250px;
        }
        #page-content-wrapper {
            margin-left: 250px;
            padding: 20px;
            flex: 1;
        }
        .container {
            max-width: 800px;
            padding: 20px;
            margin-top: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .form-group label {
            font-weight: bold;
        }
        .time-slot-container {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }
        .form-check-inline {
            margin-bottom: 10px;
        }
        .disabled-slot label {
            color: red;
        }
        .disabled-slot input[type="radio"] {
            display: none;
        }
        .available-slot label {
            color: green;
        }
        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }
    </style>
</head>
<body>
    <?php include('userHeader.php'); ?>

    <div class="d-flex" id="wrapper">
        <?php include('userSidebar.php'); ?>
        
        <div id="page-content-wrapper">
            <div class="container">
                <h2 class="text-center">Room Reservation Form</h2>
                <form id="reservationForm" method="post" action="">
                    <div class="form-group">
                        <label for="room">Choose a Discussion Room:</label>
                        <select name="room" id="room" class="form-control" required>
                            <?php
                            // Fetch room names from the database
                            $roomResult = $conn->query("SELECT roomName FROM room");
                            if ($roomResult) {
                                while ($room = $roomResult->fetch_assoc()) {
                                    echo '<option value="' . htmlspecialchars($room['roomName']) . '">' . htmlspecialchars($room['roomName']) . '</option>';
                                }
                            } else {
                                echo '<option value="">No rooms available</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="fullName">Full Name:</label>
                        <input type="text" id="fullName" name="fullName" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="contactNumber">Contact Number:</label>
                        <input type="text" id="contactNumber" name="contactNumber" class="form-control" value="<?php echo htmlspecialchars($user['contact_number']); ?>" required readonly>
                    </div>
                    <div class="form-group">
                        <label for="date">Choose Date:</label>
                        <input type="date" id="date" name="date" class="form-control" required min="<?php echo date('Y-m-d'); ?>">
                    </div>
                    <div class="form-group">
                        <label>Check Availability:</label>
                        <div id="timeSlots" class="time-slot-container">
                            <!-- Time slots will be loaded here dynamically -->
                        </div>
                    </div>
                    <button type="submit" name="reserve" class="btn btn-primary btn-block">Submit Reservation</button>
                    <input type="hidden" name="submission_datetime" value="<?php echo date('Y-m-d H:i:s'); ?>">
                    <input type="hidden" name="user_id" value="<?php echo $userID; ?>">
                </form>
                <?php
                    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['reserve'])) {
                        $room = $_POST['room'];
                        $fullName = $_POST['fullName'];
                        $contactNumber = $_POST['contactNumber'];
                        $date = $_POST['date'];
                        $timeSlot = $_POST['timeSlot'];
                        $status = 'pending'; // All new reservations start with 'pending' status
                        $userID = $_SESSION['user_id'];
                        $reserveNo = 'RSV' . substr(uniqid(), -3); // Generates a shorter unique ID
                        $reserveAt = date('Y-m-d H:i:s');

                        // Insert reservation into the database
                        $stmt = $conn->prepare("INSERT INTO reservation (reserveNo, slotID, roomID, userID, reserveDate, reserveAt, approvalStatus) 
                                                VALUES (?, (SELECT id FROM slot WHERE slot = ?), (SELECT id FROM room WHERE roomName = ?), ?, ?, ?, ?)");
                        if (!$stmt) {
                            die("Prepare failed: " . $conn->error);
                        }
                        $stmt->bind_param("sssisss", $reserveNo, $timeSlot, $room, $userID, $date, $reserveAt, $status);
                        $stmt->execute();
                        $stmt->close();

                        // Display the confirmation message
                        echo '<div id="confirmation" class="alert alert-success mt-3">';
                        echo '<h4>Reservation Submitted</h4>';
                        echo '<p>Your reservation is pending approval. Admin will review your reservation request. </p>';
                        echo '</div>';
                    }

                    $conn->close();
                ?>
            </div>
        </div>
    </div>

    <!-- /.content-wrapper -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        $(document).ready(function() {
            function fetchAvailableSlots() {
                var selectedDate = $('#date').val();
                var selectedRoom = $('#room').val();

                if (selectedDate && selectedRoom) {
                    $.ajax({
                        url: 'userFetchSlots.php',
                        type: 'POST',
                        data: {
                            date: selectedDate,
                            room: selectedRoom
                        },
                        success: function(response) {
                            $('#timeSlots').html(response);
                        },
                        error: function() {
                            $('#timeSlots').html('<div class="alert alert-danger">Error fetching slots. Please try again later.</div>');
                        }
                    });
                } else {
                    $('#timeSlots').html('');
                }
            }

            $('#date, #room').change(function() {
                fetchAvailableSlots();
            });
        });
    </script>

    <?php include('userFooter.php'); ?>
</body>
</html>
