<?php 
// Start session to use session variables
session_start();

include('dbConfiguration.php');
include('adminHeader.php');
include('adminSidebar.php');

// Database connection check
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch approved reservations
$sql = "SELECT r.id, r.reserveNo, s.slot, rm.roomName, u.name, r.reserveDate, r.reserveAt, r.approvalStatus 
        FROM reservation r 
        JOIN slot s ON r.slotID = s.id 
        JOIN room rm ON r.roomID = rm.id 
        JOIN user u ON r.userID = u.id 
        WHERE r.approvalStatus = 'approved'";
$result = $conn->query($sql);

// Check for SQL errors
if (!$result) {
    die("SQL Error: " . $conn->error);
}
?>

<!-- Add CSS for badge styling and centering -->
<style>
    .badge-approved {
        display: inline-block;
        padding: 0.5em 0.75em; /* increased padding for larger size */
        font-size: 1em; /* larger font size */
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        color: #fff;
        background-color: #28a745; /* Bootstrap green */
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
    }
    th, td {
        text-align: center; /* center content of all cells */
        vertical-align: middle; /* align content vertically in the middle */
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Approved Reservations</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Approved Reservations</li>
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
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Reserve No</th>
                                <th>Reserve Date</th>
                                <th>Slot</th>
                                <th>Room</th>
                                <th>User</th>
                                <th>Status</th>
                                <th>Reserve At</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $index = 1;
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $index++ . "</td>"; // Numbering column
                                    echo "<td>" . htmlspecialchars($row["reserveNo"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["reserveDate"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["slot"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["roomName"]) . "</td>";
                                    echo "<td>" . htmlspecialchars($row["name"]) . "</td>";
                                    echo "<td><span class='badge-approved'>Approved</span></td>"; // Apply badge style
                                    echo "<td>" . htmlspecialchars($row["reserveAt"]) . "</td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='8'>No approved reservations found</td></tr>";
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
