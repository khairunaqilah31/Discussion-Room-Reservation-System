<?php
session_start();

include('dbConfiguration.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

// Get reservation ID from query string and validate it
$reservationId = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($reservationId == 0) {
    echo "Invalid Reservation ID.";
    exit; // Stop script if reservation ID is not valid
}

// Prepare and execute SQL query to fetch reservation details
$sql = "SELECT r.reserveNo, r.reserveDate, r.reserveAt, r.approvalStatus, s.slot, rm.roomName, rm.roomDescription, rm.roomPicture, u.name AS userName, u.email AS userEmail, u.contact_number AS userContact
        FROM reservation r
        JOIN slot s ON r.slotID = s.id
        JOIN room rm ON r.roomID = rm.id
        JOIN user u ON r.userID = u.id
        WHERE r.id = ? AND r.userID = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $reservationId, $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No reservation found with this ID.";
    exit;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Details</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
<?php include('userHeader.php'); ?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php include('userSidebar.php'); ?>
        </div>
        <div class="col-md-9">
            <div class="container">
                <h1>Reservation Details</h1>
                <table class="table table-bordered">
                    <tr>
                        <th>Reservation No</th>
                        <td><?php echo htmlspecialchars($row["reserveNo"]); ?></td>
                    </tr>
                    <tr>
                        <th>Reservation Date</th>
                        <td><?php echo htmlspecialchars($row["reserveDate"]); ?></td>
                    </tr>
                    <tr>
                        <th>Slot</th>
                        <td><?php echo htmlspecialchars($row["slot"]); ?></td>
                    </tr>
                    <tr>
                        <th>Reserved At</th>
                        <td><?php echo htmlspecialchars($row["reserveAt"]); ?></td>
                    </tr>
                    <tr>
                        <th>Status</th>
                        <td><?php echo ucfirst(htmlspecialchars($row["approvalStatus"])); ?></td>
                    </tr>
                    <tr>
                        <th>Reserved At</th>
                        <td><?php echo htmlspecialchars($row["reserveAt"]); ?></td>
                    </tr>
                    <tr>
                        <th>Room Name</th>
                        <td><?php echo htmlspecialchars($row["roomName"]); ?></td>
                    </tr>
                    <tr>
                        <th>Room Description</th>
                        <td><?php echo htmlspecialchars($row["roomDescription"]); ?></td>
                    </tr>
                    <tr>
                        <th>Room Picture</th>
                        <td><img src="data:image/jpeg;base64,<?php echo base64_encode($row['roomPicture']); ?>" alt="Room Picture" style="max-width: 100%; height: auto;"></td>
                    </tr>
                    <tr>
                        <th>User Name</th>
                        <td><?php echo htmlspecialchars($row["userName"]); ?></td>
                    </tr>
                    <tr>
                        <th>User Email</th>
                        <td><?php echo htmlspecialchars($row["userEmail"]); ?></td>
                    </tr>
                    <tr>
                        <th>User Contact Number</th>
                        <td><?php echo htmlspecialchars($row["userContact"]); ?></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php include('userFooter.php'); ?>
