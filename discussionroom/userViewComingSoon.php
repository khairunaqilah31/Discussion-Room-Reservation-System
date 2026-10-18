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

$user_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard - Coming Soon Reservations</title>
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
                    <h2>Coming Soon Reservations</h2>
                    <?php
                    include('dbConfiguration.php');

                    // Query upcoming reservations for the current user
                    $sql = "SELECT r.id, r.reserveDate, r.reserveAt, ro.roomName, s.slot
                            FROM reservation r
                            INNER JOIN room ro ON r.roomID = ro.id
                            INNER JOIN slot s ON r.slotID = s.id
                            WHERE r.userID = ? AND r.approvalStatus = 'approved' AND r.reserveDate >= CURDATE()
                            ORDER BY r.reserveAt";

                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $user_id);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Output data of each row
                        while ($row = $result->fetch_assoc()) {
                            $reserveDate = date('F j, Y', strtotime($row["reserveDate"]));
                            $reserveAt = date('h:i A', strtotime($row["reserveAt"]));

                            // Calculate days left until reservation date
                            $today = new DateTime();
                            $reserveDateTime = new DateTime($row["reserveDate"]);
                            $interval = $today->diff($reserveDateTime);
                            $daysLeft = $interval->days;

                            ?>
                            <div class="reservation-item">
                                <div class="reservation-details">
                                    <div>
                                        <strong><?php echo htmlspecialchars($row["roomName"]); ?></strong> - 
                                        <?php echo $reserveDate; ?>, <?php echo htmlspecialchars($row["slot"]); ?>
                                    </div>
                                    <div class="reservation-actions">
                                        <?php if ($daysLeft > 0) { ?>
                                            <span class="text-muted"><?php echo $daysLeft; ?> days left. Mark your calendar!</span>
                                        <?php } elseif ($daysLeft == 0) { ?>
                                            <span class="text-muted">This reservation is Today. Don't Miss it!</span>
                                        <?php } ?>
                                        <a href="userViewComingSoonDetails.php?id=<?php echo htmlspecialchars($row['id']); ?>" class="btn btn-primary">View Details</a>
                                    </div>
                                </div>
                            </div>
                            <?php
                        }
                    } else {
                        echo '<p>No Coming Soon reservations found.</p>';
                    }

                    // Close connection
                    $stmt->close();
                    $conn->close();
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('userFooter.php'); ?>

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
</body>
</html>
