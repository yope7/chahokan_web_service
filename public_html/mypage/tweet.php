<?php require '../basic/header.php'; ?>

<?php
session_start();
sleep(1);
// if($_SESSION['all'][0]['timestanp']>date('Y-m-d H:i:s', strtotime('1 day', $targetTime))){

// }
// $formated_DATETIME = date('Y-m-d H:i:s');
// $sql = sprintf('INSERT INTO subscribe SET timestamp="%d" WHERE id ='.$_SESSION['all'][0]['ID']', 
// $formated_DATETIME);



    include_once '../db/dbconnect.php';
    //最終ツイート日時を取得
    $last_tweet_time = new DateTime($_SESSION['login']['all'][0]['timestamp']);
    $last_tweet_time= $last_tweet_time->format('Y-m-d H:i:s');
    
//タイムスタンプを打つ
    // SQL文組み立て
    $sql = "UPDATE `subscribe` SET timestamp=:my_timestamp WHERE id=:my_id";

    // SQL ステートメントを準備
    $stmt = $pdo->prepare($sql);

    $formated_DATETIME = date('Y-m-d H:i:s');
    // パラメータをバインド
    $stmt->bindParam(':my_id', $_SESSION['login']['all'][0]['id'], PDO::PARAM_INT);
    $stmt->bindParam(':my_timestamp', $formated_DATETIME, PDO::PARAM_STR);

    // クエリ実行
    $stmt->execute();    

    $stmt   = null;

// ポイント加算

    //当日にすでにツイート済みか確認(timestampの比較) 
    $now_day = new DateTime($formated_DATETIME);//taimestampをDateTime型に変換    
    if($last_tweet_time < $now_day->format('Y-m-d')){//今回の日時(Y-m-d 0:0:0)と前回の時間(Y-m-d H:i:s)の比較

    $new_point = (int)$_SESSION['login']['all'][0]['point'] + 1;
    $sql = "UPDATE `subscribe` SET point=:my_point WHERE id=:my_id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(':my_id', $_SESSION['login']['all'][0]['id'], PDO::PARAM_INT);
    $stmt->bindParam(':my_point', $new_point, PDO::PARAM_INT);

    $stmt->execute();
    $stmt   = null;
    }
    $pdo = null;



header("Location:https://twitter.com/intent/tweet?text=チャホカン最高！&hashtags=チャホカン");
?>
<container class="content">

</container>
<?php require '../basic/footer.php'; ?>