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
//    die("Connection failed: " . $conn->connect_error);
//}

// Handle delete request
if (isset($_GET['delete'])) {
    $slotId = $_GET['delete'];
    $deleteSql = "DELETE FROM slot WHERE id = $slotId";
    if ($conn->query($deleteSql) === TRUE) {
        echo "Slot deleted successfully";
    } else {
        echo "Error deleting slot: " . $conn->error;
    }
}

// Handle add new slot (TKMAU ADD KAT PAGE NI)
//if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['newSlot'])) {
//    $newSlot = $_POST['newSlot'];
//    $insertSql = "INSERT INTO slot (slot) VALUES (?)";
//    $stmt = $conn->prepare($insertSql);
//    $stmt->bind_param("s", $newSlot);
//    if ($stmt->execute()) {
//        echo "New slot added successfully";
//    } else {
//        echo "Error adding slot: " . $stmt->error;
//    }
//    $stmt->close();
//}

// Fetch slot data
$sql = "SELECT id, slot FROM slot";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Slots</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f4f4;
            padding: 0;
            margin: 0;
        }
        .content-wrapper {
            margin-left: 250px; /* Adjust this if your sidebar width is different */
            padding: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        th, td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        th {
            background-color: #f2f2f2;
        }
        .btn {
            padding: 5px 10px;
            color: white;
            background-color: #007bff;
            text-decoration: none;
            border-radius: 5px;
        }
        .btn-danger {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
         <!-- Content Header (Page header) -->
        <!--<div class="content-header">
            <h1>Manage Slots</h1>
        </div> -->
        <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Admin Dashboard</h1>
                    <h2 class="m-0">Manage Slots</h2>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Manage Slot</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->


        <!-- Main content -->
        <section class="content">
            <!--<form action="" method="POST">
                <label for="newSlot">Add New Slot:</label>
                <input type="text" id="newSlot" name="newSlot" required>
                <button type="submit" class="btn">Add Slot</button>
            </form> TKMAU ADD SLOT KAT SINI-->
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Slot</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["id"] . "</td>";
                            echo "<td>" . $row["slot"] . "</td>";
                            echo "<td>
                                  <a href='adminEditSlot.php?id=" . $row["id"] . "' class='btn'>Edit</a>
                                  <a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure you want to delete this slot?\")'>Delete</a>
                                  </td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No slots found</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
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
</body>
</html>
