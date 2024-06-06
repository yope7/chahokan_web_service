<?php require '../basic/header.php'; ?>

<?php
session_start();
unset($_SESSION['my']['all_items']);
header('Location: trade.php');
?>
<container class="content">

</container>
<?php require '../basic/footer.php'; ?>