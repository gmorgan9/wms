<!-- WORKING -->
<footer class="fixed-bottom py-3">
<?php if(isset($_SESSION['']) || isset($_SESSION['admin_fname'])){ ?>
    <div class="text-center text-muted" style="background-color: white;">
<?php } else { ?>
    <div class="text-center text-muted" style="background-color: rgba(0, 0, 0, 0.05);">
<?php }?>
        &copy; 2022 Employee Timesheet System
    </div>
</footer>