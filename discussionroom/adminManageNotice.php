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
//$dbname = "dcroomdb";

//$conn = new mysqli($servername, $username, $password, $dbname);
//if ($conn->connect_error) {
 //   die("Connection failed: " . $conn->connect_error);
//}

// Handle delete request
if (isset($_GET['delete'])) {
    $noticeId = $_GET['delete'];
    $deleteSql = "DELETE FROM notice WHERE id = $noticeId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Notice deleted successfully";
    } else {
        echo "Error deleting notice: " . $conn->error;
    }
}

// Fetch notice data
$sql = "SELECT * FROM notice ORDER BY posted_date DESC";
$result = $conn->query($sql);
?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Manage Notices</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Manage Notices</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Manage Notice Table -->
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <h2>Notices</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Posted Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                while($row = $result->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["title"] . "</td>";
                                    echo "<td>" . $row["description"] . "</td>";
                                    echo "<td>" . $row["posted_date"] . "</td>";
                                    echo "<td>
                                            <a href='adminEditNotice.php?id=" . $row["id"] . "' class='btn btn-warning'>Edit</a>
                                            <a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                                          </td>";
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='5'>No notices found</td></tr>";
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

<?php 
//$conn's close();
$conn->close(); // Corrected line
//include 'adminFooter.php'; 
include('adminFooter.php');
?>
