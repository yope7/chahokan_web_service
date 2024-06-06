<!-- FOR SERVER -->

<?php 
session_start();
require '../basic/header.php';
error_reporting(0);

// $db = mysqli_connect('127.0.0.1', 'xs014145_admin', 'cogoodbadmin', 'xs014145_chahodb') or
// die(mysqli_connect_error());
?>
<container class="content">
    <div>
    <?php
        print_r($_SESSION);
    ?>
</container>
<?php require '../basic/footer.php'; ?>