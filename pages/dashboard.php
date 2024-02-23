<?php

require_once "../app/database/connection.php";
require_once "../path.php";

session_start();

?>

<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="utf-8">
    <title>Calendar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Rounded:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200">

    <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    <link rel="stylesheet" href="../assets/css/dashboard.css?v=<?php echo time(); ?>">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body>
    <!-- start main container -->
        <div class="container-fluid">
        <?php include(ROOT_PATH . "/app/includes/header.php"); ?>
        <?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        <?php //include("../app/includes/header.php"); ?>
        <?php //include("../app/includes/sidebar.php"); ?>
        
            
            <!-- start container -->
                <div class="container" style="margin-left: 300px; margin-top: 80px;">
                    <!-- start row -->
                        <div class="row">
                            <div class="page-header mx-auto mb-2">
                                <p class="page_title" style="float: left; padding-top: 2px;">Dashboard</p>
                            </div>
                            <!-- start col-8 -->
                                <div class="col-lg-8">

                                    <div class="row gap-4">
                                        <div class="card" style="width: 12rem;">
                                            <div class="card-body">
                                                <div class="position-relative">
                                                    <i class="bi bi-three-dots text-secondary position-absolute top-0 end-0" style="margin-right: -10px !important; margin-top: -10px !important;"></i>
                                                </div>
                                                <div class="mt-3"></div>
                                                <div class="float-start w-25">
                                                    <i class="bi bi-clipboard2 fs-3"></i>
                                                </div>
                                                <div class="float-end text-start ps-2 w-75">
                                                    <h6 class="mb-1 text-secondary" style="font-size: 10px;">Active Tasks</h6>
                                                    <?php
                                                        $sql="SELECT count('1') FROM tasks WHERE status = 0";
                                                        $result=mysqli_query($conn,$sql);
                                                        $rowtotal=mysqli_fetch_array($result); 
                                                    ?>
                                                    <p class="mb-0"><?php echo "$rowtotal[0]"; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="width: 12rem;">
                                            <div class="card-body">
                                                <div class="position-relative">
                                                    <i class="bi bi-three-dots text-secondary position-absolute top-0 end-0 mt-1" style="margin-right: -10px !important; margin-top: -10px !important;"></i>
                                                </div>
                                                <div class="mt-3"></div>
                                                <div class="float-start w-25">
                                                    <i class="bi bi-clipboard2-check fs-3"></i>
                                                </div>
                                                <div class="float-end text-start ps-2 w-75">
                                                    <h6 class="mb-1 text-secondary" style="font-size: 10px;">Total Tasks</h6>
                                                    <?php
                                                        $sql="SELECT count('1') FROM tasks";
                                                        $result=mysqli_query($conn,$sql);
                                                        $rowtotal=mysqli_fetch_array($result); 
                                                    ?>
                                                    <p class="mb-0"><?php echo "$rowtotal[0]"; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="width: 12rem;">
                                            <div class="card-body">
                                                <div class="position-relative">
                                                    <i class="bi bi-three-dots text-secondary position-absolute top-0 end-0 mt-1" style="margin-right: -10px !important; margin-top: -10px !important;"></i>
                                                </div>
                                                <div class="mt-3"></div>
                                                <div class="float-start w-25">
                                                    <i class="bi bi-calendar-range fs-3"></i>
                                                </div>
                                                <div class="float-end text-start ps-2 w-75">
                                                    <h6 class="mb-1 text-secondary" style="font-size: 10px;">Active Audits</h6>
                                                    <?php
                                                        $sql="SELECT count('1') FROM audits WHERE status = 0";
                                                        $result=mysqli_query($conn,$sql);
                                                        $rowtotal=mysqli_fetch_array($result); 
                                                    ?>
                                                    <p class="mb-0"><?php echo "$rowtotal[0]"; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="card" style="width: 12rem;">
                                            <div class="card-body">
                                                <div class="position-relative">
                                                    <i class="bi bi-three-dots text-secondary position-absolute top-0 end-0 mt-1" style="margin-right: -10px !important; margin-top: -10px !important;"></i>
                                                </div>
                                                <div class="mt-3"></div>
                                                <div class="float-start w-25">
                                                    <i class="bi bi-journal-text fs-3"></i>
                                                </div>
                                                <div class="float-end text-start ps-2 w-75">
                                                    <h6 class="mb-1 text-secondary" style="font-size: 10px;">Total Audits</h6>
                                                    <?php
                                                        $sql="SELECT count('1') FROM audits ";
                                                        $result=mysqli_query($conn,$sql);
                                                        $rowtotal=mysqli_fetch_array($result); 
                                                    ?>
                                                    <p class="mb-0"><?php echo "$rowtotal[0]"; ?></p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-3"></div>

                                    <div class="page-header" style="margin-left: -10px; margin-bottom: -15px;">
                                        <p>Task Activity</p>
                                    </div>

                                    <canvas id="myChart" width="800" height="350" style="border: none; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); margin-left: -15px; max-width: 845px;background-color: white;"></canvas>

                                    <div class="mt-3"></div>

                                    <div class="page-header" style="margin-left: -10px; margin-bottom: -15px;">
                                        <p class="" style="float: left;">Latest Task Updates</p> <a id="showMoreBtn" class="badge text-decoration-none" href="#">Show More</a>
                                    </div>

                                    <div id="taskContainer" class="task-container my-auto">
                                        <?php
                                        // Include database connection
                                        // require_once "../database/connection.php";

                                        // Fetch latest 2 tasks from the database along with client name
                                        $new = "SELECT tasks.*, clients.client_name 
                                                FROM tasks 
                                                INNER JOIN clients ON tasks.client_idno = clients.idno
                                                ORDER BY tasks.updated_at DESC 
                                                LIMIT 2";
                                        $newresult = mysqli_query($conn, $new);

                                        // Iterate through tasks and display them
                                        while ($task = mysqli_fetch_assoc($newresult)) {
                                            // Format date
                                            $formattedDate = date('j M Y', strtotime($task['updated_at']));
                                            // Output task card
                                            ?>
                                    
                                        <div class="task-card">
                                            <p class="text-secondary fw-semibold my-auto text-truncate" style="max-width: 200px;"><?php echo $task['title']; ?></p>
                                            <p class="text-secondary my-auto ms-4"><?php echo $formattedDate; ?></p>
                                            <div class="progress my-auto">
                                                <div class="progress-bar" role="progressbar" style="width: <?php echo $task['progress']; ?>%;" aria-valuenow="<?php echo $task['progress']; ?>" aria-valuemin="0" aria-valuemax="100"></div>
                                            </div>
                                            <p class="text-secondary my-auto" style="margin-left: 80px;"><?php echo $task['client_name']; ?></p>
                                            <p class="text-secondary my-auto end" style="padding-right: 0 !important; margin-right: 0 !important:">
                                                <button type="button" class="btn btn-link" data-bs-toggle="modal" data-bs-target="#taskModal<?php echo $task['id']; ?>">
                                                    <i class="bi bi-three-dots-vertical" styl="margin: 0 !important; padding: 0 !important;"></i>
                                                </button>
                                                <!-- Modal -->
                                                    <div class="modal fade" id="taskModal<?php echo $task['id']; ?>" tabindex="-1" aria-labelledby="taskModalLabel<?php echo $task['id']; ?>" aria-hidden="true">
                                                        <div class="modal-dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="taskModalLabel<?php echo $task['id']; ?>">Task Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- Your task details content here -->
                                                                    <p>Title: <?php echo $task['title']; ?></p>
                                                                    <p>Date: <?php echo $formattedDate; ?></p>
                                                                    <p>Progress: <?php echo $task['progress']; ?>%</p>
                                                                    <p>Client: <?php echo $task['client_name']; ?></p>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                                    <!-- Additional buttons or actions can be added here -->
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <!-- end modal -->
                                            </p>
                                        </div>
                                       <?php }
                                    
                                        // Close database connection
                                        mysqli_close($conn);
                                        ?>
                                    </div>

                                    
                                

                                </div>
                            <!-- end col-8 -->

                            <!-- start col-4 -->
                                <div class="col-lg-4">

                                    <div class="calendar-container mx-auto"> 
                                        <header class="calendar-header">
                                            <p class="calendar-current-date"></p>
                                            <div class="calendar-navigation">
                                                <span id="calendar-prev" class="material-symbols-rounded">chevron_left</span>
                                                <span id="calendar-next" class="material-symbols-rounded">chevron_right</span>
                                            </div>
                                        </header>
                                        <div class="calendar-body">
                                            <ul class="calendar-weekdays">
                                                <li>Sun</li>
                                                <li>Mon</li>
                                                <li>Tue</li>
                                                <li>Wed</li>
                                                <li>Thu</li>
                                                <li>Fri</li>
                                                <li>Sat</li>
                                            </ul>
                                            <ul class="calendar-dates"></ul>
                                        </div>
                                    </div>


                                    <canvas id="auditTypeChart" class="" width="350" height="200" style="border:none; box-shadow: 0 15px 40px rgba(0, 0, 0, 0.12); margin-left:30px; max-width: 845px;background-color: white;"></canvas>

                                </div>
                            <!-- end col-4 -->
                        </div>
                    <!-- end row -->
                </div>
            <!-- end container -->
        </div> 
    <!-- end main container -->

    <script src="../assets/js/calendar.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/taskChart.js?v=<?php echo time(); ?>"></script>
    <script src="../assets/js/auditGraph.js?v=<?php echo time(); ?>"></script>
    <!-- <script src="../assets/js/grab_tasks.js?v=<?php echo time(); ?>"></script> -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>