<?php
session_start();
if(!isset($_SESSION['user']) && $_SESSION['user'][2] != 1 || $_SESSION['user'][2] != 2) {
    echo '<script>location.href="../login.php";</script>';
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <title>Modern Admin Dashboard</title>
    <link rel="stylesheet" href="./assets/style.css">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- favicon -->
    <link rel="shortcut icon" href="/animechill/assets/imgs/favicon.ico" type="image/x-icon">

</head>

<body>
    <input type="checkbox" id="menu-toggle">

    <!------------------------------------------------------------------------------>
    <!--                              SIDEBAR                                      ->
    <!------------------------------------------------------------------------------>
    <?php include('./layout/sidebar.php') ?>




    <!------------------------------------------------------------------------------>
    <!--                              MAIN CONTENT                                 ->
    <!------------------------------------------------------------------------------>
    <div class="main-content">
        <!-- header content -->
        <?php include('./layout/header.php') ?>

        <!-- main content -->
        <main>
            <div class="page-header">
                <h1>
                    <?php if(!isset($_GET['link']) || $link == 'index') {
                        echo 'Dashboard';
                    } elseif($link == 'category') {
                        echo 'Category';
                    } elseif($link == 'comics') {
                        echo 'Comics';
                    } elseif($link == 'comment') {
                        echo 'Comment';
                    } elseif($link == 'user') {
                        echo 'User';
                    } ?>
                </h1>

                <small>Home /
                    <?php if(!isset($_GET['link']) || $link == 'index') {
                        echo 'Dashboard';
                    } elseif($link == 'category') {
                        echo 'Category';
                    } elseif($link == 'comics') {
                        echo 'Comics';
                    } elseif($link == 'comment') {
                        echo 'Comment';
                    } elseif($link == 'user') {
                        echo 'User';
                    } ?>
                </small>
            </div>

            <?php include('./controller/function.php') ?>
            <?php select_comic() ?>

            <div class="page-content">
                <div class="analytics">
                    <div class="card">
                        <div class="card-head">
                            <h2>
                                <?= $total_user ?>
                            </h2>
                            <span class="las la-user-friends"></span>
                        </div>
                        <div class="card-progress">
                            <small>User</small>
                            <div class="card-indicator">
                                <div class="indicator one" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>
                                <?= $total_views ?>
                            </h2>
                            <span class="las la-eye"></span>
                        </div>
                        <div class="card-progress">
                            <small>Views</small>
                            <div class="card-indicator">
                                <div class="indicator two" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>
                                <?= $total_comic ?>
                            </h2>
                            <span class="las la-quran"></span>
                        </div>
                        <div class="card-progress">
                            <small>Comics</small>
                            <div class="card-indicator">
                                <div class="indicator three" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>

                    <div class="card">
                        <div class="card-head">
                            <h2>
                                <?= $total_chapter ?>
                            </h2>
                            <span class="las la-torah"></span>
                        </div>
                        <div class="card-progress">
                            <small>Chapter</small>
                            <div class="card-indicator">
                                <div class="indicator four" style="width: 100%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>