<?php require '../basic/header.php'; 
session_start();
unset($_SESSION['login']);
unset($_SESSION['subscribe']);


?>
<body>
<container class="content">
<p> 登録完了！</p>
<p><a href="../join/login.php" class="myButton">ログインはこちら</a></p>
<p><a href="../main/index.php" class="myButton">メインへ</a></p>
</container>
</body>
<?php require '../basic/footer.php'; ?>

<?php //unset($_SESSION['csrfToken']); ?>
  

