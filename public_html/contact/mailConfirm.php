<?php require '../basic/header.php'; ?>
<?
session_start();
$errors=array();
// HTML特殊文字をエスケープする関数
function escape($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

//前後にある半角全角スペースを削除する関数
function spaceTrim ($str) {
    // 行頭
    $str = preg_replace('/^[ 　]+/u', '', $str);
    // 末尾
    $str = preg_replace('/[ 　]+$/u', '', $str);
    return $str;
}

$_SESSION['contact']['send']=1;

//tokenを変数に入れる
$token = $_POST['token'];

// トークンを確認し、確認画面を表示
if(!(hash_equals($token, $_SESSION['contact']['token']) && !empty($token))) {
    echo "不正アクセスの可能性があります";
    exit();
}
// print_r($_POST);

//POSTされたデータを各変数に入れる
$name = isset($_POST['name']) ? $_POST['name'] : NULL;
$mail = isset($_POST['adress_mail']) ? $_POST['adress_mail'] : NULL;
$comment = isset($_POST['comment']) ? $_POST['comment'] : NULL;

//前後にある半角全角スペースを削除
$name = spaceTrim($name);
$mail = spaceTrim($mail);
$comment = spaceTrim($comment);

//名前入力判定
if ($name == ''){
    $errors['name'] = "名前が入力されていません。";
}

//メール入力判定
if ($mail == ''){
    $errors['mail'] = "メールが入力されていません。";
}

//コメント入力判定
if ($comment == ''){
    $errors['comment'] = "コメントが入力されていません。";
}


//エラーが無ければセッションに登録
if(count($errors) === 0){
    $_SESSION['contact']['name'] = $name;
    $_SESSION['contact']['mail'] = $mail;
    $_SESSION['contact']['comment'] = $comment;
}


// print_r(is_null($errors));
// print_r($_SESSION);
?>

<container class="content">
   
<div class="headline">
    <p id="date">お問い合わせフォーム</p><br>
        バグや要望はこちらからよろしくお願いします。<br>
<form  method="post" action="mailSend.php">
            <table class="form">
                <tr>
                    <th>お名前</th>
                    <td><?php echo escape($name); ?></td>
                </tr>
                <tr>
                    <th>メールアドレス</th>
                    <td><?php echo escape($mail); ?></td>
                </tr>
                <tr>
                    <th>お問い合わせ内容</th>
                    <td><?php echo nl2br(escape($comment)); ?></td>
                </tr>
            </table>
            <input type="button" class="myButton" value="戻る" onClick="history.back()">
            <input type="hidden" name="token" value= <?php echo escape($token); ?>>
            <button type="submit" class="myButton">送信</button>
</form>
</container>
<?php require '../basic/footer.php'; ?>