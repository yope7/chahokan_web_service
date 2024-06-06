<?php require '../basic/header.php'; ?>

<?php
session_start();//sessionを使うための魔法

//ログインフラグが既に立っていれば直接マイページへ遷移
if($_SESSION['login']['loggedin']==1){
	header('Location: ../mypage/mypage.php');
	exit();
}


if (!empty($_POST)) {
	// ログインの処理
	if ($_POST['name'] != '' && $_POST['password'] != '') {

			include_once '../db/dbconnect.php';

			$sql = "SELECT * FROM `subscribe` WHERE name = :named AND password = :my_password";

			$stmt = $pdo->prepare($sql);

			$stmt->bindParam(':named', $_POST['name'], PDO::PARAM_STR);
			$stmt->bindParam(':my_password', $_POST['password'], PDO::PARAM_STR);

			$stmt->execute();

			$table = $stmt->fetchAll(PDO::FETCH_ASSOC);

			// print_r($table);

			if(!empty($table)){
			
				// ログイン成功	
			
				$_SESSION['login']['id']=$table[0]['id'];

				// print_r($_SESSION['id']);
				$_SESSION['login']['timestamp']=time();
				$_SESSION['login']['loggedin']="1";
				$_SESSION['login']['name']= $table[0]['name'];
				// $_SESSION['all_items'] = array();
			
				// SQL文組み立て
				$sql = "SELECT * FROM `subscribe` WHERE name = :named";
			
				// SQL ステートメントを準備
				$stmt = $pdo->prepare($sql);
			
				$name = $_SESSION['login']['name'];
			
				// パラメータをバインド
				$stmt->bindParam(':named', $_SESSION['login']['name'], PDO::PARAM_STR);
			
				// クエリ実行
				$stmt->execute();
			
				// 結果データ取得
				$all = $stmt->fetchAll(PDO::FETCH_ASSOC);
			
				$_SESSION['login']['all'] = $all;
				
				$stmt   = null;
				$all    = null;

				// クローズ
				$pdo = null;

				if($_SESSION['login']['all'][0]['is_admin'] == 1){
					header('Location: ../mypage/admin.php');
					exit();
				}else{
				header('Location: ../mypage/mypage.php');
				exit();
				}
			}else{
				$error['login'] = 'failed';
			}
	}else{
		$error['login'] = 'blank';
	}
}
?>
	<container class="content">
	<div id="wrap">
		<div id="head">
			<h1>ログインする</h1>
		</div>
		<div id="content">
			<div id="lead">
				<p>ユーザ名とパスワードを記入してログインしてください。</p>
			</div>
			<form action="" method="post">
				<dl>
					<dt>ユーザ名</dt>
					<dd>
						<input type="text" name="name" size="35" maxlength="255" value="<?php if(isset($_SESSION['join']['name'])){
																								echo htmlspecialchars($_SESSION['join']['name']);
																								}else{
																								echo htmlspecialchars($_POST['name']);
																								} ?>"/>
						<?php if ($error['login'] == 'blank'): ?>
							<p class="error">* ユーザ名とパスワードをご記入ください</p>
						<?php endif; ?>
						<?php if ($error['login'] == 'failed'): ?>
							<p class="error"><span class="error-in">* ログインに失敗しました。正しくご記入ください。</span></p>
						<?php endif; ?>
					</dd>
					<dt>パスワード</dt>
					<dd>
						<input type="password" name="password" size="35" maxlength="255" value="<?php echo htmlspecialchars($_POST['password']); ?>" />
					</dd>
				</dl>
				<div><input type="submit" class="myButton" value="ログインする" /></div>
			</form>
			<div>
				<p><br>入会手続きがまだの方はこちらからどうぞ。<br></p>			
				<p><a href="index.php" class="myButton">入会手続きをする</a></p>
			</div>
		</div>

	</div>
	</container>
<?php require '../basic/footer.php'; ?>