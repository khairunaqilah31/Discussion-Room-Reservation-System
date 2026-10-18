<?php 
ob_start(); // Start buffering the output
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
  //  die("Connection failed: " . $conn->connect_error);
//}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $description = $_POST['description'];

    $sql = "INSERT INTO notice (title, description) VALUES ('$title', '$description')";

    if ($conn->query($sql) === TRUE) {
        header("Location: adminManageNotice.php"); // Redirect to manage notices page
        exit;
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
                   <!-- <h1 class="m-0">Dashboard</h1> -->
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Add Notice</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Add Notice Form -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2>Add Notice</h2>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" class="form-control" id="title" name="title" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea class="form-control" id="description" name="description" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Notice</button>
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
ob_end_flush(); // Flush the output buffer and turn off output buffering
?>
