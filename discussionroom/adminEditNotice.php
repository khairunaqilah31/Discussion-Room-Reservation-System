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
 //   die("Connection failed: " . $conn->connect_error);
//}

if (isset($_GET['id'])) {
    $noticeId = $_GET['id'];
    $sql = "SELECT * FROM notice WHERE id = $noticeId";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $notice = $result->fetch_assoc();
    } else {
        echo "Notice not found.";
        exit;
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $noticeId = $_POST['noticeId'];
    $title = $_POST['title'];
    $description = $_POST['description'];

    $updateSql = "UPDATE notice SET title='$title', description='$description' WHERE id = $noticeId";

    if ($conn->query($updateSql) === TRUE) {
        //echo "Notice updated successfully";
        header("Location: adminManageNotice.php"); // Redirect to manage notices page
        echo "Notice updated successfully";
        exit;
    } else {
        echo "Error updating notice: " . $conn->error;
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
                        <li class="breadcrumb-item"><a href="adminManageNotice.php">Manage Notices</a></li>
                        <li class="breadcrumb-item active">Edit Notice</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Edit Notice Form -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h2>Edit Notice</h2>
                    <form action="" method="POST">
                        <input type="hidden" name="noticeId" value="<?php echo $notice['id']; ?>">
                        <div class="form-group">
                            <label for="title">Title</label>
                            <!--<input type="text" class="form-control" id="title" name="title" value="<?php echo $notice['title']; ?>" required>-->
                            <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($notice['title']); ?>" required>
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <!--<textarea class="form-control" id="description" name="description" required><?php echo $notice['description']; ?></textarea>-->
                            <textarea class="form-control" id="description" name="description" required><?php echo htmlspecialchars($notice['description']); ?></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Update Notice</button>
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
