<?php require '../basic/header.php'; ?>

<?php
session_start();
unset($_SESSION['shop']);

// ログインチェック
if(!isset($_SESSION['login']['loggedin'])){
    header('Location: ../join/login.php');
}

unset($_SESSION['confirm']);


//database
include_once '../db/dbconnect.php';

// // SQL文組み立て
// $sql = "SELECT * FROM `subscribe` WHERE name = :named";

// // SQL ステートメントを準備
// $stmt = $pdo->prepare($sql);

// $name = $_SESSION['login']['all'][0]['name'];

// // パラメータをバインド
// $stmt->bindParam(':named', $_SESSION['login']['name'], PDO::PARAM_STR);

// // クエリ実行
// $stmt->execute();

// // 結果データ取得
// $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

// $_SESSION['login']['all'] = $all;

$sql = "SELECT * FROM `shop` WHERE item_id = :item_id";

// SQL ステートメントを準備
$stmt = $pdo->prepare($sql);

if(!is_null($_POST['cart'])){

    $item_id = $_POST['cart']; 

    // パラメータをバインド
    $stmt->bindParam(':item_id', $item_id, PDO::PARAM_INT);

    // クエリ実行
    $stmt->execute();

    // 結果データ取得
    $item = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // カートを複数にする場合
    // $_SESSION['all_items'][0]['item_name']=>$_SESSION['all_items'][$i][0]['item_name']
    // if(!in_array($item, $_SESSION['all_items'])){
    //     array_push($_SESSION['all_items'], $item);
    // }

    // 単一ショップカート
    $_SESSION['my']['all_items'] = $item;
}

?>
<container class="content">

<div>
    <?php
    echo"{$_SESSION['login']['name']}さんとしてログイン中";
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
<div class="headline">
    現在のカート<br>
    <?php 
    // if(count($_SESSION['all_items'])!=1){
    if($_SESSION['my']['all_items']!=array()){
    // for($i=1; $i<=count($_SESSION['all_items'])-1; $i++){
    print_r($_SESSION['my']['all_items'][0]['item_name']);?>

        <!-- 今後実装予定の削除ボタン -->
        <!-- <form action="delete.php" method="GET">
        <button type="submit" class="myButton" id="delete" name="delete" value="
        <?php
        // print_r($i+1) 
        ?>
        ">削除</button>
        </form> -->

    <?php
    } 
// }
    else{
        echo("カートに商品がありません。");
    }
    ?>
    <br>
    <?php   if(isset($_SESSION['my']['all_items'][0]['cost'])){
            print_r('交換に必要なポイント:'.$_SESSION['my']['all_items'][0]['cost'].'p');
    }
        ?>
</div>
</div>

<div>
    <?php if($_SESSION['my']['all_items']!=array()){?>
<a href="../mypage/confirm.php" class="myButton">確認する</a>
    <?php } ?>
</div>

<?php if(isset($_SESSION['my']['all_items'][0]['item_name'])):?>
    <div><a href="../shop/shoplist.php" class="myButton" id="buttonmain">商品を選びなおす</a></div>
    <?php else:?>
    <div><a href="../shop/shoplist.php" class="myButton" id="buttonmain">商品を選ぶ</a></div>  
<?php endif;?>

<div>
<a href="../mypage/reset.php" class="myButton">カートをリセットする</a>
</div>

</container>
<?php require '../basic/footer.php'; ?>