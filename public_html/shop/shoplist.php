<?php require '../basic/header.php'; 
session_start();
$dsn = sprintf("mysql:host=%s;dbname=%s",'127.0.0.1' ,'xs014145_chahodb');
// PDOインスタンス化
$pdo = new PDO($dsn, 'xs014145_admin', 'cogoodbadmin');

// SQL文組み立て
$sql = "SELECT * FROM `shop`";

// SQL ステートメントを準備
$stmt = $pdo->prepare($sql);

// クエリ実行
$stmt->execute();

// 結果データ取得
$shoplist = $stmt->fetchAll(PDO::FETCH_ASSOC);

$_SESSION['shop'] = $shoplist;

?>
<container class="content">
<div class="mv">
    <h1>
        <?php
        echo '商品ラインナップ'
        ?>
    </h1>
    <div>
        商品ラインナップです。
    </div>
    <div class="itemlist">

        <ul>
            <?php for($i=0;$i<=count($_SESSION['shop'])-1;$i++){?>
            <li>
                <img src=<?php print_r($_SESSION['shop'][$i]['image'])?>>
                <div class="item-body">
                    <h5>
                        <?php print_r($_SESSION['shop'][$i]['item_name']);?>
                    <h5>
                    <p><?php print_r($_SESSION['shop'][$i]['cost']."p");?></p>
                    <a href="<?php print_r($_SESSION['shop'][$i]['url'])?>" class="myButton">amazonで詳細を確認</a>
                    <div>
                        <form action ="../mypage/trade.php" method = "POST">
                        <button type ="submit" name="cart" class="myButton" value="<?php print_r($_SESSION['shop'][$i]['item_id'])?>">商品を追加</button>
                        </form>
                    </div>
                    <!-- <a href="add_cart.php" class="myButton"></a> -->
                <div><!-- end item-body -->
            </li>
            <?php }?>
        </ul>
    </div><!--end itemlist-->
</div><!--end mv-->

</container>

<!-- ローディング画面 -->
<div id="loading">
<!-- FontAwsomeをローディング画像に使う fa-spinを付与して回転させる-->
<img src="../images/loading2.gif" alt="">
<div><a id=sentence>Loading</a></div>
</div><!-- /#loading -->
  
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
 <script src="../js/main.js"></script>
<?php require '../basic/footer.php'; ?>