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

    <script src="https://unpkg.com/dropzone@5/dist/min/dropzone.min.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/dropzone@5/dist/min/dropzone.min.css" type="text/css" />


    <style>
        .ck-editor__editable[role="textbox"] {
            /* editing area */
            min-height: 200px;
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
                        echo 'Comics / Update/ Chapter Image';
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
                                    <?php update_chapter_img() ?>

                                    <!-- DANH SACH CHAPTER-->
                                    <div class="col-6" style="display: flex;flex-direction:column; ">
                                        <form action="" method="POST">
                                            <div class="mb-2">
                                                <span class="btn btn-secondary">
                                                    <span class="las la-list"></span>
                                                    Danh sách chapter image
                                                </span>
                                            </div>

                                            <div class="list-group">
                                                <ul class="chapter_image-list"
                                                    style="display: flex; gap: 2px;  overflow-x: auto;">

                                                    <?php foreach($result_chapter_img as $row) { ?>
                                                        <li class="chapter_image_item">
                                                            <img src="./../../assets/imgs/<?= $row['image_url'] ?>" alt=""
                                                                style="width: 120px; border-radius: 5px;">
                                                        </li>
                                                    <?php } ?>
                                                </ul>
                                            </div>

                                        </form>
                                    </div>

                                    <!-- THEM CHAPTER -->
                                    <div class="col-6" style="display: flex;flex-direction:column; ">
                                        <form action="" method="POST" enctype="multipart/form-data">
                                            <div class="mb-2">
                                                <button class="btn btn-success">
                                                    <span class="las la-list"></span>
                                                    Thêm chapter image
                                                </button>

                                                <button class="btn btn-warning" type="submit"
                                                    name="upload">Upload</button>
                                            </div>

                                            <div class="form-group">
                                                <input type="file" name="files[]" id="file-input" multiple
                                                    style="margin-bottom: 20px;">


                                                <img src="../assets/img/default-image.png" alt=""
                                                    style="width: 150px; display: block; margin-bottom: 10px;"
                                                    id="default-img">
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


<script>
    let img = document.getElementById('default-img');
    let input = document.getElementById('file-input');

    input.onchange = (e) => {
        if (input.files[0])
            img.src = URL.createObjectURL(input.files[0]);
    }

    $(document).ready(function () {

        $('#file-input').change(function (e) {
            var img = $('#default-img')[0];
            if (this.files[0]) {
                img.src = URL.createObjectURL(this.files[0]);
            }
        });

    })
</script>

</html>