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
    <link rel="stylesheet" href="../assets/style.css">
    <link rel="stylesheet"
        href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">

    <script src="https://code.jquery.com/jquery-3.7.1.js"
        integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/40.0.0/classic/ckeditor.js"></script>

    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
        }

        /* CSS để tùy chỉnh thanh cuộn trên trình duyệt WebKit */
        .list-group::-webkit-scrollbar {
            width: 5px;
            /* Chiều rộng của thanh cuộn */
        }

        .list-group::-webkit-scrollbar-thumb {
            background-color: #f18121;
            /* Màu sắc của nút trượt */
        }

        .list-group::-webkit-scrollbar-track {
            background-color: #f1f1f1;
            /* Màu sắc của phần dẫn đường */
        }
    </style>
</head>




<body>
    <input type="checkbox" id="menu-toggle">

    <!------------------------------------------------------------------------------>
    <!--                              SIDEBAR                                      ->
    <!------------------------------------------------------------------------------>
    <?php include('../layout/sidebar.php') ?>

    <!------------------------------------------------------------------------------>
    <!--                              MAIN CONTENT                                 ->
    <!------------------------------------------------------------------------------>
    <div class="main-content">
        <!-- header content -->
        <?php include('../layout/header.php') ?>

        <!-- main content -->
        <main>

            <div class="page-header">
                <small>Home /
                    <?php if(!isset($_GET['link']) || $link == 'index') {
                        echo 'Dashboard';
                    } elseif($link == 'category') {
                        echo 'Category';
                    } elseif($link == 'comics') {
                        echo 'Comics / Update/ Chapter';
                    } elseif($link == 'comment') {
                        echo 'Comment';
                    } elseif($link == 'user') {
                        echo 'User';
                    } ?>
                </small>
            </div>

            <div class="page-content">
                <div class="records table-responsive">
                    <!------------------------------------------------------------------------------>
                    <!--                              MAIN BODY                                    ->
                    <!------------------------------------------------------------------------------>
                    <div style="padding-block: 50px;">
                        <table width="100%" style="display: flex; align-items: center; justify-content: center;">
                            <div class="container-fluid">
                                <div class="row flex justify-content-center">

                                    <?php include('../controller/function.php') ?>
                                    <?php update_chapter_comic() ?>
                                    <!-- DANH SACH CHAPTER-->
                                    <div class="col-6" style="display: flex;flex-direction:column; ">
                                        <form action="" method="POST">
                                            <div class="mb-2">
                                                <span class="btn btn-secondary">
                                                    <span class="las la-list"></span>
                                                    Danh sách chapter
                                                </span>
                                                <button name="remove" class="btn btn-danger">Xóa</button>
                                            </div>

                                            <div class="list-group" style="height: 510px; overflow-y: auto;">

                                                <?php foreach($result_chapter as $row) { ?>
                                                    <?php

                                                    $databaseDate = new DateTime($row['chapter_date']);
                                                    $currentDate = new DateTime();

                                                    $interval = $currentDate->diff($databaseDate);

                                                    ?>

                                                    <div class="form-group" style="display: flex;">

                                                        <div class="input-group-text" style="border-radius: 0;">
                                                            <input type="checkbox" name="select_remove[]"
                                                                value="<?= $row['chapter_id'] ?>"
                                                                aria-label="Checkbox for following text input">
                                                        </div>


                                                        <a href="update_chapter_img.php?link=comics&comic_id=<?= $comic_id ?>&chapter=<?= $row['chapter_id'] ?>"
                                                            class="list-group-item list-group-item-action">
                                                            <div class="d-flex w-100 justify-content-between">
                                                                <h6 class="mb-1">
                                                                    <?= $row['chapter_number'] ?>
                                                                </h6>
                                                                <small>
                                                                    <?php
                                                                    if($interval->days == 0) {
                                                                        echo 'Hôm nay';
                                                                    } elseif($interval->days == 1) {
                                                                        echo 'Hôm qua';
                                                                    } elseif($interval->days >= 365) {
                                                                        $years = floor($interval->days / 365);
                                                                        echo 'Khoảng '.$years.' năm trước';
                                                                    } else {
                                                                        echo 'Khoảng '.$interval->days.' ngày trước';
                                                                    }
                                                                    ?>
                                                                </small>
                                                            </div>
                                                        </a>
                                                    </div>

                                                <?php } ?>
                                            </div>

                                        </form>
                                    </div>

                                    <!-- THEM CHAPTER -->
                                    <div class="col-6" style="display: flex;flex-direction:column; ">
                                        <form action="" method="POST">
                                            <div class="mb-2">
                                                <button name="add_chapter" class="btn btn-success">
                                                    <span class="las la-list"></span>
                                                    Thêm chapter
                                                </button>
                                            </div>

                                            <div class="form-group">
                                                <input type="text" name="chapter_name" class="form-control"
                                                    placeholder="Nhập tên chapter" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="number" name="id" class="form-control"
                                                    placeholder="Nhập id (vd: Chapter 1; id = 1)" required>
                                            </div>
                                            <div class="form-group">
                                                <input type="date" name="chapter_date" class="form-control" required>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>

</html>