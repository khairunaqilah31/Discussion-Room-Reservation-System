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
//    die("Connection failed: " . $conn->connect_error);
//}

$roleFilter = $_GET['role'] ?? 'all'; // Get the role filter from the URL parameter, default is 'all'

// Handle delete request
if (isset($_GET['delete'])) {
    $user_id = $_GET['delete'];
    $deleteSql = "DELETE FROM user WHERE id = $user_id";
    if ($conn->query($deleteSql) === TRUE) {
        echo "User deleted successfully";
    } else {
        echo "Error deleting user: " . $conn->error;
    }
}

// Adjust SQL based on filter
$sql = "SELECT id, name, email, role FROM user";
if ($roleFilter === 'admin') {
    $sql .= " WHERE role = 'admin'";
} elseif ($roleFilter === 'user') {
    $sql .= " WHERE role = 'user'";
}

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Users</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f4;
        }
        .content-wrapper {
            margin-left: 200px; /* Adjust based on your sidebar width */
            padding: 20px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            margin-top: 20px;
        }
        .table th, .table td {
            padding: 8px;
            border: 1px solid #ddd;
        }
        .table th {
            background-color: #f2f2f2;
        }
        .table td {
            background-color: #fff;
        }
        .btn {
            text-decoration: none;
            padding: 5px 10px;
            color: white;
            border-radius: 5px;
            text-align: center;
        }
        .btn-warning {
            background-color: #f0ad4e;
        }
        .btn-danger {
            background-color: #d9534f;
        }
        select {
            padding: 8px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="content-wrapper">
        <h1>Manage Users</h1>
        <form action="" method="GET">
            <label for="role">Filter by Role:</label>
            <select name="role" id="role" onchange="this.form.submit()">
                <option value="all" <?= $roleFilter == 'all' ? 'selected' : '' ?>>All</option>
                <option value="admin" <?= $roleFilter == 'admin' ? 'selected' : '' ?>>Admins</option>
                <option value="user" <?= $roleFilter == 'user' ? 'selected' : '' ?>>Users</option>
            </select>
        </form>
        <table class="table">
            <thead>
                <tr>
                    <th>#</th>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if ($result->num_rows > 0) {
                    $index = 1;
                    while($row = $result->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $index++ . "</td>"; // Numbering column
                        echo "<td>" . $row["id"] . "</td>";
                        echo "<td>" . $row["name"] . "</td>";
                        echo "<td>" . $row["email"] . "</td>";
                        echo "<td>" . $row["role"] . "</td>";
                        echo "<td>
                                <a href='adminEditUser.php?id=" . $row["id"] . "' class='btn btn-warning'>Edit</a>
                                <a href='?delete=" . $row["id"] . "' class='btn btn-danger' onclick='return confirm(\"Are you sure?\")'>Delete</a>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
            </tbody>
        </table>
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


    <?php 
    $conn->close();
    //include 'adminFooter.php'; 
    include('adminFooter.php');

    ?>
</body>
</html>
