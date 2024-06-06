<?php require '../basic/header.php'; ?>
<?php
session_start();
unset($_SESSION['shop']);

    // ログインチェック
    if(!isset($_SESSION['login']['loggedin'])){
        header('Location: ../main/index.php');
    }


//ポイントを更新する
    include_once '../db/dbconnect.php';

    // SQL文組み立て
    $sql = "SELECT * FROM `subscribe` WHERE name = :named";

    // SQL ステートメントを準備
    $stmt = $pdo->prepare($sql);

    $name = $_SESSION['login']['all'][0]['name'];

    // パラメータをバインド
    $stmt->bindParam(':named', $_SESSION['login']['name'], PDO::PARAM_STR);

    // クエリ実行
    $stmt->execute();

    // 結果データ取得
    $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

    $_SESSION['login']['all'] = $all;

    $sql = "SELECT * FROM `shop` WHERE item_id = :item_id";

    // SQL ステートメントを準備
    $stmt = $pdo->prepare($sql);

    if($_POST['cart'] != "null"){

        // print_r($_POST['cart']);

        $item_id = $_POST['cart']; 

        // パラメータをバインド
        $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

        // クエリ実行
        $stmt->execute();

        // 結果データ取得
        $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $_SESSION['my']['all_items']=$item;
    }
    else{
        print_r('reloaded');
    }
?>
<?php

// echo($_SESSION['all'][0]['ID']);

if(!$_SESSION['login']['loggedin']){
    header('Location: ../main/index.php');
    exit();
}

if($_SESSION['login']['all'][0]['is_admin']==1){
    header('Location: ../mypage/admin.php');
    exit();
}
?>

<container class="content">
<div>
    <?php
    echo"こんにちは、{$_SESSION['login']['name']}さん！";
    ?>
</div>

<div class="big">
    <?php
    if(isset($_SESSION['buy'])){
        echo("交換完了！");
        unset($_SESSION['buy']);
        unset($_SESSION['my']['all_items']);
    }
    ?>
</div>

<div class="headline">
    <?php
            print_r('あなたの保有ポイント:'.$_SESSION['login']['all'][0]['point']);
            if($_SESSION['loss'] == 1){
                printf('<br>');
                print_r("ポイントが不足しています。");
                $_SESSION['loss']=0;
            }
        ?>
        <div class="alert">ポイントが反映されない場合、しばらく待ってからサイトの更新をお願いします。</div>
</div>
<div>
<a href="tweet.php" class="myButton">1日1回 ツイートしてポイントゲット！<br>(Twitterが開きます。)</a>
</div>

<div>
<a href="reset.php" class="myButton">ポイント交換はこちらから</a>
</div>
<?php if(isset($_SESSION['login']['loggedin'])):?>
<div><a href="logout.php" class="myButton">ログアウト</a></div>
<?php endif;?>
</container>
<?php require '../basic/footer.php'; ?>