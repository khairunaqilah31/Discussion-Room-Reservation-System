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
    $slotId = $_GET['id'];
    $sql = "SELECT * FROM slot WHERE id = $slotId";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $slot = $result->fetch_assoc();
    } else {
        echo "Slot not found.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $slotId = $_POST['slotId'];
    $slotName = $_POST['slotName']; // Assuming 'slot' is the field to be updated
    
    $updateSql = "UPDATE slot SET slot = '$slotName' WHERE id = $slotId";

    if ($conn->query($updateSql) === TRUE) {
       // echo "Slot updated successfully";
        header("Location: adminManageSlot.php"); // Redirect to manage slots page
        echo "Slot updated successfully";
        exit;
    } else {
        echo "Error updating slot: " . $conn->error;
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
                        <li class="breadcrumb-item"><a href="adminManageSlot.php">Manage Slot</a></li>
                        <li class="breadcrumb-item active">Edit Slot</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Edit Slot Form -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2>Edit Slot</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="slotId" value="<?php echo $slot['id']; ?>">
                        <div class="form-group">
                            <label for="slotName">Slot Name</label>
                            <input type="text" class="form-control" id="slotName" name="slotName" value="<?php echo $slot['slot']; ?>" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Slot</button>
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
