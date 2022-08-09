<nav id="sidebarMenu" class="collapse d-lg-block sidebar collapse bg-white">
    <div class="position-sticky">
        <div class="list-group list-group-flush mx-3 mt-4">
            <a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>" class="list-group-item list-group-item-action py-2 ripple" aria-current="true">
                <i class="bi bi-sliders2"></i>
                <span>  Dashboard</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/info.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-info-circle"></i>
                <span>  Information</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/timesheet.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-clock"></i>
                <span>  Timesheet</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/reports.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-bar-chart"></i>
                <span>  Reports</span>
            </a>
            <a href="<?php echo BASE_URL . '/pages/projects.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                <i class="bi bi-journal-bookmark"></i>
                <span>  Projects</span>
            </a>

            <?php if($_SESSION['acc_type'] == 1){ ?>
                <br>
                <span style="margin-left: 38px; margin-bottom: -10px;">Admin Links</span>
                <hr>
                <a style="margin-top: -15px;" href="<?php echo BASE_URL . '/admin/employees.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="bi bi-person-badge"></i>
                    <span>  Employees</span>
                </a>
                <!-- <a href="<?php //echo BASE_URL . '/admin/companies.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="bi bi-building"></i>
                    <span>  Companies</span>
                </a> -->
                <!-- <a href="<?php //echo BASE_URL . '/admin/departments.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="bi bi-people"></i>
                    <span>  Departments</span>
                </a> --> 
                <a href="<?php echo BASE_URL . '/admin/jobs.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="bi bi-briefcase"></i>
                    <span>  Jobs</span> &nbsp; &nbsp; <span class="badge rounded-pill text-bg-secondary">4</span>
                </a>
            <?php } else {?>
                <br>
                <span style="margin-left: 38px; margin-bottom: -10px;">Employee Links</span>
                <hr>
                <a style="margin-top: -15px;" href="<?php echo BASE_URL . '/pages/job_request.php' ?>" class="list-group-item list-group-item-action py-2 ripple">
                    <i class="bi bi-briefcase"></i>
                    <span>  Request Job</span>
                </a>

           <?php } ?>
        </div>
    </div>
</nav>