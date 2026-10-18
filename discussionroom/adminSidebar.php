<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="adminDashboard.php" class="brand-link">
        <img src="assets/uitmLogo.png" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">DC Room System</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        <!-- User Panel -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <p>ADMIN</p>
            </div>
        </div>

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a href="adminDashboard.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <!-- Rooms -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-door-closed"></i>
                        <p>
                            Rooms
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="adminAddRoom.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Room</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageRoom.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Rooms</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Reservations -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Reservations
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="adminManagePending.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Pending</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminViewApproved.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Approved</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminViewRejected.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Rejected</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminViewAll.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View All</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Slots -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-clock"></i>
                        <p>
                            Slots
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="adminAddSlot.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Slot</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageSlot.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Slots</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Users -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-users"></i>
                        <p>
                            Users
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="adminViewUser.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>View Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageUser.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Users</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Notice -->
                <li class="nav-item">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-bullhorn"></i>
                        <p>
                            Notice
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="adminAddNotice.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Add Notice</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="adminManageNotice.php" class="nav-link">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Manage Notices</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <!-- Print Report -->
                <li class="nav-item">
                    <a href="adminPrintReport.php" class="nav-link">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Print Report</p>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
