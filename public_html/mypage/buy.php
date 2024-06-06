<?php require '../basic/header.php'; ?>

<?php
session_start();
error_reporting(0);
if(!$_SESSION['confirm']){
    unset($_SESSION['confirm']);
    header('Location:../main/index.php');
    exit();
}

//ポイントを減らす
include_once '../db/dbconnect.php';

// SQL文組み立て
$sql = "UPDATE `subscribe` SET point =:my_point WHERE name = :my_name";

// SQL ステートメントを準備
$stmt = $pdo->prepare($sql);

$name = $_SESSION['login']['all'][0]['name'];

$point_after = $_SESSION['login']['all'][0]['point']-$_SESSION['my']['all_items'][0]['cost'];

// パラメータをバインド
$stmt->bindParam(':my_point', $point_after , PDO::PARAM_INT);
$stmt->bindParam(':my_name', $_SESSION['login']['name'], PDO::PARAM_STR);

if($point_after>=0){
    // クエリ実行
    $stmt->execute();
}
else{
    $_SESSION['loss'] = 1;
    header('Location:mypage.php');
}

// SQL文組み立て
$sql = "INSERT INTO for_admin SET ex_name=:my_name, ex_item=:my_item, ex_hash=:my_hash";


// SQL ステートメントを準備
$stmt = $pdo->prepare($sql);

$buy_name = $_SESSION['login']['name'];
$buy_item = $_SESSION['my']['all_items'][0]['item_name'];
$hash = sha1(random_bytes(30));

// パラメータをバインド
$stmt->bindParam(':my_name', $buy_name , PDO::PARAM_STR);
$stmt->bindParam(':my_item', $buy_item , PDO::PARAM_STR);
$stmt->bindParam(':my_hash', $hash , PDO::PARAM_STR);

// クエリ実行
$stmt->execute();

$mailto = $_SESSION['login']['all'][0]['email']; // 宛先のメールアドレス
$subject = "購入完了";
$content = 
"チャホカン 交換完了お知らせメール\n

チャホカンサービスをご利用いただきありがとうございます。\n
商品の交換が完了いたしましたので通知いたします。
アカウント名:".htmlspecialchars($buy_name, ENT_QUOTES, 'UTF-8')."様\n交換アイテム:".htmlspecialchars($buy_item,ENT_QUOTES, 'UTF-8')."\nid:".htmlspecialchars($hash,ENT_QUOTES, 'UTF-8');
$mailfrom = "From:non-reply@chahokan.com"; // From:送信元のメールアドレス

// mb_language("ja");
mb_internal_encoding("UTF-8");

// メール送信処理
$result = mb_send_mail($mailto,$subject,$content,$mailfrom);

// メール送信処理結果出力
// if($result){
//     echo "送信成功";
// }else{
//     echo "送信失敗";
// }
 
$_SESSION['buy']=1;

// 結果データ取得
// $all = $stmt->fetchAll(PDO::FETCH_ASSOC);

header('Location:mypage.php');
exit();

?>
<container class="content">

</container>
<?php require '../basic/footer.php'; ?>