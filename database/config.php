<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$dbhost = 'localhost';
$dbname = 'animechill';
$dbuser = 'root';
$dbpass = '';

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Thiết lập bộ ký tự UTF-8
    $pdo->exec('SET NAMES utf8');
    $pdo->exec('SET CHARACTER SET utf8');
} catch (PDOException $e) {
    echo 'Error: '.$e->getMessage();
}
?>