<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<!--<title>Your Page Title</title>-->
<style>
    /* Basic Reset */
    body, html {
        margin: 0;
        padding: 0;
        height: 100%;
    }

    /* Sidebar Styles */
    .sidebar {
        position: fixed;
        height: 100%;
        width: 250px;
        z-index: 1000;
    }

    /* Footer Styles */
    .footer {
        position: fixed;
        left: 0;
        bottom: 0;
        width: 100%;
        background-image: linear-gradient(135deg, #667eea, #764ba2); /* Gradient background */
        color: white; /* White text */
        text-align: center;
        padding: 10px 0;
        z-index: 5; /* Ensure it's above the content but below pop-ups */
    }

    /* Content container to avoid footer overlap */
    .content {
        padding-bottom: 50px; /* Adjust this value based on the footer height */
    }
</style>
</head>
<body>
<div class="userSidebar">
    <!-- Sidebar content here -->
</div>

<div class="wrapper content">
    <!-- Page Content here -->
</div>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<!-- Bootstrap 4 -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.1/dist/js/adminlte.min.js"></script>

<!-- Custom Script for Sidebar Toggle -->
<script>
    $(document).ready(function () {
        // Toggle sidebar on click
        $('.sidebar-toggle').on('click', function () {
            $('.sidebar').toggleClass('active');
        });
    });
</script>

<!-- Footer -->
<p class="footer">This is DC ROOM SYSTEM @ 2024 #USERside, made by Najihah, Aqilah, Wani, Nureen.</p>

</body>
</html>
