<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="userDashboard.php" class="brand-link">
        <img src="assets/uitmLogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">DC Room System</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <p>USER</p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Dashboard -->
            <li class="nav-item">
                    <a href="userDashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            My Reservations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="userViewComingSoon.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Coming Soon</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="userViewPending.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="userViewRejected.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Rejected</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="userViewHistory.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View History</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Reserve Room
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="userReservationForm.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Reservation Form</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="userViewRoom.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Rooms</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>