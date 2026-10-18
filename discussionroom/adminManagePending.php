<?php 
// Start session to use session variables
session_start();

// Include necessary files
include('dbConfiguration.php');
include('adminHeader.php');
//include('adminSidebar.php');

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Process form submission for approval or rejection
if ($_SERVER["REQUEST_METHOD"] == "POST" && (isset($_POST['approve']) || isset($_POST['reject']))) {
    $id = $_POST['id'];
    $status = isset($_POST['approve']) ? 'approved' : 'rejected';
    $adminID = $_SESSION['user_id']; // Assuming you have the admin ID stored in the session

    // Update reservation status
    $stmt = $conn->prepare("UPDATE reservation SET approvalStatus = ?, adminID = ? WHERE id = ?");
    $stmt->bind_param("sii", $status, $adminID, $id);
    $stmt->execute();
    $stmt->close();

    // Redirect to the same page to show updated data
    header("Location: adminManagePending.php");
    exit();
}

// Fetch pending reservations
$sql = "SELECT r.id, r.reserveNo, s.slot, rm.roomName, u.name, u.contact_number, r.reserveDate, r.reserveAt, r.slotID, r.roomID 
        FROM reservation r 
        JOIN slot s ON r.slotID = s.id 
        JOIN room rm ON r.roomID = rm.id 
        JOIN user u ON r.userID = u.id 
        WHERE r.approvalStatus = 'pending'";
$result = $conn->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php
//include('adminHeader.php');
include('adminSidebar.php');
?>
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">New Reservations</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>New Reservations</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Reservation No</th>
                                <th>Slot</th>
                                <th>Room</th>
                                <th>User</th>
                                <th>Reserve Date</th>
                                <th>Reserve At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result && $result->num_rows > 0) {
                                while ($row = $result->fetch_object()) {
                                    // Check for existing reservations for the same room, date, and slot
                                    $checkSql = "SELECT COUNT(*) as count FROM reservation 
                                                 WHERE roomID = ? AND reserveDate = ? AND slotID = ? AND approvalStatus = 'approved'";
                                    $checkStmt = $conn->prepare($checkSql);
                                    $checkStmt->bind_param("isi", $row->roomID, $row->reserveDate, $row->slotID);
                                    $checkStmt->execute();
                                    $checkResult = $checkStmt->get_result();
                                    $checkRow = $checkResult->fetch_object();
                                    $isConflict = $checkRow->count > 0;
                                    $checkStmt->close();

                                    echo "<tr id='row_" . $row->id . "'>";
                                    echo "<td>" . htmlspecialchars($row->reserveNo) . "</td>";
                                    echo "<td>" . htmlspecialchars($row->slot) . "</td>";
                                    echo "<td>" . htmlspecialchars($row->roomName) . "</td>";
                                    echo "<td>" . htmlspecialchars($row->name) . "</td>";
                                    echo "<td>" . htmlspecialchars($row->reserveDate) . "</td>";
                                    echo "<td>" . htmlspecialchars($row->reserveAt) . "</td>";
                                    echo "<td>";
                                    echo "<form method='post' action='adminManagePending.php'>";
                                    echo "<input type='hidden' name='id' value='" . htmlspecialchars($row->id) . "'>";
                                    if ($isConflict) {
                                        echo "<button type='button' class='btn btn-success' disabled>Approve</button>";
                                    } else {
                                        echo "<button type='submit' name='approve' class='btn btn-success'>Approve</button>";
                                    }
                                    echo "<button type='submit' name='reject' class='btn btn-danger'>Reject</button>";
                                    echo "</form>";
                                    echo "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='7'>No pending reservations found</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
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
$conn->close();
include('adminFooter.php'); 
?>
