<?php
function get_category()
{
    include ('./database/config.php');
    global $result_category;

    // select category for header.php file 
    $sql_select_category  = "SELECT * FROM category";
    $stmt_select_category = $pdo->prepare($sql_select_category);
    $stmt_select_category->execute();
    $result_category = $stmt_select_category->fetchAll(PDO::FETCH_ASSOC);
}


function get_coin($email)
{
    include ("./database/config.php");
    global $result_select_coin;

    $sql_select_coin  = "SELECT coin FROM user WHERE email = ?";
    $stmt_select_coin = $pdo->prepare($sql_select_coin);
    $stmt_select_coin->execute([$email]);
    $result_select_coin = $stmt_select_coin->fetchColumn();
}

?>