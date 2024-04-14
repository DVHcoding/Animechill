<?php
include __DIR__ . '/../../database/config.php';

if (isset($_POST[ 'user_id' ])) {
    $user_id = $_POST[ 'user_id' ];
    $extract = implode(',', $user_id);

    $sql       = "DELETE FROM user WHERE user_id IN($extract)";
    $statement = $pdo->prepare($sql);
    $statement->execute();

}

?>