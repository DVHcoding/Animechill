<?php
date_default_timezone_set('Asia/Ho_Chi_Minh');

$dbhost = 'localhost';
$dbname = 'animechill';
$dbuser = 'root';
$dbpass = '';

// Giúp không lỗi font tiếng việt
$opt = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpass, $opt);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch (PDOException $e) {
    echo 'Error: ' . $e->getMessage();
}
?>