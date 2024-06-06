<?php require '../basic/header.php'; ?>
<?php
session_start();

// セッション情報を削除
$_SESSION = array();
session_destroy();
// sleep(1);
header('Location: ../main/index.php'); exit();
?>
<container>

</container>
<?php require '../basic/footer.php'; ?>