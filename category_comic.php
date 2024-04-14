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
            <?php include('./assets/controller/function_frontend.php') ?>
            <?php category_comic() ?>

            <div class="main-top">
                <div class="success-comic content" id="success-comic" style="margin-top: 60px;">
                    <div class="container">
                        <h3 class="success-comic_title">
                            <?= $cate_name ?>
                        </h3>

                        <ul class="success-comic_list has-scrollbar">
                            <?php foreach($result as $row) { ?>
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