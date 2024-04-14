<?php
include __DIR__ . '/../../database/config.php';

if (isset($_POST[ 'comic_id' ])) {
    $comic_id = $_POST[ 'comic_id' ];
    $extract  = implode(',', $comic_id);

    $sql_select  = "SELECT comic_img FROM comic WHERE comic_id IN($extract)";
    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute();
    $result = $stmt_select->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $row) {
        $old_img = $row[ 'comic_img' ];
        $save_at = __DIR__ . './../../assets/imgs/' . $old_img;
        unlink($save_at);
    }

    if (isset($old_img)) {
        $sql       = "DELETE FROM comic WHERE comic_id IN($extract)";
        $statement = $pdo->prepare($sql);
        $statement->execute();
    }
}

?>