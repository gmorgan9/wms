<!-- WORKING -->
<footer class="fixed-bottom py-3">
<?php if(!isset($_SESSION['user_fname']) || !isset($_SESSION['admin_fname'])){ ?>
    <div class="text-center text-muted" style="background-color: rgba(0, 0, 0, 0.05);">
<?php } else { ?>
    <div class="text-center text-muted" style="background-color: white;">
<?php }?>
        &copy; 2022 Employee Timesheet System
    </div>
</footer>