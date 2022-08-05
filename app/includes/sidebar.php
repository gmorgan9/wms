<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="<?php echo BASE_URL . '/dashboard.php' ?>" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                <i class="bi bi-speedometer"></i>
                <span>  Dashboard</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/courses.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-mortarboard"></i>
                <span>  Courses</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/assignments.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-clipboard-data"></i>
                <span>  Assignments</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/progress-report.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-bar-chart"></i>
                <span>  Progress Report</span>
            </a>

            <?php if($_SESSION['isadmin'] == 1){ ?>
                <br>
                <span style="margin-left: 38px; margin-bottom: -10px;">Admin Links</span>
                <hr>
                <a style="margin-top: -15px;" href="<?php echo BASE_URL . '/admin/manage-users.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-bar-chart"></i>
                <span>  Manage Users</span>
                </a>
            <?php } else {} ?>
        </div>
    </div>
</nav>