<?php
// 設定ファイルから読み込み
$config_file = __DIR__ . '/../../config/database.php';

if (file_exists($config_file)) {
    include $config_file;
} else {
    // デフォルト値（開発環境用）
    $host = 'localhost';
    $dbname = 'xs014145_chahodb';
    $user = 'xs014145_admin';
    $password = 'cogoodbadmin';
}

$dsn = sprintf("mysql:host=%s;dbname=%s", $host, $dbname);
// PDOインスタンス化
$pdo = new PDO($dsn, $user, $password);
?>