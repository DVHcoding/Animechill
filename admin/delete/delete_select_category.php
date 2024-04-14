<?php
include __DIR__ . '/../../database/config.php';

if (isset($_POST['category_id'])) {
    $category_id = $_POST['category_id'];
    $extract     = implode(',', $category_id);

    $sql  = "DELETE FROM category WHERE category_id IN($extract)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
}

?>