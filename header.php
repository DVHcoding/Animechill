<?php
if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
    $username = $_SESSION['user'][0];
    $email    = $_SESSION['user'][1];
}


/**
 * Dang xuat
 */

if (isset($_POST['logout'])) {
    session_destroy();
    echo '<script>location.href="login.php"</script>';
}
?>

<?php include ('./assets/controller/function_header.php') ?>

<header class="header" style="top: 0;">
    <div class="container">
        <a href="/animechill/index.php" class="logo">
            <img src="./assets/imgs/logo.svg" alt="logo" class="logo-img">
        </a>

        <button class="menu-open" id="menu-open">
            <ion-icon name="menu-outline"></ion-icon>
        </button>



        <nav class="navbar" id="navbar">
            <div class="navbar-list">
                <ul class="navbar-item">
                    <div class="comic-list">
                        <button id="danh-sach">
                            <img src="./assets/imgs/icons/menu-list.svg" alt="">
                            <span>Danh Sách</span>
                        </button>

                        <a href="hot_comic.php" class="navbar-action">
                            <button class="top-comic-icon">
                                <img src="./assets/imgs/icons/top-comic.svg" alt="">
                                <span>Truyện Hot</span>
                            </button>
                        </a>

                        <form action="search_comic.php" method="POST" class="search">
                            <input type="text" name="search_input" placeholder="Tìm tên truyện...">
                            <button type="submit" name="search_btn">
                                <ion-icon name="search-outline"></ion-icon>
                            </button>
                        </form>
                    </div>


                    <?php get_category() ?>
                    <ul class="hot-comic-list" id="hot-comic-list">

                        <li class="hot-comic-top">
                            <a href="index.php#manga" class="comic-link">Manga</a>
                        </li>

                        <div class="comic-box">
                            <?php foreach ($result_category as $row) { ?>
                                <li class="hot-comic-item">
                                    <a href="category_comic.php?category_id=<?= $row['category_id'] ?>&cate_name=<?= $row['category_name'] ?>"
                                        class="comic-link">
                                        <?= $row['category_name'] ?>
                                    </a>
                                </li>
                            <?php } ?>
                        </div>
                    </ul>
                </ul>
            </div>
        </nav>

        <div class="user">
            <ion-icon name="person-circle-outline"></ion-icon>
            <div class="user-list">
                <div class="user-name">
                    <span>
                        <?php if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
                            echo $username;
                        } else {
                            echo 'Guest';
                        } ?>
                    </span>
                </div>
                <div class="chapter-read">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
                        echo '<a href="read_comic.php">Truyện đã đọc</a>';
                    } else {
                        echo '';
                    } ?>
                </div>

                <form action="" method="POST" class="btn-action">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
                        echo '<button type="submit" name="logout">Đăng xuất</button>';
                    } else {
                        echo '<a href="login.php" class="login">Đăng nhập</a>';
                    } ?>
                </form>
            </div>
        </div>
    </div>
</header>
