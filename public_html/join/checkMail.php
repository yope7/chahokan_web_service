<?php require '../basic/header.php'; ?>

<?php
session_start();
include '../db/dbconnect.php';

$error="";
unset($_SESSION['error']['dup']);

if(!isset($_POST['email']) and !isset($_POST['ok'])){
    header('Location: index.php');
    exit();
}
function escape($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

//tokenを変数に入れる
$token = $_POST['token'];
$email = $_POST['email'];
$_SESSION['subscribe']['email'] = $email;


// トークンを確認し、確認画面を表示
if(!(hash_equals($token, $_SESSION['token']) && !empty($token))) {
    echo "不正アクセスの可能性があります";
    exit();
}

$sql1 = "SELECT * FROM `subscribe` WHERE email=:my_email";

$stmt = $pdo->prepare($sql1);

$stmt->bindParam(':my_email', $email, PDO::PARAM_STR);

$stmt->execute();

$all_signup = $stmt->fetchAll(PDO::FETCH_ASSOC);
$is_duplicate = $stmt->rowCount();

if($is_duplicate !=0){
    $_SESSION['error']['dup'] = 1;
}else{
    $_SESSION['error']['dup'] = 0;
}


if($_SESSION['error']['dup'] != 1){
$sql1 = "INSERT INTO pre_user SET pre_token=:my_token, pre_email=:my_email, pre_date=now(),pre_flag=:my_flag";
$stmt = $pdo->prepare($sql1);

$pre_token = $_SESSION['token'];
$flag = 0;
    
$stmt->bindParam(':my_token', $pre_token, PDO::PARAM_STR);
$stmt->bindParam(':my_email', $email, PDO::PARAM_STR);
$stmt->bindParam(':my_flag', $flag, PDO::PARAM_INT);
$stmt->execute();

// $stmt->debugDumpParams();
$stmt = "NULL";
$message = "メールをお送りしました。24時間以内にメールに記載されたURLからご登録下さい。";  


    $url = 'https://chahokan.com/join/signup.php?urltoken='.$pre_token;

    $mailto = $_SESSION['subscribe']['email']; // 宛先のメールアドレス
    $subject = "仮登録";
    $content = 
    "チャホカン 仮登録メール\n

    チャホカンサービスをご利用いただきありがとうございます。\n
url：".htmlspecialchars($url, ENT_QUOTES, 'UTF-8');
    $mailfrom = "From:non-reply@chahokan.com"; // From:送信元のメールアドレス

    // mb_language("ja");
    mb_internal_encoding("UTF-8");

    // メール送信処理
    $result = mb_send_mail($mailto,$subject,$content,$mailfrom);

    // print_r($_SESSION);
    // メール送信処理結果出力
    if($result){
        $message_result="仮登録用メールを送信いたしました。メールのurlよりご登録よろしくお願いします。";
        $_SESSION['flag']['result']=1;
    }else{
        echo "送信失敗";
    }

    // header('Location: thanks.php');
    // exit();
}else{
    $error="このメールアドレスは使用されています。やり直してください。";
}
?>
<container class="content"> 
<?php if($_SESSION['flag']['result']==1){?>
<p><?php print_r($message_result);?></p>
<?php }else{?>
    <div><p> <?php print_r($error)?></p>
    <div><a href="index.php" class="myButton">やり直す</a>
    <?php }?>
</container>
<?php require '../basic/footer.php'; ?>