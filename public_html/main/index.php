<!-- FOR SERVER -->

<?php 
session_start();
require '../basic/header.php';

?>
<container class="content">
    <div>
        <?php 
        if($_SESSION['login']['name']!=NULL){
            echo htmlspecialchars("こんにちは、{$_SESSION['login']['name']}さん！");
        }
        else{
            echo"未ログイン状態です。";
        }
        ?>
        <br>
    </div>
        <nav id="menubar">
            <ul>
                <li><a href="../aboutme/index.php">当サイトの説明</a></li>
                <li><a href="../new/index.php">最新情報</a></li>
                <li><a href="../shop/shoplist.php">商品ラインナップ</a></li>
                <li><a href="../join/login.php">マイページ</a></li>
                <li><a href="../join/index.php">会員登録はこちらから</a></li>
                <li><a href="../contact/index.php">お問い合わせ</a></li>
            </ul>
        </nav>
        <?php if(isset($_SESSION['login']['loggedin'])):?>
    <div><a href="../mypage/logout.php" class="myButton" id="buttonmain">ログアウト</a></div>
    <?php else:?>
    <div><a href="../join/login.php" class="myButton" id="buttonmain">ログイン</a></div>  
<?php endif;?>
</container>
<?php require '../basic/footer.php'; ?>