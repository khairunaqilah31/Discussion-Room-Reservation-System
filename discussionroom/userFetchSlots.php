<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Available Slots</title>
    <style>
        .form-check-input:disabled + .form-check-label {
            color: red;
        }
        .form-check-input:disabled {
            border-color: red;
        }
    </style>
</head>
<body>

<?php
include('dbConfiguration.php');
// Database connection
//$conn = new mysqli('localhost', 'root', '', 'dcroomdb');
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

if (isset($_POST['date']) && isset($_POST['room'])) {
    $date = $_POST['date'];
    $room = $_POST['room'];

    // Retrieve booked slots from the database
    $bookedSlots = [];
    $stmt = $conn->prepare("SELECT slot.slot FROM reservation 
                            JOIN slot ON reservation.slotID = slot.id
                            JOIN room ON reservation.roomID = room.id
                            WHERE reservation.reserveDate = ? AND room.roomName = ? AND reservation.approvalStatus = 'approved'");
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }
    $stmt->bind_param("ss", $date, $room);
    $stmt->execute();
    $result = $stmt->get_result();
    while ($row = $result->fetch_assoc()) {
        $bookedSlots[] = $row['slot'];
    }
    $stmt->close();

    // Fetch available slots from the database
    $slotResult = $conn->query("SELECT slot FROM slot");
    if ($slotResult) {
        while ($slot = $slotResult->fetch_assoc()) {
            $slotName = $slot['slot'];
            $isBooked = in_array($slotName, $bookedSlots);
            echo '<div class="form-check form-check-inline">';
            echo '<input class="form-check-input" type="radio" name="timeSlot" id="slot-' . htmlspecialchars($slotName) . '" value="' . htmlspecialchars($slotName) . '"' . ($isBooked ? ' disabled' : '') . ' required>';
            echo '<label class="form-check-label" for="slot-' . htmlspecialchars($slotName) . '">' . htmlspecialchars($slotName) . '</label>';
            echo '</div>';
        }
    } else {
        echo '<div class="alert alert-danger">No slots available</div>';
    }
}

$conn->close();
?>

</body>
</html>
