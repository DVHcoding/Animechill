<?php
include('./database/config.php');
session_start();

$csstime = filemtime(__DIR__ . '/assets/css/style.css');
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
    <link rel="stylesheet" href="./assets/css/style.css?<?= $csstime ?>">
    <!-- Slick slider-->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.css"
        integrity="sha512-yHknP1/AwR+yx26cB1y0cjvQUMvEa2PFzt1c9LlS4pRQ5NOTZFWbhBig+X9G9eYW/8m0/4OXNx8pxJ6z57x0dw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body id="top">

    <!-- HEADER -->
    <?php include('./header.php') ?>

    <main>
        <div class="article">
            <div class="main-top">

                <?php include('./assets/controller/function_frontend.php') ?>
                <?php select_comic() ?>

                <!-- TOP VIEW -->
                <div class="top-view content" id="top-view">
                    <div class="container">
                        <h3 class="top-view_title">
                            Top view
                        </h3>
                        <div class="top-view_slider">
                            <?php foreach ($result_top_view as $row) { ?>
                                <a href="./product.php?comic_id=<?= $row['comic_id'] ?>" class="slider-img">
                                    <img src="./assets/imgs/<?= $row['comic_img'] ?>" alt="">
                                    <span class="top-view_view">
                                        <span>
                                            <?= $row['comic_views'] ?> lượt xem
                                        </span>
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </span>
                                    <h4 class="top-view_subtitle">
                                        <?= $row['comic_name'] ?>
                                    </h4>
                                </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>


                <!-- NEW COMIC -->
                <div class="new-comic content" id="new-comic">
                    <div class="container">
                        <h3 class="new-comic_title">Truyện Mới</h3>
                        <ul class="new-comic_list">
                            <?php foreach ($result_new_comic as $row) { ?>

                                <?php
                                $databaseDate = new DateTime($row['comic_date']);
                                $currentDate = new DateTime();

                                $interval = $currentDate->diff($databaseDate);
                                ?>
                                <li class="new-comic_item">
                                    <a href="product.php?comic_id=<?= $row['comic_id'] ?>" class="new-comic_img">
                                        <img src="./assets/imgs/<?= $row['comic_img'] ?>" alt="">
                                        <span class="new-comic_view">
                                            <span>
                                                <?php
                                                if ($interval->days == 0) {
                                                    echo 'Hôm nay';
                                                } elseif ($interval->days == 1) {
                                                    echo 'Hôm qua';
                                                } elseif ($interval->days >= 365) {
                                                    $years = floor($interval->days / 365);
                                                    echo 'Khoảng ' . $years . ' năm trước';
                                                } else {
                                                    echo 'Khoảng ' . $interval->days . ' ngày trước';
                                                }
                                                ?>

                                            </span>
                                            <ion-icon name="calendar-outline"></ion-icon>
                                        </span>
                                    </a>
                                    <div class="new-comic_content">
                                        <div class="new-comic_content-title">
                                            <a href="product.php?comic_id=<?= $row['comic_id'] ?>">
                                                <?= $row['comic_name'] ?>
                                            </a>
                                            <span class="new-comic_content-view">
                                                <?= $row['comic_views'] ?> lượt đọc
                                            </span>
                                        </div>

                                        <?php
                                        /**
                                         * Lấy ra chapter mới nhất 
                                         */

                                        $comic_id = $row['comic_id'];
                                        $query_chapter_latest_date = "SELECT *
                                                                      FROM chapter
                                                                      WHERE comic_id = ?
                                                                      ORDER BY ABS(DATEDIFF(NOW(), chapter_date))  /*Hàm DATEDIFF trong SQL được sử dụng để tính toán sự chênh lệch giữa hai ngày.*/
                                                                      LIMIT 1";                                    /*Hàm ABS lấy giá trị tuyệt đối, đảm bảo rằng số k dc âm */
                                        $stmt_chapter_latest_date = $pdo->prepare($query_chapter_latest_date);
                                        $stmt_chapter_latest_date->execute([$comic_id]);
                                        $row_chapter = $stmt_chapter_latest_date->rowCount();
                                        if ($row_chapter < 1) {
                                            $chapter_latest_date = 0;
                                        } else {
                                            $result_chapter_latest_date = $stmt_chapter_latest_date->fetchAll(PDO::FETCH_ASSOC);
                                            foreach ($result_chapter_latest_date as $chap) {
                                                $chapter_latest_date = $chap['id'];
                                            }
                                        }

                                        /**
                                         * Lấy số chapter tương ứng cho từng id truyện, giới hạn 4 chap
                                         */
                                        $query_chapter = "SELECT * 
                                                          FROM chapter
                                                          INNER JOIN comic ON chapter.comic_id = comic.comic_id 
                                                          WHERE comic.comic_id = $comic_id  ORDER BY chapter.chapter_id ASC LIMIT 4";
                                        $stmt_chapter = $pdo->prepare($query_chapter);
                                        $stmt_chapter->execute();
                                        $result_chapter = $stmt_chapter->fetchAll(PDO::FETCH_ASSOC);
                                        ?>


                                        <ul class="chapter-list">
                                            <li class="chapter-item">
                                                <a href="product.php?comic_id=<?= $row['comic_id'] ?>&chapter_latest=<?= $chapter_latest_date ?>"
                                                    class="chapter-link active">Chap mới nhất</a>
                                            </li>
                                            <?php foreach ($result_chapter as $chap) { ?>
                                                <li class="chapter-item">
                                                    <a href="product.php?comic_id=<?= $row['comic_id'] ?>&chapter_latest=<?= $chap['id'] ?>"
                                                        class="chapter-link ">
                                                        <?= $chap['chapter_number'] ?>
                                                    </a>
                                                    <span class="chapter-time">
                                                        <?= $chap['chapter_date'] ?>
                                                    </span>
                                                </li>
                                            <?php } ?>
                                        </ul>
                                    </div>
                                </li>

                            <?php } ?>
                        </ul>
                    </div>
                </div>

                <!-- PAGINATION -->
                <?php
                // Hien thi 3 nut [1][2][3];
                $num_visible_pages = 3;
                $start_page = max(1, $page - floor($num_visible_pages / 2));
                $end_page = min($start_page + $num_visible_pages - 1, $total_pages);

                ?>
                <div class="pagination">
                    <a href="<?php echo ($page == 1) ? '#disable' : '?page=' . ($page - 1) ?>">&laquo;</a>

                    <?php for ($i = $start_page; $i <= $end_page; $i++) { ?>
                        <a href="?page=<?php echo $i ?>" class="<?php echo ($i == $page) ? 'active' : '' ?>">
                            <?= $i ?>
                        </a>
                    <?php } ?>

                    <a href="<?php echo ($page == $total_pages) ? '#disable' : ' ?page=' . ($page + 1) ?>">&raquo;</a>
                </div>
            </div>

            <!-- SUCCESS COMIC -->
            <div class="success-comic content" id="success-comic">
                <div class="container">
                    <h3 class="success-comic_title">Đã hoàn thành</h3>

                    <ul class="success-comic_list has-scrollbar">
                        <?php foreach ($completedComics as $row) { ?>
                            <li class="success-comic_item">
                                <a href="product.php?comic_id=<?= $row['comic_id'] ?>" class="success-comic_link">
                                    <img src="./assets/imgs/<?= $row['comic_img'] ?>" alt="">
                                    <span class="success-comic_view">
                                        <span>
                                            <?= $row['comic_views'] ?>
                                        </span>
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>

                </div>
            </div>

            <!-- UPCOMING -->
            <div class="upcoming content" id="upcoming">
                <div class="container">
                    <h3 class="upcoming_title">Đang cập nhật</h3>

                    <ul class="upcoming-list">
                        <?php foreach ($updatingComics as $row) { ?>
                            <li class="upcoming-item">
                                <a href="product.php?comic_id=<?= $row['comic_id'] ?>" class="upcoming_link">
                                    <img src="./assets/imgs/<?= $row['comic_img'] ?>" alt="" loading="lazy">
                                    <span class="upcoming_view">
                                        <span>
                                            <?= $row['comic_views'] ?>
                                        </span>
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <!-- MANGA -->
            <div class="manga content" id="manga">
                <div class="container">
                    <h3 class="manga_title">Truyện manga</h3>
                    <ul class="manga-list">
                        <?php foreach ($result_manga as $row) { ?>
                            <li class="manga-item">
                                <a href="product.php?comic_id=<?= $row['comic_id'] ?>" class="manga_link">
                                    <img src="./assets/imgs/<?= $row['comic_img'] ?>" alt="" loading="lazy">
                                    <span class="manga_view">
                                        <span>
                                            <?= $row['comic_views'] ?>
                                        </span>
                                        <ion-icon name="eye-outline"></ion-icon>
                                    </span>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>
        </div>
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

    <script>
        $(document).ready(function () {
            /*-----------------------------------*\
             * # UP COMING
            \*-----------------------------------*/
            $('.upcoming-list').slick({
                rows: 1,
                dots: true,
                infinite: true,
                speed: 800,
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                pauseOnFocus: false,
                prevArrow: `<button type='button' class='slick-prev pull-left'><ion-icon name="caret-back-outline"></ion-icon></button>`,
                nextArrow: `<button type='button' class='slick-next pull-right'><ion-icon name="caret-forward-outline"></ion-icon></button>`,

                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 900,
                    settings: {
                        slidesToShow: 5,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 2,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        slidesToShow: 3,
                        slidesToScroll: 2
                    }
                }
                ]
            })

            /*-----------------------------------*\
             * # MANGA 
            \*-----------------------------------*/
            $('.manga-list').slick({
                rows: 2,
                dots: true,
                infinite: true,
                speed: 800,
                slidesToShow: 6,
                slidesToScroll: 1,
                autoplay: true,
                autoplaySpeed: 1500,
                pauseOnFocus: false,
                prevArrow: `<button type='button' class='slick-prev pull-left'><ion-icon name="caret-back-outline"></ion-icon></button>`,
                nextArrow: `<button type='button' class='slick-next pull-right'><ion-icon name="caret-forward-outline"></ion-icon></button>`,

                responsive: [{
                    breakpoint: 1024,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 3,
                    }
                },
                {
                    breakpoint: 600,
                    settings: {
                        slidesToShow: 4,
                        slidesToScroll: 1,
                    }
                },
                {
                    breakpoint: 480,
                    settings: {
                        rows: 2,
                        slidesToShow: 3,
                        slidesToScroll: 1
                    }
                }
                ]
            })

        });
    </script>

    <!-- javascript -->
    <script src="./assets/js/script.js"></script>
    <!-- ion-icon -->
    <script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
    <!-- Slick slider-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/slick-carousel/1.8.1/slick.min.js"
        integrity="sha512-XtmMtDEcNz2j7ekrtHvOVR4iwwaD6o/FUJe6+Zq+HgcCsk3kj4uSQQR8weQ2QVj1o0Pk6PwYLohm206ZzNfubg=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</body>

</html>