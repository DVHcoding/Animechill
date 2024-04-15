<?php
include ("./database/config.php");

$email        = $_GET['email'];
$comic_id     = $_GET['comic_id'];
$coin_of_user = $_GET['coin_of_user'];
$comic_price  = $_GET['comic_price'];

$coin_have_update = $coin_of_user - $comic_price;

$sql_update_coin_user  = "UPDATE `user`
                         SET
                            coin = ?
                         WHERE email = ?";
$stmt_update_coin_user = $pdo->prepare($sql_update_coin_user);
$stmt_update_coin_user->execute([$coin_have_update, $email]);


$sql_select_user_premium  = "SELECT user_premium FROM comic WHERE comic_id = ?";
$stmt_select_user_premium = $pdo->prepare($sql_select_user_premium);
$stmt_select_user_premium->execute([$comic_id]);
$total_list_user_premium = $stmt_select_user_premium->fetchColumn();

$total_list_user_premium .= $email . ', ';


$sql_update_user_premium  = "UPDATE comic
                            SET
                                user_premium= ?
                            WHERE comic_id = ?";
$stmt_update_user_premium = $pdo->prepare($sql_update_user_premium);
$stmt_update_user_premium->execute([$total_list_user_premium, $comic_id]);

echo '<script>
    var comic_id = "' . $comic_id . '";
    location.href = `product.php?comic_id=${comic_id}`;
</script>';

?>