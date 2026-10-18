<?php 
//include 'adminHeader.php'; 
//include 'adminSidebar.php'; 

include('dbConfiguration.php');
include('adminHeader.php');
//include('adminSidebar.php');

// Database connection
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "dcroomdb"; // Replace with your database name

//$conn = new mysqli($servername, $username, $password, $dbname);

//if ($conn->connect_error) {
//    die("Connection failed: " . $conn->connect_error);
//}

if (isset($_GET['id'])) {
    $roomId = $_GET['id'];
    $sql = "SELECT * FROM room WHERE id = $roomId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $room = $result->fetch_assoc();
    } else {
        echo "Room not found.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomId = $_POST['roomId'];
    $roomName = $_POST['roomName'];
    $roomCapacity = $_POST['roomCapacity'];
    $roomDescription = $_POST['roomDescription'];
    
    $updateSql = "UPDATE room SET roomName='$roomName', roomCapacity=$roomCapacity, roomDescription='$roomDescription'";

    if (!empty($_FILES['roomPicture']['tmp_name'])) {
        $roomPicture = $_FILES['roomPicture']['tmp_name'];
        $roomPictureData = addslashes(file_get_contents($roomPicture));
        $updateSql .= ", roomPicture='$roomPictureData'";
    }

    $updateSql .= " WHERE id = $roomId";

    if ($conn->query($updateSql) === TRUE) {
        //echo "Room updated successfully";
        header("Location: adminManageRoom.php"); // Redirect to manage rooms page
        echo "Room updated successfully";
        exit;
    } else {
        echo "Error: " . $updateSql . "<br>" . $conn->error;
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
<?php //include 'adminHeader.php'; ?>
<?php include 'adminSidebar.php'; ?>
    <!-- Content Header (Page header) -->
     
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item"><a href="adminManageRoom.php">Manage Room</a></li>
                        <li class="breadcrumb-item active">Edit Room</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Edit Room Form -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2>Edit Room</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <input type="hidden" name="roomId" value="<?php echo $room['id']; ?>">
                        <div class="form-group">
                            <label for="roomName">Room Name</label>
                            <input type="text" class="form-control" id="roomName" name="roomName" value="<?php echo $room['roomName']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="roomCapacity">Room Capacity</label>
                            <input type="number" class="form-control" id="roomCapacity" name="roomCapacity" value="<?php echo $room['roomCapacity']; ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="roomDescription">Room Description</label>
                            <textarea class="form-control" id="roomDescription" name="roomDescription" required><?php echo $room['roomDescription']; ?></textarea>
                        </div>
                        <div class="form-group">
                            <label for="roomPicture">Room Picture (Leave blank to keep current picture)</label>
                            <input type="file" class="form-control" id="roomPicture" name="roomPicture">
                        </div>
                        <button type="submit" class="btn btn-primary">Update Room</button>
                    </form>
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

<?php 
$conn->close();
//include 'adminFooter.php'; 
include('adminFooter.php');
?>
