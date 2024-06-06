<?php require '../basic/header.php'; ?>
<?php
session_start();

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

//tokenを変数に入れる
$token = $_POST['token'];

// トークンを確認し、確認画面を表示
if(!(hash_equals($token, $_SESSION['contact']['token']) && !empty($token))) {
    echo "不正アクセスの可能性があります";
    exit();
}


// print_r($_SESSION);
?>

<container class="content">
<h1>
    お問い合わせフォーム
</h1>
<p>
    
<?php
            $email = 'contact.chahokan@gmail.com';

            mb_language('japanese');
            mb_internal_encoding('UTF-8');

            $from = $_SESSION['contact']['mail'];
            $mail = $_SESSION['contact']['mail'];
            $name = $_SESSION['contact']['name'];
            $comment = $_SESSION['contact']['comment'];

            $subject = 'お問い合わせがあったよ！';
            $body = $comment. "\n". $name. "\n". $mail;
            if(isset($_SESSION['contact']['send'])){
                $success = mb_send_mail($email, $subject, $body, 'From: '.$from);
                unset($_SESSION['contact']['send']);
            }
        ?>

        <div id="tyMessage">
        <?php if ($success) : ?>
        ご意見ありがとうございます！
        <?php unset($_SESSION['contact']);
            ?>
        <?php else : ?>
        申し訳ありません。エラーのため送信できませんでした。<br>
        <?php endif; ?>
        <div>
        <p><a href="../main/index.php" class="myButton">メイン画面に戻る</a></p>
        </div>
        </div>
</container>
<?php require '../basic/footer.php'; ?>