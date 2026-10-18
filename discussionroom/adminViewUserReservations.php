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

// Get user ID from query string and validate it
$user_id = isset($_GET['user_id']) ? intval($_GET['user_id']) : 0;
if ($user_id == 0) {
    echo "Invalid User ID.";
    exit; // Stop script if user ID is not valid
}

// Prepare and execute SQL query
$sql = "SELECT r.id, r.reserveNo, r.reserveDate, r.approvalStatus
        FROM reservation r
        WHERE r.userID = ?
        ORDER BY r.reserveAt DESC";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    echo "Error preparing statement: " . $conn->error;
    exit;
}

$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Reservation</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="adminViewUser.php">View Users</a></li>
                        <li class="breadcrumb-item active">Reservations</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

     <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <h2>Reservations for this User:</h2>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Reservation No</th>
                        <th>Reserve Date</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        $number = 1; // Initialize row numbering
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $number++ . "</td>"; // Increment and display row number
                            echo "<td>" . htmlspecialchars($row["reserveNo"]) . "</td>";
                            echo "<td>" . htmlspecialchars($row["reserveDate"]) . "</td>";
                            echo "<td>" . ucfirst(htmlspecialchars($row["approvalStatus"])) . "</td>";
                            echo "<td><a href='adminViewReservationDetails.php?reservation_id=" . htmlspecialchars($row["id"]) . "' class='btn btn-primary'>View Details</a></td>"; // Details button
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='5'>No reservations found for this user.</td></tr>";
                    }
                    ?>
                </tbody>
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
