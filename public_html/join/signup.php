<?php require '../basic/header.php'; ?>

<?php
require '../db/dbconnect.php';
session_start();
unset($_SESSION['ok']);

if (!isset($_SESSION['subscribe']['token_sub'])) {
    $_SESSION['subscribe']['token_sub'] = sha1(random_bytes(30));
}

if(empty($_GET)){
	header("Location: registration_mail");
	exit();
}else{
    $urltoken = isset($_GET["urltoken"]) ? $_GET["urltoken"] : NULL;
    if ($urltoken == ''){
		$errors['urltoken'] = "トークンがありません。";
        // echo("dame1");
	}else{
        // echo($urltoken);
        $sql = "SELECT pre_email FROM pre_user WHERE pre_token=:my_token AND pre_flag ='0' AND pre_date > now() - interval 24 hour";
        $stm = $pdo->prepare($sql);
        $stm->bindValue(':my_token', $urltoken, PDO::PARAM_STR);
        $stm->execute();

        $all_signup = $stm->fetchAll(PDO::FETCH_ASSOC);
        $row_count = $stm->rowCount();
			
        //24時間以内に仮登録され、本登録されていないトークンの場合
        if($row_count ==1){

            
            $email_array = $stm->fetch();
            $email = $mail_array["pre_email"];
            $_SESSION['subscribe']['verify']='1';
        }else{
            // echo("dame");
            $errors['urltoken_timeover'] = "このURLはご利用できません。有効期限が過ぎたかURLが間違えている可能性がございます。もう一度登録をやりなおして下さい。";
        }
    }
}
?>
<container class="content">
    <h1>
		会員登録
    </h1>
    <?php if($_SESSION['subscribe']['verify']=='1'){?>
            <p>ログインに必要な情報の入力をしてください。</p>
            <form action="check.php" method="post" enctype="multipart/form-data">
            <dt>名前<span class="required">必須</span></dt>
            <dd><input type="text" name="name" size="35" maxlength="255" />
            <?php 
            if ($error['name'] == 'blank'): ?>
            <p class ="error">* 名前を入力してください</p>
            <?php endif; ?>
            <?php if ($error['name'] == 'duplicate'): ?>
                    <p class="error">* 指定された名前はすでに登録されています</p>
            <?php endif; ?>
            </dd>

            <dt>ニックネーム<span class="required">必須</span></dt>
            <dd><input type="text" name="pen_name" size="35" maxlength="255" />
            <?php 
            if ($error['pen_name'] == 'blank'): ?>
            <p class ="error">* ニックネームを入力してください</p>
            <?php endif; ?>
            <?php if ($error['pen_name'] == 'duplicate'): ?>
                    <p class="error">* 指定されたニックネームはすでに登録されています</p>
            <?php endif; ?>
            </dd>

            <dt>パスワード<span class="required">必須</span></dt>
            <dd><input type="text" name="password" size="35" maxlength="255" />
            <?php 
            if ($error['password'] == 'blank'): ?>
            <p class ="error">* パスワードを入力してください</p>
            <?php endif; ?>
            </dd>
            <div><input type="submit" class="myButton" value="確認"/></div>
            <input type="hidden" name="token_sub" value="<?=$_SESSION['subscribe']['token_sub']?>">
            <input type="hidden" name="signup" value="1">
            </form>

        <?php }else{?>
            <p> 認証に失敗しました</p>
            <?php }?>
    
</container>

<?php require '../basic/footer.php'; ?>