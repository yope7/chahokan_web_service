<!-- FOR SERVER -->

<?php 
session_start();
require '../basic/header.php';
error_reporting(0);
// トークン生成
if (!isset($_SESSION['contact']['token'])) {
    $_SESSION['contact']['token'] = sha1(random_bytes(30));
}
// HTML特殊文字をエスケープする関数
function escape($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}
?>

<container class="content">
<div class="headline">
    <p id="date">お問い合わせフォーム</p><br>
        バグや要望はこちらからよろしくお願いします。<br>
        <div class="comment">
            <form action="mailConfirm.php" method="POST">
                <div class="wrapper">
                    <div class="title">お名前<span>*</span></div>
                    <div class="insert">
                        <input type="text" name="name" placeholder="全角20文字以内" required>
                    </div>
                </div>

                <div class="wrapper">
                    <div class="title">メールアドレス<span>*</span></div>
                    <div class="insert">
                        <input id="contact_mail" name="adress_mail" type="text" placeholder="メールアドレス(半角30文字以内)" required>
                    </div>
                </div>

                <div class="wrapper">
                    <div class="title">お問い合わせ内容<span>*</span></div>
                    <div class="insert">
                        <textarea name="comment" placeholder="全角200文字以内" required></textarea>
                    </div>
                </div>
                <input type="hidden" name="token" value="<?=$_SESSION['contact']['token']?>">
                <div class="submit">
                    <input type="submit" class="myButton" value="送信">
                </div>
            </form>
        </div>
</div>


</container>
<?php require '../basic/footer.php'; ?>