<?php require '../basic/header.php'; ?>
<?php
session_start();

    // ログインチェック
    if($_SESSION['login']['loggedin']!=1){
        header('Location: ../main/index.php');
        exit();
    }
    //adminのチェック
    if($_SESSION['login']['all'][0]['is_admin']!=1){
        header('Location: ../mypage/mypage.php');
        exit();
    }



//会員情報表示
include_once '../db/dbconnect.php';

// SQL文組み立て
$sql = "SELECT * FROM `for_admin`";

// SQL ステートメントを準備
$stmt = $pdo->prepare($sql);

// クエリ実行
$stmt->execute();

$_SESSION['admin'] = $stmt->fetchAll(PDO::FETCH_ASSOC);


?>

<container class="content">
<div>
    <?php
    echo"管理者画面\n";
    echo"こんにちは、{$_SESSION['login']['name']}さん！";
    ?>
</div>

<div class="headline">
    直近の交換履歴
    <div>
        <?php
        for($i=count($_SESSION['admin']);$i>=0;$i--){
        print_r($_SESSION['admin'][$i]['ex_name']."\n");
        print_r($_SESSION['admin'][$i]['ex_item']."\n");
        print_r($_SESSION['admin'][$i]['ex_hash']."\n");
        print_r($_SESSION['admin'][$i]['ex_timestamp']."\n");
        echo('<pre>');
        }
        ?>
    </div>
</div>
    


<div><a href="logout.php" class="myButton">ログアウト</a></div>
</container>
<?php require '../basic/footer.php'; ?>