<?php require '../basic/header.php'; ?>

<?php
session_start();
include '../db/dbconnect.php';

if(!isset($_POST['name']) and !isset($_POST['ok'])){
    header('Location: index.php');
    exit();
}
function escape($str) {
    return htmlspecialchars($str,ENT_QUOTES,'UTF-8');
}

//tokenを変数に入れる
$token_sub = $_POST['token_sub'];
// print_r("sessiontoken=".$token_sub);
// print_r("token=".$token."\n");
// トークンを確認し、確認画面を表示
if(!(hash_equals($token_sub, $_SESSION['subscribe']['token_sub']) && !empty($token_sub))) {
    echo "不正アクセスの可能性があります";
    exit();
}

if($_SESSION['subscribe']['name']!=$_POST['name'] and !is_null($_POST['name'])){
    $_SESSION['subscribe']['name']=$_POST['name'];
    $_SESSION['subscribe']['pen_name']=$_POST['pen_name'];
    $_SESSION['subscribe']['password']=$_POST['password'];
    $_SESSION['subscribe']['signup']=$_POST['signup'];
    
    // print_r($_SESSION['subscribe']);
}
// print_r($_SESSION);
if(isset($_POST['ok'])){
    $sql = "INSERT INTO subscribe SET name=:my_name, pen_name=:pen_name, email=:my_email, password=:my_password, is_admin =:is_admin";

    // SQL ステートメントを準備
    $stmt = $pdo->prepare($sql);
    $is_admin = 0;

    // パラメータをバインド
    $stmt->bindParam(':my_name', $_SESSION['subscribe']['name'], PDO::PARAM_STR);
    $stmt->bindParam(':pen_name', $_SESSION['subscribe']['pen_name'], PDO::PARAM_STR);
    $stmt->bindParam(':my_email', $_SESSION['subscribe']['email'], PDO::PARAM_STR);
    $stmt->bindParam(':my_password', $_SESSION['subscribe']['password'], PDO::PARAM_STR);
    $stmt->bindParam(':is_admin', $is_admin, PDO::PARAM_INT);

    // クエリ実行
    $stmt->execute();
    // $stmt->debugDumpParams();
    header('Location: thanks.php');
    // exit();
}
?>
<container class="content"> 
    <form action="" method="post">
        <input type="hidden" name="action" value="submit" />
        <dl>
            <dt>名前</dt>
            <dd>
                <?php echo htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8');?>
            </dd>
            <dt>ニックネーム</dt>
            <dd>
                <?php echo htmlspecialchars($_POST['pen_name'], ENT_QUOTES, 'UTF-8');?>
            </dd>
            <dt>メールアドレス</dt>
            <dd>
                <?php echo htmlspecialchars($_POST['email'], ENT_QUOTES, 'UTF-8');?>
            </dd>
            <dt>パスワード</dt>
            <dd>
                【パスワードは表示されません。】
            </dd>
        </dl>
        <div><a href="check.php?action=rewrite" class="myButton">書き直す</a>
            <input type="hidden" name="token_sub" value= <?php echo escape($_SESSION['subscribe']['token_sub']); ?>>
            <input type="hidden" name="go" value="1"/> 
            <input type="submit" class="myButton" name="ok" value="登録" />
        </div>
    </form>
</container>
<?php require '../basic/footer.php'; ?>