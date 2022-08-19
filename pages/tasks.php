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
  if(isset($_POST['add-task'])){
    $taskID = mysqli_real_escape_string($conn, $_POST['taskID']);
    $idno  = rand(1000000, 9999999); // figure how to not allow duplicates
    $title = mysqli_real_escape_string($conn, $_POST['title']);
    $details = mysqli_real_escape_string($conn, $_POST['details']);
    $due_date = mysqli_real_escape_string($conn, $_POST['due_date']);
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $employee_fname = mysqli_real_escape_string($conn, $_POST['employee_fname']);
    $employee_lname = mysqli_real_escape_string($conn, $_POST['employee_lname']);
    $employee_idno = mysqli_real_escape_string($conn, $_POST['employee_idno']);

    $select = " SELECT * FROM task WHERE title = '$title' ";
    $result = mysqli_query($conn, $select);

    if(mysqli_num_rows($result) > 0){
      $error[] = 'Task already exist!';
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
   <title>WMS | Tasks</title>

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
    <p class="page_title" style="float: left; padding-top: 2px;">Tasks</p>
    <ul class="breadcrumb">
      <li><a href="<?php echo BASE_URL . '/pages/dashboard.php' ?>">Dashboard</a></li>
      <li>Tasks</li>
    </ul>
  </div>


  <!-- START ADD COMPANY (LEFT SIDE) -->
    <div class="page-content float-start" style="margin-top: 12px; width: 32%;margin-left: -52px; height: unset !important;">
    <form action="" method="post">
    <div class="section-header pt-2">
      <span class="text-muted pt-4" style="width: 95%;">Tasks Entry</span>
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
      <input class="form-control" id="employee_fname" type="hidden" name="employee_fname" value="<?php echo $fname; ?>">
      <input class="form-control" id="employee_lname" type="hidden" name="employee_lname" value="<?php echo $lname; ?>">
      <input class="form-control" id="employee_idno" type="hidden" name="employee_idno" value="<?php echo $employeeID; ?>">
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="title" style="font-size: 14px;">Title <span class="text-muted" style="font-size: 10px;">e.g. "Complete Assignment"</span></label>
      <input class="form-control" id="title" type="text" name="title" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="details" style="font-size: 14px;">Details <span class="text-muted" style="font-size: 10px;">What is needing to be done?</span></label>
      <textarea class="form-control" id="details" type="text" name="details" value="" required></textarea>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="category" style="font-size: 14px;">Category <span class="text-muted" style="font-size: 10px;">e.g. "School"</span></label>
      <input class="form-control" id="category" type="text" name="category" value="" required>
    </div>
    <div class="form-group pt-3 mx-auto" style="width: 95%;">
      <label for="due_date" style="font-size: 14px;">Due Date</label>
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
              $taskID    = $row['taskID'];
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
          <?php if($status == 'approved'){ ?>
          <td><span class="text-capitalize text-success"><?php echo $status; ?><span></td>
          <?php } if($status == 'rejected') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $status; ?><span></td>
          <?php } if($status == 'pending') { ?>
            <td><span class="text-capitalize text-primary"><?php echo $status; ?><span></td>
          <?php } if($status == 'terminated') { ?>
            <td><span class="text-capitalize text-danger"><?php echo $status; ?><span></td>
          <?php }?>
          <!-- <td><?php //echo $companyname; ?></td> -->
          <td>
          <button type="button" class="editbtn" data-bs-toggle="modal" data-bs-target="#editmodal">Launch modal</button>
          <!-- <button  style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit"><span class="badge text-bg-success editbtn">Edit</span></button> -->
            <form method="post" action="">
              <input type="hidden" name="jobID" value="<?php echo $jobID; ?>" />
              
              <button onclick="return confirm('Be Careful, Can\'t be undone! \r\nOK to delete?')" style="background: none; color: inherit; border: none; padding: 0; font: inherit; cursor: pointer; outline: inherit;" type="submit" name="terminated"><span class="badge text-bg-danger">Delete</span></button>
            </form>
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
    <!-- EDIT POP UP FORM (Bootstrap MODAL) -->
    <div class="modal fade" id="editmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel"> Edit Student Data </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <form action="" method="POST">

                    <div class="modal-body">

                        <input type="hidden" name="idno" id="idno">

                        <div class="form-group">
                            <label> Title </label>
                            <input type="text" name="title" id="title" class="form-control"
                                placeholder="Enter First Name">
                        </div>

                        <div class="form-group">
                            <label> Last Name </label>
                            <input type="text" name="lname" id="lname" class="form-control"
                                placeholder="Enter Last Name">
                        </div>

                        <div class="form-group">
                            <label> Course </label>
                            <input type="text" name="course" id="course" class="form-control"
                                placeholder="Enter Course">
                        </div>

                        <div class="form-group">
                            <label> Phone Number </label>
                            <input type="text" name="contact" id="contact" class="form-control"
                                placeholder="Enter Phone Number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" name="updatedata" class="btn btn-primary">Update Data</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
<!-- END MODAL -->

<?php include(ROOT_PATH . "/app/includes/footer.php"); ?>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.18/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.18/js/dataTables.bootstrap4.min.js"></script>





<script>
    $( document ).ready(function() {

        $('.editbtn').on('click', function () {
            $('#editmodal').modal('show');
            $tr = $(this).closest('tr');
            var data = $tr.children("td").map(function () {
                return $(this).text();
            }).get();

            console.log(data);

            $('#idno').val(data[0]);
            $('#title').val(data[1]);
            //$('#title').val(data[2]);
            //$('#course').val(data[3]);
            //$('#contact').val(data[4]);
        });
    });
</script>

</body>
</html>