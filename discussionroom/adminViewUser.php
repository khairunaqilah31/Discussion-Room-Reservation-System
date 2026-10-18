<?php 
// Start session to use session variables
session_start();

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

// Fetch role from URL parameter and sanitize it
$selectedRole = isset($_GET['role']) ? $_GET['role'] : 'all';
$validRoles = ['admin', 'user'];
$roleQuery = "";

if (in_array($selectedRole, $validRoles)) {
    $roleQuery = " WHERE role = ?";
}

// Prepare SQL based on selected role
$sql = "SELECT id, name, email, contact_number, role FROM user" . $roleQuery . " ORDER BY name";
$stmt = $conn->prepare($sql);
if ($roleQuery) {
    $stmt->bind_param("s", $selectedRole);
}
$stmt->execute();
$result = $stmt->get_result();
?>

<style>
    th, td {
        text-align: center; /* Center content of all cells */
        vertical-align: middle; /* Align content vertically in the middle */
    }

    .badge {
        display: inline-block;
        padding: 0.5em 0.75em;
        font-size: 1em;
        font-weight: 700;
        line-height: 1;
        text-align: center;
        white-space: nowrap;
        vertical-align: baseline;
        border-radius: 0.375rem;
        color: #fff;
        box-shadow: 0 2px 2px rgba(0, 0, 0, 0.2);
    }

   .badge-admin {
        background-color: #004085;
    }

    .badge-user {
        background-color: #20c997;
    }

    .action-button {
        padding: 0.375rem 0.75rem;
        font-size: 1rem;
        line-height: 1.5;
        border-radius: 0.25rem;
        color: #fff;
        background-color: #007bff;
        border: none;
        text-decoration: none;
    }

    .action-button:hover {
        background-color: #0056b3;
    }
</style>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">All Users</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">View Users</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <!-- Dropdown for filtering -->
                    <select id="roleFilter" class="form-control mb-4" onchange="filterRole()">
                        <option value="all" <?php echo $selectedRole == 'all' ? 'selected' : ''; ?>>All</option>
                        <option value="admin" <?php echo $selectedRole == 'admin' ? 'selected' : ''; ?>>Admin</option>
                        <option value="user" <?php echo $selectedRole == 'user' ? 'selected' : ''; ?>>User</option>
                    </select>

                    <script>
                        function filterRole() {
                            var selectedRole = document.getElementById('roleFilter').value;
                            window.location.href = '?role=' + selectedRole;
                        }
                    </script>

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>UserID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>ContactNo</th>
                                <th>Role</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            if ($result->num_rows > 0) {
                                $index = 1;
                                while($row = $result->fetch_assoc()) {
                                    $badgeClass = 'badge-' . strtolower($row['role']); // Determines the badge class based on role
                                    echo "<tr>";
                                    echo "<td>" . $index++ . "</td>"; // Numbering column
                                    echo "<td>" . $row["id"] . "</td>";
                                    echo "<td>" . $row["name"] . "</td>";
                                    echo "<td>" . $row["email"] . "</td>";
                                    echo "<td>" . $row["contact_number"] . "</td>";
                                    echo "<td><span class='badge $badgeClass'>" . ucfirst($row["role"]) . "</span></td>"; // Apply badge class
                                    echo "<td><a href='adminViewUserReservations.php?user_id=" . $row["id"] . "' class='action-button'>View Reservations</a></td>"; // Action button
                                    echo "</tr>";
                                }
                            } else {
                                echo "<tr><td colspan='6'>No users found</td></tr>";
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
$stmt->close();
$conn->close();
//include 'adminFooter.php'; 
include('adminFooter.php');
?>
