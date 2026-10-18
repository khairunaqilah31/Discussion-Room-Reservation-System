<?php
session_start();

include('dbConfiguration.php');
include('adminHeader.php');
include('adminSidebar.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Get reservation ID from query string and validate it
$reservationId = isset($_GET['reservation_id']) ? intval($_GET['reservation_id']) : 0;
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
        WHERE r.id = ?";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $reservationId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
} else {
    echo "No reservation found with this ID.";
    exit;
}
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservation Details</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="adminViewUser.php">View Users</a></li>
                        <!--<li class="breadcrumb-item"><a href="adminViewUserReservations.php">Reservations</a></li> -->
                        <li class="breadcrumb-item active">Reservation Details</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h2>Reservation Details</h2>
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
    </section>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.notice-title').click(function() {
        var targetId = $(this).data('target');
        $(targetId).collapse('toggle');
    });
});
</script>

<?php
$stmt->close();
$conn->close();
include('adminFooter.php');
?>
