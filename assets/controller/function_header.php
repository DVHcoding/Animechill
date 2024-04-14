<?php
function get_category()
{
    include('./database/config.php');
    global $result_category;

    // select category for header.php file 
    $sql_select_category  = "SELECT * FROM category";
    $stmt_select_category = $pdo->prepare($sql_select_category);
    $stmt_select_category->execute();
    $result_category = $stmt_select_category->fetchAll(PDO::FETCH_ASSOC);

}

?>