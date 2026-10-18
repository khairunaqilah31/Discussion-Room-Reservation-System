<?php //include 'userHeader.php'; ?>
<?php //include 'userSidebar.php'; ?>

<?php 
include('userHeader.php');
include('userSidebar.php');
?>

<?php
include('dbConfiguration.php');
// Database connection parameters
//$host = 'localhost'; // or your host
//$username = 'root';
//$password = '';
//$dbname = 'dcroomdb';

// Create connection
//$conn = new mysqli($host, $username, $password, $dbname);

// Check connection
//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

// Fetch notices from the database
$sql = "SELECT id, title, description, posted_date FROM notice ORDER BY posted_date DESC";
$result = $conn->query($sql);
$notices = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $notices[] = $row;
    }
} else {
    echo "0 results";
}
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notices</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .notice-title {
            cursor: pointer;
            color: #3366BB;
        }
        .notice-title:hover {
            background-color: #f5f5f5;
        }
        .collapse td {
            background: #f9f9f9;
        }
    </style>
</head>
<body>
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Notices</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="userDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Notices</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Title</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($notices as $notice): ?>
                        <tr class="notice-title" data-toggle="collapse" data-target="#notice-desc-<?php echo $notice['id']; ?>" aria-expanded="false">
                            <td><?php echo htmlspecialchars($notice['title']); ?></td>
                        </tr>
                        <tr id="notice-desc-<?php echo $notice['id']; ?>" class="collapse">
                            <td>
                                <p><?php echo nl2br(htmlspecialchars($notice['description'])); ?></p>
                                <small>Posted on: <?php echo htmlspecialchars(date('F j, Y, g:i a', strtotime($notice['posted_date']))); ?></small>
                            </td>
                        </tr>
                    <?php endforeach; ?>
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
//include 'userFooter.php'; 
include('userFooter.php');
?>
</body>
</html>
