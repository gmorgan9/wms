<!-- WORKING -->
<?php

// REQUIRES
  require_once "../app/database/connection.php";
  require_once "../app/database/functions.php";
  require_once "../path.php";
// END REQURIES

session_start();

if(!isLoggedIn()){
   header('location: /login.php');
}

// ADD JOB
  if(isset($_POST['add-meeting'])){
    $meetingID = mysqli_real_escape_string($conn, $_POST['meetingID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $date = mysqli_real_escape_string($conn, $_POST['date']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $employee_fname = mysqli_real_escape_string($conn, $_POST['employee_fname']);
    $employee_lname = mysqli_real_escape_string($conn, $_POST['employee_lname']);
    $employee_idno = mysqli_real_escape_string($conn, $_POST['employee_idno']);

    $select = " SELECT * FROM task WHERE title = '$title' ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
      $error[] = 'Meeting already exist!';
    }else{
      // $insert2 = "INSERT INTO employee_company_data (employee_code, company_code, dept_code, job_code) SELECT employee_code, company_code, dept_code, jobID FROM job";
      $insert = "INSERT INTO task (idno, title, details, category, due_date, employee_idno, employee_fname, employee_lname) VALUES ('$idno','$title','$details','$category','$due_date','$employee_idno','$employee_fname', '$employee_lname')";
      mysqli_query($conn, $insert);
      // mysqli_query($conn, $insert2);
      header('location: tasks.php');
    }
  };
// END ADD JOB

// DELETE JOB (NOT IN USE)
  if(isset($_GET['jobID'])) {
    $id = $_GET['jobID'];

    $sql = "DELETE FROM job WHERE jobID = $id";
    $delete = mysqli_query($conn, $sql);
    if($delete) {
        // echo "Deleted Successfully";
        header('location: jobs_request.php'); // returns back to same page
    } else {
        die(mysqli_error($conn));
    }
  }
// END DELETE JOB (NOT IN USE)

// SET TERMINATED
  if (isset($_POST['terminated'])) {
    $terUpdateQuery = "UPDATE job SET approval_status = 'terminated' WHERE jobID = '".$_POST['jobID']."'";
    $terUpdateResult = mysqli_query($conn, $terUpdateQuery);
    header('location: job_request.php');
  }
// END SET TERMINATED

?>

<!DOCTYPE html>
<html lang="en">
<head>
   <meta charset="UTF-8">
   <meta http-equiv="X-UA-Compatible" content="IE=edge">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>WMS | Meetings</title>

  <!-- LINKS -->
    <!-- Custom Styles -->
    <link rel="stylesheet" href="<?php echo BASE_URL . '/assets/css/other-style.css?v='. time(); ?>">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-gH2yIJqKdNHPEq0n4Mqa/HGKIhSkIHeL5AyhkYV8i59U5AR6csBvApHHNl/vI1Bx" crossorigin="anonymous">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.9.1/font/bootstrap-icons.css">

    <!-- scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- END LINKS -->

</head>
<body>


<?php include(ROOT_PATH . "/app/includes/header.php"); ?>
<?php include(ROOT_PATH . "/app/includes/sidebar.php") ?>
        
<!-- STAR MAIN -->
  <div class="main"> 

  <div class="page-header mx-auto">
    <p class="page_title" style="float: left; padding-top: 2px;">Meetings</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Meetings</li>
    </ul>
  </div>


  <!-- START ADD COMPANY (LEFT SIDE) -->
    <div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -80px; height: unset !important;">
    <form action="" method="post">
    <div class="section-header pt-2">
      <span class="text-muted pt-4" style="width: 95%;">Meeting Entry</span>
    </div>
    <hr style="margin-bottom: -5px; margin-top: 5px;">
    <?php 
    $id = $_SESSION['employee_idno'];
    $sql = "SELECT * FROM employee WHERE idno = '$id' ";
    $all = mysqli_query($conn, $sql);
      if($all) {
        while ($row = mysqli_fetch_assoc($all)) {
    $fname = $row['fname'];
    $lname = $row['lname']; 
    $employeeID = $row['idno']?>
    <?php }} ?>
    <?php 
    $id = $_SESSION['employee_idno'];
    $sql = "SELECT * FROM job WHERE employee_idno = '$id' AND status = 'active' ";
    $all = mysqli_query($conn, $sql);
      if($all) {
        while ($row = mysqli_fetch_assoc($all)) {
    $jobtitle = $row['jobtitle'];
    $deptname = $row['deptname']; 
    $companyname = $row['companyname']?>
    <?php }} ?>
      <input class="form-control" id="employee_fname" type="hidden" name="employee_fname" value="<?php echo $fname; ?>">
      <input class="form-control" id="employee_lname" type="hidden" name="employee_lname" value="<?php echo $lname; ?>">
      <input class="form-control" id="employee_idno" type="hidden" name="employee_idno" value="<?php echo $employeeID; ?>">
      <input class="form-control" id="jobtitle" type="hidden" name="jobtitle" value="<?php echo $jobtitle; ?>">
      <input class="form-control" id="deptname" type="hidden" name="deptname" value="<?php echo $deptname; ?>">
      <input class="form-control" id="companyname" type="hidden" name="companyname" value="<?php echo $companyname; ?>">
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="title" style="font-size: 14px;">Title <span class="text-muted" style="font-size: 10px;">e.g. "Complete Assignment"</span></label>
      <input class="form-control" id="title" type="text" name="title" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="details" style="font-size: 14px;">Details <span class="text-muted" style="font-size: 10px;">What is needing to be done?</span></label>
      <textarea class="form-control" id="details" type="text" name="details" value="" required></textarea>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="location" style="font-size: 14px;">Location <span class="text-muted" style="font-size: 10px;">e.g. "Online"</span></label>
      <input class="form-control" id="location" type="text" name="location" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="link" style="font-size: 14px;">Link <span class="text-muted" style="font-size: 10px;">If online meeting, include meeting link</span></label>
      <input class="form-control" id="link" type="text" name="link" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="due_date" style="font-size: 14px;">Date</label>
      <input class="form-control" id="due_date" type="date" name="due_date" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto d-grid d-md-flex justify-content-md-end" style="width: 95%; margin-bottom: 10px;">
      <button type="submit" style="border-color: rgba(0,0,0,0);" name="add-task" class="badge text-bg-secondary">Add Task</button>
    </div>
    </form>
    </div>
  <!-- END ADD JOB (LEFT SIDE) -->

  <!-- START JOB-REQUEST (RIGHT SIDE) -->
    <div class="page-content mt-2 float-end" style="width: 65%; margin-right: 10px;">
    <table class="table">
    <thead>
      <tr>
        <th scope="col" style="font-size: 14px;">ID #</th>
        <th scope="col" style="font-size: 14px;">Title</th>
        <th scope="col" style="font-size: 14px;">Status</th>
        <th scope="col" style="font-size: 14px;">Actions</th>
      </tr>
    </thead>
    <tbody class="table-group-divider">

    <?php
        $sql = "SELECT * FROM task";
        $all = mysqli_query($conn, $sql);
        if($all) {
            while ($row = mysqli_fetch_assoc($all)) {
              $id    = $row['taskID'];
              $idno      = $row['idno'];
              $title     = $row['title'];
              $details   = $row['details'];
              $due_date  = $row['due_date'];
              $category  = $row['category'];
              $status    = $row['status'];
    ?>
      <tr>
          <th scope="row"><?php echo $idno; ?></th>
          <td><?php echo $title; ?></td>
          <?php if($status == 'done'){ ?>
          <td><span class="text-capitalize text-success">Completed<span></td>
          <?php } if($status == 'inprogress') { ?>
            <td><span class="text-capitalize text-primary">In Progress<span></td>
          <?php } if($status == 'notstarted') { ?>
            <td><span class="text-capitalize text-danger">Not Started<span></td>
          <?php }?>
          <td>
            <div class="d-flex">
                <button style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" id="<?php echo $row['taskID']; ?>" class="btn btn-primary"><span class="badge text-bg-success">View</span></button> &nbsp;
                <form method="post" action="">
                  <input type="hidden" name="taskID" value="<?php echo $taskID; ?>" />
                  <button onclick="return confirm('Be Careful, Can\'t be undone! \r\nOK to delete?')" style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="terminated"><span class="badge text-bg-danger">Delete</span></button>
                </form>
            </div>
          </td>
          <?php } ?>
          
          
        </tbody>
        </table> 
        <?php 
        } else {
          echo "0 results";
        }
          ?>
      </div>
  <!-- END JOB-REQUEST (RIGHT SIDE) -->

  </div> 
<!-- END MAIN -->


<!-- MODAL -->
    <div class="modal fade" id="myModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Task View</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            ...
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <!-- <button type="button" class="btn btn-primary">Save changes</button> -->
          </div>
        </div>
      </div>
    </div>
<!-- END MODAL -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>

<!-- SCRIPTS -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        $(document).ready(function(){
    $('button').click(function(){
        id_task = $(this).attr('id')
        $.ajax({url: "select/meeting_select.php",
        method:'post',
        data:{task_id:id_task},
         success: function(result){
    $(".modal-body").html(result);
    }});


            $('#myModal').modal("show");
        })
    })
    </script>
<!-- END SCRIPTS -->

</body>
</html>