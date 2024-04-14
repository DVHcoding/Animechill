<?php
include __DIR__ . '/../../database/config.php';

if (isset($_POST[ 'comment_id' ])) {
    $comment_id = $_POST[ 'comment_id' ];
    $extract    = implode(',', $comment_id);

    $sql  = "DELETE FROM comment WHERE comment_id IN($extract)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

?>