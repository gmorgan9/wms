<!-- WORKING -->
<?php if(isset($_SESSION['fname'])){ ?>
    <footer class="fixed-bottom py-3" style="background-color: white">
        <div class="text-center text-muted" style="background-color: white;">
<?php } else { ?>
    <footer class="fixed-bottom py-3" style="background-color: #17181C;">
        <div class="text-center text-muted" style="background-color: rgba(0, 0, 0, 0.05);">
<?php }?>
        &copy; 2022 Workforce Management System
    </div>
</footer>