<?php
session_start();
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
    <link rel="stylesheet" href="./assets/css/detail_product.css">
    <link rel="stylesheet" href="./assets/css/product.css">
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

    <?php include('./assets/controller/function_frontend.php') ?>
    <?php select_detail_product() ?>
    <main class="content" id="main">
        <article>
            <!-- DETAIL-PRODUCT-TOP -->
            <div class="detail-product-top">
                <div class="container content">
                    <h4 class="top-title">Trang chủ /
                        <?= $comic_name ?> /
                        <?= $chapter_number ?>
                    </h4>
                    <p class="top-subtitle">
                        <?= $comic_name ?> -
                        <?= $chapter_number ?> <span class="time-update">(Cập nhật lúc
                            <?= $comic_date ?>)
                        </span>
                    </p>

                    <?php like_and_follow() ?>
                    <div class="product-top_bottom">
                        <p class="title">Like hoặc Share nếu bạn cảm thấy thích bộ truyện nhé!</p>

                        <form action="" method="POST" class="btn-list">
                            <button name="follow" class="btn-item">
                                <ion-icon name="heart-outline"></ion-icon>
                                <p class="btn-name">Theo dõi</p>
                            </button>

                            <button name="like" class="btn-item" style="background-color: #3B40B1;">
                                <span class="material-symbols-outlined" style="font-size: 1.2rem;">
                                    thumb_up
                                </span>
                                <p class="btn-name">Like</p>
                            </button>

                            <button name="report" class="btn-item" style="background-color: #FFCC00;">
                                <ion-icon name="warning-outline"></ion-icon>
                                <p class="btn-name">Báo cáo</p>
                            </button>
                        </form>
                    </div>

                    <div class="product-top_badge">
                        <ion-icon name="alert-circle-outline"></ion-icon>
                        <p class="badge-title">Sử dụng mũi tên (<-) hoặc (->) để chuyển chapter</p>
                    </div>
                </div>
            </div>
        </article>

        <!-- DETAIL-PRODUCT-CONTENT -->
        <div class="detail-product-content">
            <div class="container">
                <ul class="content-list">
                    <?php foreach ($result_chapter_img as $row) { ?>
                        <li class="content-item">
                            <img class="lazy" data-src="./assets/imgs/<?= $row['image_url'] ?>" alt="" loading="lazy">
                        </li>
                    <?php } ?>
                </ul>

                <div class="btn-action-chapter">
                    <a
                        href="detail_product.php?comic_id=<?= $comic_id ?>&chapter=<?= ($chapter == 1) ? '1' : ($chapter - 1) ?>">
                        <button class="btn-prev">
                            <ion-icon name="arrow-back"></ion-icon>
                            <span>Chap trước</span>
                        </button>
                    </a>

                    <a
                        href="detail_product.php?comic_id=<?= $comic_id ?>&chapter=<?= ($chapter == $chapter_last) ? $chapter_last : ($chapter + 1) ?>">
                        <button class="btn-next">
                            <span>Chap sau</span>
                            <ion-icon name="arrow-forward"></ion-icon>
                        </button>
                    </a>
                </div>

            </div>
        </div>

        <!-- DETAIL-PRODUCT-COMMENT -->
        <div class="comment">
            <div class="container content">
                <h4 class="comment-title infor-color">
                    <ion-icon name="logo-wechat"></ion-icon>
                    <span>Bình luận (
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
                        <textarea rows="3" name="comment_content" class="comment-input" placeholder="Write a comment"
                            data-comment-input></textarea>

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
                                    <?= $row['user_name'] ?>
                                </h5>
                                <p>
                                    <?= $row['comment_content'] ?>
                                </p>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
            </div>
        </div>

        <!-- DETAIL-PRODUCT-BOTTOM -->
        <div class="detail-product-bottom">
            <div class="container">
                <a href="index.php">
                    <ion-icon name="home"></ion-icon>
                </a>
                <button class="select-chapter" id="chapter-btn">
                    <span>
                        Chapter
                        <?= $chapter ?>
                    </span>
                    <ion-icon name="chevron-down-outline" id="chapter-icon"></ion-icon>

                    <ul class="chapter-list" id="chapter-list">
                        <?php foreach ($result_chapter_list as $row) { ?>
                            <li class="chapter-item <?php echo ($row['id'] == $chapter) ? ' active' : '' ?>">
                                <a href="detail_product.php?comic_id=<?= $comic_id ?>&chapter=<?= $row['id'] ?>"
                                    class="chapter-link">
                                    <?= $row['chapter_number'] ?>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </button>

                <div class="action-btn">
                    <a
                        href="detail_product.php?comic_id=<?= $comic_id ?>&chapter=<?= ($chapter == 1) ? '1' : ($chapter - 1) ?>">
                        <ion-icon name="chevron-back-outline"></ion-icon>
                    </a>
                    <a
                        href="detail_product.php?comic_id=<?= $comic_id ?>&chapter=<?= ($chapter == $chapter_last) ? $chapter_last : ($chapter + 1) ?>">
                        <ion-icon name="chevron-forward-outline"></ion-icon>
                    </a>
                </div>
            </div>
        </div>

    </main>

    <!-- FOOTER -->
    <?php include('./footer.php') ?>

    <!-- SCROLL-TOP -->
    <a href="#" class="scroll-top" data-scroll-top>
        <ion-icon name="arrow-up-outline"></ion-icon>
    </a>

    <!-- jquery -->
    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

    <!-- javascript -->
    <script src="./assets/js/script.js"></script>
    <script src="./assets/js/detail_product.js"></script>


    <!-- ion-icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Slick slider-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>


    <script>
        document.addEventListener("DOMContentLoaded", function () {
            var lazyloadImages = document.querySelectorAll("img.lazy");

            // Remove lazy class and set src for the first three images
            for (var i = 0; i < 3; i++) {
                var img = lazyloadImages[i];
                img.setAttribute('src', img.getAttribute('data-src'));
                img.classList.remove('lazy');
            }

            var lazyloadThrottleTimeout;

            function lazyload() {
                if (lazyloadThrottleTimeout) {
                    clearTimeout(lazyloadThrottleTimeout);
                }

                lazyloadThrottleTimeout = setTimeout(function () {
                    var scrollTop = window.pageYOffset;

                    // Process the remaining lazyload images
                    lazyloadImages.forEach(function (img, index) {
                        if (index >= 3 && img.offsetTop < window.innerHeight + scrollTop) {
                            img.setAttribute('src', img.getAttribute('data-src'));
                            img.classList.remove('lazy');
                        }
                    });

                    if (lazyloadImages.length == 0) {
                        document.removeEventListener("scroll", lazyload);
                        window.removeEventListener("resize", lazyload);
                        window.removeEventListener("orientationChange", lazyload);
                    }
                }, 20);
            }

            document.addEventListener("scroll", lazyload);
            window.addEventListener("resize", lazyload);
            window.addEventListener("orientationChange", lazyload);
        });
    </script>
</body>

</html>