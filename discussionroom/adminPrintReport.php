<?php 
include('dbConfiguration.php');
include('adminHeader.php');
include('adminSidebar.php');

$dataType = isset($_POST['dataType']) ? $_POST['dataType'] : 'users'; // Default to users

$sql = "";
switch ($dataType) {
    case 'users':
        $sql = "SELECT name, email, contact_number, role FROM user ORDER BY role DESC";
        break;
    case 'slots':
        $sql = "SELECT slot FROM slot";
        break;
    case 'rooms':
        $sql = "SELECT roomName, roomCapacity, roomDescription, roomPicture FROM room";
        break;
    case 'reservations':
        $sql = "SELECT reserveNo, reserveDate, 
                       (SELECT slot FROM slot WHERE slot.id = reservation.slotID) AS slot, 
                       (SELECT roomName FROM room WHERE room.id = reservation.roomID) AS room, 
                       (SELECT name FROM user WHERE user.id = reservation.userID) AS user, 
                       approvalStatus 
                FROM reservation 
                ORDER BY 
                    CASE 
                        WHEN approvalStatus = 'pending' THEN 1 
                        WHEN approvalStatus = 'approved' THEN 2 
                        WHEN approvalStatus = 'rejected' THEN 3 
                        ELSE 4 
                    END, 
                    reserveDate DESC";
        break;
}

$result = $conn->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Print Report</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <section class="content">
        <div class="container-fluid">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Print Data</h3>
                </div>
                <div class="card-body">
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="dataType">Select Data Type:</label>
                            <select name="dataType" id="dataType" class="form-control mb-4" onchange="this.form.submit()">
                                <option value="users" <?php if($dataType == 'users') echo 'selected'; ?>>Users</option>
                                <option value="slots" <?php if($dataType == 'slots') echo 'selected'; ?>>Slots</option>
                                <option value="rooms" <?php if($dataType == 'rooms') echo 'selected'; ?>>Rooms</option>
                                <option value="reservations" <?php if($dataType == 'reservations') echo 'selected'; ?>>Reservations</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">View Data</button>
                        <button type="button" class="btn btn-secondary" onclick="window.print();">Print</button>
                    </form>
                    <div class="table-responsive mt-4">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <?php
                                    if ($result->num_rows > 0) {
                                        $fields = $result->fetch_fields();
                                        foreach ($fields as $field) {
                                            echo "<th>" . htmlspecialchars($field->name) . "</th>";
                                        }
                                    }
                                    ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                if ($result->num_rows > 0) {
                                    $index = 1;
                                    while($row = $result->fetch_assoc()) {
                                        echo "<tr>";
                                        echo "<td>" . $index++ . "</td>"; // Numbering column
                                        foreach ($row as $key => $data) {
                                            if ($key == 'roomPicture') {
                                                // Display image if column is roomPicture
                                                echo "<td><img src='data:image/jpeg;base64," . base64_encode($data) . "' alt='Room Picture' style='max-width: 100px; height: auto;'></td>";
                                            } else {
                                                echo "<td>" . htmlspecialchars($data) . "</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                } else {
                                    echo "<tr><td colspan='5'>No data found</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
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
$conn->close();
include('adminFooter.php');
?>
