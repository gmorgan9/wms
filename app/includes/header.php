<!-- WORKING -->

<?php
$empID = $_SESSION['empID'];
$select = " SELECT * FROM employee WHERE employeeID = '$empID' ";
$result = mysqli_query($conn, $select);
if (mysqli_num_rows($result) > 0) {
   while($row = mysqli_fetch_assoc($result)) {
    $fname = $row['fname'];
}}
?>



<!--Main Navigation-->
<header>
<!-- Navbar -->
    <?php if(isset($_SESSION['fname'])){ ?>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
    <?php } else { ?>
        <nav id="main-navbar" class="navbar navbar-expand-lg navbar-dark fixed-top">
    <?php }?>
      <!-- Container wrapper -->
    <div class="container-fluid">

<!-- Brand -->
        <a class="navbar-brand" href="/">
            <h3><i class="bi bi-clock"></i> Workforce Management System</h3>
        </a>

        <ul class="navbar-nav ms-auto d-flex flex-row">
            <?php if(isset($_SESSION['fname'])){ ?>
            <?php if($row['acc_type'] == 1){ ?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0">Welcome, <span style="text-transform: capitalize;"><?php echo $fname; ?></span>!</a></li>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/admin/profile.php' ?>"><i class="bi bi-person"></i>  Profile</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0">Welcome, <span style="text-transform: capitalize;"><?php echo $fname; ?></span>!</a></li>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/pages/profile.php' ?>"><i class="bi bi-person"></i>  Profile</a></li>
            <?php }?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/logout.php' ?>">Logout</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/pages/entry/login.php' ?>">Login/Signup</a></li>
            <?php } ?>
        </ul>
    </div>
<!-- Container wrapper -->
</nav>
<!-- Navbar -->
</header>
<!--End Main Navigation-->
<!--Main layout-->
<!-- <main style="margin-top: 58px;">
  <div class="container pt-4"></div>
</main> -->
<!--Main layout-->
<?php  ?>