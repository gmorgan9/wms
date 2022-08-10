<!-- WORKING -->
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
            <?php if($_SESSION['acc_type'] == 1){ ?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0">Welcome, <span style="text-transform: capitalize;"><?php echo $_SESSION['fname']; ?></span>!</a></li>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/pages/profile.php' ?>"><i class="bi bi-person"></i>  Profile</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0">Welcome, <span style="text-transform: capitalize;"><?php echo $_SESSION['fname']; ?></span>!</a></li>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/pages/profile.php' ?>"><i class="bi bi-person"></i>  Profile</a></li>
            <?php }?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="<?php echo BASE_URL . '/logout.php' ?>">Logout</a></li>
            <?php } else { ?>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="/">Home</a></li>
                <li class="nav-item"><a class="nav-link me-3 me-lg-0" href="pages/entry/login.php">Login/Signup</a></li>
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