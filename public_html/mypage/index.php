<?php require '../basic/header.php'; ?>
<?php session_start();
echo $_SESSION['login']['loggedin'];
if($_SESSION['login']['loggedin']!='1'){
// $test_alert = "<script type='text/javascript'>alert('こら');</script>";
// echo $test_alert;
    header('Location: ../main/index.php');
}
?>
<container>
<? header('Location: mypage.php');?>


<div ><a href="logout.php">ログアウト</a></div>
    <form action="" method="post">
</container>
<?php require '../basic/footer.php'; ?>