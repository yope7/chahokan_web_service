<?php require '../basic/header.php'; ?>

<?php
require '../db/dbconnect.php';
session_start();
// $_SESSION = array();
// トークン生成
$_SESSION['token'] = sha1(random_bytes(30));

if(!empty($_POST)){
    if($_POST['name']==''){
        $error['name']='blank';
    }
    if($_POST['pen_name']==''){
        $error['pen_name']='blank';
    }
    if($_POST['email']==''){
        $error['email']='blank';
    }
    if($_POST['password']==''){
        $error['password']='blank';
    }
    }

	// 重複アカウントのチェック
	// if (empty($error)) {
    //     // 
	// 	$member = $db->prepare('SELECT COUNT(*) AS cnt FROM members WHERE name="%s"',
	//     mysqli_real_escape_string($db, $_POST['name']));
	// 	$record = mysqli_query($db, $sql) or die(mysqi_error($db));
	// 	$table = mysqli_fetch_assoc($record);
	// 	if ($table['cnt'] > 0) {
	// 		$error['name'] = 'duplicate';
	// 	}
	// }
?>

<container class="content">
    <h1>
		会員登録
    </h1>
    <p>ログインに必要な情報の入力をしてください。</p>
    <form action="checkMail.php" method="post" enctype="multipart/form-data">
    
        <dl>

            <dt>メールアドレス<span class="required">必須</span></dt>
            <dd><input type="text" name="email" size="35" maxlength="255" />
            <?php 
            if ($error['email'] == 'blank'): ?>
            <p class ="error">* メールアドレスを</p>
            <?php endif; ?>
            <?php if ($error['email'] == 'duplicate'): ?>
                    <p class="error">* 指定されたメールアドレスはすでに登録されています</p>
            <?php endif; ?>
            </dd>
        </dl>
        <input type="hidden" name="token" value="<?=$_SESSION['token']?>">
        <input type="hidden" name="flag" value="1">
        <div><input type="submit" class="myButton" value="確認"/></div>
    </form>
</container>

<?php require '../basic/footer.php'; ?>