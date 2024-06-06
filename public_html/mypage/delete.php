<?php require '../basic/header.php'; ?>

<?php
session_start();
$_SESSION['all_items'] = array_splice($_SESSION['all_items'], $_GET['delete'],1);
// unset($_SESSION['all_items'][$_GET['delete']]);
// $_SESSION['all_items']=array_values($_SESSION['all_items']);
header('Location: trade.php');
?>
<container class="content">

</container>
<?php require '../basic/footer.php'; ?>