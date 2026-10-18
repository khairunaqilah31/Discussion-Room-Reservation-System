<?php //include 'adminHeader.php'; ?>
<?php //include 'adminSidebar.php'; ?>

<?php 
include('dbConfiguration.php');
include('adminHeader.php');
include('adminSidebar.php');
 ?>

<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Dashboard</h1>
                    <p>Welcome to admin Dashboards</p>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="adminDashboard.php">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>
    <!-- /.content-header -->

    <!-- Main content -->
    <section class="content">
        <!-- Your main content here -->
         
    </section>
    <!-- /.content -->
</div>
<!-- /.content-wrapper -->
<?php 
include('adminFooter.php');
?>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
$(document).ready(function() {
    $('.notice-title').click(function() {
        var targetId = $(this).data('target');
        $(targetId).collapse('toggle');
    });
});

<?php //include 'adminFooter.php'; ?>
<?php 
//include('adminFooter.php');
?>

