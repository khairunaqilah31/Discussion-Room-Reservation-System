<?php 
ob_start();
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
//    die("Connection failed: " . $conn->connect_error);
//}

// Fetch all slots from the database
$slots = [];
$sql = "SELECT * FROM slot";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $slots[] = $row;
    }
}

$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $slot = $_POST['slot'];

    $sql = "INSERT INTO slot (slot) VALUES ('$slot')";

    if ($conn->query($sql) === TRUE) {
        $success_message = "New slot added successfully";
        // Refresh the page to show the updated list of slots
        header("Location: " . $_SERVER['PHP_SELF'] . "?success=" . urlencode($success_message));
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

if (isset($_GET['success'])) {
    $success_message = $_GET['success'];
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
                        <li class="breadcrumb-item active">Add Slot</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <!-- Add Slot Form -->
            <div class="row mb-4">
                <div class="col-md-6">
                    <h2>Add Slot</h2>
                    <form action="" method="POST">
                        <div class="form-group">
                            <label for="slot">Slot</label>
                            <input type="text" class="form-control" id="slot" name="slot" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Add Slot</button>
                    </form>
                </div>
            </div>

            <!-- Display Slots -->
            <div class="row">
                <div class="col-md-12">
                    <h2>Existing Slots</h2>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Slot</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($slots as $index => $slot): ?>
                                <tr>
                                    <td><?php echo $index + 1; ?></td>
                                    <td><?php echo htmlspecialchars($slot['slot']); ?></td>
                                </tr>
                            <?php endforeach; ?>
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
//include 'adminFooter.php'; 
include('adminFooter.php');
ob_end_flush();
?>

<?php if (!empty($success_message)): ?>
    <script type="text/javascript">
        alert("<?php echo $success_message; ?>");
    </script>
<?php endif; ?>
