<?php
ob_start(); // Start output buffering

// Start the session
session_start();

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if not logged in
    exit();
}

$userID = $_SESSION['user_id'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rejected Reservations</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .container {
            max-width: 800px;
            margin: 20px auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 8px;
        }
        .section {
            margin-bottom: 30px;
        }
        .reservation-item {
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f9f9f9;
        }
        .reservation-item:hover {
            background-color: #f0f0f0;
        }
        .reservation-details {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .reservation-actions {
            display: flex;
            gap: 10px;
        }
        .btn {
            padding: 5px 10px;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>

<?php 
include('userHeader.php');
?>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-3">
            <?php 
            include('userSidebar.php');
            ?>
        </div>
        <div class="col-md-9">
            <div class="container">
                <h1>User Dashboard</h1>

                <div class="section">
                    <h2>Rejected Reservations</h2>
                    <?php
                    include('dbConfiguration.php');

                    // Query rejected reservations for the current user
                    $sqlRejected = "SELECT r.id, r.reserveDate, r.reserveAt, ro.roomName, s.slot
                                    FROM reservation r
                                    INNER JOIN room ro ON r.roomID = ro.id
                                    INNER JOIN slot s ON r.slotID = s.id
                                    WHERE r.userID = ? AND r.approvalStatus = 'rejected'
                                    ORDER BY r.reserveAt";

                    $stmtRejected = $conn->prepare($sqlRejected);
                    $stmtRejected->bind_param('i', $userID);
                    $stmtRejected->execute();
                    $resultRejected = $stmtRejected->get_result();

                    if ($resultRejected->num_rows > 0) {
                        // Output rejected reservations
                        while ($row = $resultRejected->fetch_assoc()) {
                            $reserveDate = date('F j, Y', strtotime($row["reserveDate"]));
                            $reserveAt = date('h:i A', strtotime($row["reserveAt"]));
                            ?>
                            <div class="reservation-item">
                                <div class="reservation-details">
                                    <div>
                                        <strong><?php echo htmlspecialchars($row["roomName"]); ?></strong> - 
                                        <?php echo $reserveDate; ?>, <?php //echo $reserveAt; ?> 
                                        (<?php echo htmlspecialchars($row["slot"]); ?>)
                                    </div>
                                    <div class="reservation-actions">
                                        <a href="userViewRejectedDetails.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No rejected reservations found.</p>';
                    }

                    // Close rejected reservations statement
                    $stmtRejected->close();

                    // Close connection
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- /.content -->
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
include('userFooter.php');
?>
</body>
</html>
