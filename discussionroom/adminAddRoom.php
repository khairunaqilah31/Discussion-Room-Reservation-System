<?php 
//include 'adminHeader.php'; 
//include 'adminSidebar.php'; 

include('dbConfiguration.php');
include('adminHeader.php');
include('adminSidebar.php');

// Database connection
//$servername = "localhost";
//$username = "root";
//$password = "";
//$dbname = "dcroomdb"; // Replace with your database name

//$conn = new mysqli($servername, $username, $password, $dbname);

//if ($conn->connect_error) {
 //   die("Connection failed: " . $conn->connect_error);
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $roomName = $_POST['roomName'];
    $roomCapacity = $_POST['roomCapacity'];
    $roomDescription = $_POST['roomDescription'];
    $roomPicture = $_FILES['roomPicture']['tmp_name'];

    // Read the file content into a variable
    $roomPictureData = addslashes(file_get_contents($roomPicture));

    $sql = "INSERT INTO room (roomName, roomCapacity, roomDescription, roomPicture) VALUES ('$roomName', $roomCapacity, '$roomDescription', '$roomPictureData')";

    if ($conn->query($sql) === TRUE) {
        echo "New room added successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
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
                        <li class="breadcrumb-item active">Add Room</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Add Room Form -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2>Add Room</h2>
                    <form action="" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label for="roomName">Room Name</label>
                            <input type="text" class="form-control" id="roomName" name="roomName" required>
                        </div>
                        <div class="form-group">
                            <label for="roomCapacity">Room Capacity</label>
                            <input type="number" class="form-control" id="roomCapacity" name="roomCapacity" required>
                        </div>
                        <div class="form-group">
                            <label for="roomDescription">Room Description</label>
                            <textarea class="form-control" id="roomDescription" name="roomDescription" required></textarea>
                        </div>
                        <div class="form-group">
                            <label for="roomPicture">Room Picture</label>
                            <input type="file" class="form-control" id="roomPicture" name="roomPicture" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Room</button>
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
//include 'adminFooter.php'; 
include('adminFooter.php');
?>
