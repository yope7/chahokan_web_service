<?php
$dsn = sprintf("mysql:host=%s;dbname=%s",'127.0.0.1' ,'xs014145_chahodb');
// PDOインスタンス化
$pdo = new PDO($dsn, 'xs014145_admin', 'cogoodbadmin');
?>