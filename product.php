<?php
session_start();

$csstime = filemtime(__DIR__ . '/assets/css/product.css');
$csstime = date("Y-m-d\TH-i", $csstime);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Anime-Chill</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="./assets/imgs/favicon.ico" type="image/x-icon">

    <!-- Google font -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Autour+One&family=Roboto:ital,wght@0,100;0,400;0,500;0,700;0,900;1,100&display=swap"
        rel="stylesheet">

    <!-- Link css -->
    <link rel="stylesheet" href="./assets/css/style.css">
    <link rel="stylesheet" href="./assets/css/product.css?<?= $csstime ?>">
    <!-- Slick slider-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!-- google icon -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<body>

    <!-- HEADER -->
    <?php include('./header.php') ?>

    <main class="content">
        <article>

            <?php include('./assets/controller/function_frontend.php'); ?>
            <?php select_product() ?>

            <!-- PRODUCT DETAIL -->
            <div class="product-detail">
                <div class="container content">
                    <h4 class="product-detail_title">
                        <a href="index.php">Trang chủ /</a>
                        <a href="product.php?comic_id=<?= $comic_id ?>">
                            <?= $comic_name ?>
                        </a>
                    </h4>

                    <div class="product-detail_content">
                        <img src="./assets/imgs/<?= $comic_img ?>" alt="" class="product-detail_content-img">

                        <div class="product-detail_content-status">
                            <h4 class="status-title">
                                <?= $comic_name ?>
                            </h4>

                            <ul class="status-list">
                                <li class="status-item">
                                    <div class="item-left">
                                        <ion-icon name="person"></ion-icon>
                                        <span>Tác giả</span>
                                    </div>

                                    <div class="item-right">
                                        <span>
                                            <?= $comic_author ?>
                                        </span>
                                    </div>
                                </li>

                                <li class="status-item">
                                    <div class="item-left">
                                        <ion-icon name="logo-rss"></ion-icon style="transform: rotate(45deg);">
                                        <span>Trạng thái</span>
                                    </div>

                                    <div class="item-right">
                                        <span>
                                            <?= $comic_status ?>
                                        </span>
                                    </div>
                                </li>

                                <li class="status-item">
                                    <div class="item-left">
                                        <span class="material-symbols-outlined" style="font-size: 15px;">
                                            thumb_up
                                        </span>
                                        <span>Lượt thích</span>
                                    </div>

                                    <div class="item-right">
                                        <span>
                                            <?= $comic_like ?>
                                        </span>
                                    </div>
                                </li>

                                <li class="status-item">
                                    <div class="item-left">
                                        <ion-icon name="heart"></ion-icon>
                                        <span>Lượt theo dõi</span>
                                    </div>

                                    <div class="item-right">
                                        <span>
                                            <?= $comic_follow ?>
                                        </span>
                                    </div>
                                </li>

                                <li class="status-item">
                                    <div class="item-left">
                                        <ion-icon name="eye"></ion-icon>
                                        <span>Lượt xem</span>
                                    </div>

                                    <div class="item-right">
                                        <span>
                                            <?= $comic_views ?>
                                        </span>
                                    </div>
                                </li>
                            </ul>

                            <form action="" method="POST">
                                <button class="first-read" type="submit" name="first_read">
                                    <ion-icon name="book"></ion-icon>
                                    <span>Đọc Truyện</span>
                                </button>

                                <!-- <button class="continue-read">
                                        <ion-icon name="book"></ion-icon>
                                        <span>Đọc tiếp</span>
                                    </button> -->
                            </form>
                        </div>
                    </div>
                </div>
            </div>

            <!-- PRODUCT INFO -->
            <div class="product-info">
                <div class="container content">
                    <h4 class="infor-title infor-color">
                        <ion-icon name="information-circle"></ion-icon>
                        <span>Giới thiệu</span>
                    </h4>

                    <div class="info-content" data-information-content>
                        <p class="infor-content_text">
                            <?= $comic_description ?>
                        </p>
                    </div>
                </div>
            </div>

            <!-- CHAPTER -->
            <div class="chapter-box">
                <div class="container content">
                    <h4 class="chapter-title infor-color">
                        <ion-icon name="server-outline"></ion-icon>
                        <span>Danh sách chương</span>
                    </h4>

                    <ul class="chapter-list">
                        <?php
                        if (isset($_GET['chapter_latest'])) {
                            $chapter_latest = $_GET['chapter_latest'];
                        }
                        ?>

                        <?php foreach ($result_select_chapter as $row) { ?>
                            <li class="chapter-item">
                                <a href="detail_product.php?comic_id=<?= $comic_id ?>&chapter=<?= $row['id'] ?>"
                                    class="item-title <?php echo ($chapter_latest == $row['id']) ? ' active' : '' ?>">
                                    <?= $row['chapter_number'] ?>
                                </a>
                                <span class="item-time">
                                    <?= $row['chapter_date'] ?>
                                </span>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <!-- COMMENT -->
            <div class="comment">
                <div class="container content">
                    <h4 class="comment-title infor-color">
                        <ion-icon name="logo-wechat"></ion-icon>
                        <span>
                            Bình luận (
                            <?= $quantity_comment ?>)
                        </span>
                    </h4>


                    <?php
                    /**
                     * comment function
                     */
                    comment();
                    ?>
                    <div class="comment-form">
                        <div class="form-avt">
                            <img src="./assets/imgs/user_image.png" alt="">
                        </div>

                        <form action="" method="POST" class="comment-box">
                            <textarea rows="3" name="comment_content" class="comment-input"
                                placeholder="Write a comment" data-comment-input></textarea>

                            <button name="comment_btn" type="submit" class="comment-submit">
                                <ion-icon name="send" class="comment-icon" data-comment-icon></ion-icon>
                            </button>
                        </form>
                    </div>


                    <ul class="comment-user_list">
                        <?php foreach ($result_select_comment as $row) { ?>
                            <li class="comment-user_item">
                                <div class="comment-user_img">
                                    <img src="./assets/imgs/user_image.png" alt="">
                                </div>

                                <div class="comment-user_content">
                                    <h5 class="username">
                                        <?= strip_tags($row['user_name']); ?>
                                    </h5>
                                    <p>
                                        <?= strip_tags($row['comment_content']); ?>
                                    </p>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </article>
    </main>

    <!-- FOOTER -->
    <?php include('./footer.php') ?>

    <!-- SCROLL-TOP -->
    <a href="#top" class="scroll-top" data-scroll-top>
        <ion-icon name="arrow-up-outline"></ion-icon>
    </a>


    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- javascript -->
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/product.js"></script>

    <!-- ion-icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Slick slider-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>




</html>