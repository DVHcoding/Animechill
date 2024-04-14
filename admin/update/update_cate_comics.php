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
                        echo 'Comics / Update/ Categories';
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
                                    <?php update_cate_comic() ?>
                                    <!-- DANH SACH CATEGORY CHUA THEM -->

                                    <div class="col-6" style="display: flex;flex-direction:column; ">
                                        <form action="" method="POST">
                                            <div class="mb-2">
                                                <span class="btn btn-secondary">
                                                    <span class="las la-list"></span>
                                                    Danh sách category chưa thêm
                                                </span>
                                                <button name="add" class="btn btn-primary">Thêm</button>
                                            </div>

                                            <?php foreach($result_category as $row): ?>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input type="checkbox" name="select_add[]"
                                                                value="<?= $row['category_id'] ?>"
                                                                aria-label="Checkbox for following text input">
                                                        </div>
                                                    </div>

                                                    <div class="form-control">
                                                        <label>
                                                            <?= $row['category_name'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php endforeach; ?>
                                        </form>
                                    </div>

                                    <!-- DANH SACH CATEGORY DA THEM -->
                                    <div class="col-6" style="display: flex;flex-direction:column; ">
                                        <form action="" method="POST">
                                            <div class="mb-2">
                                                <span class="btn btn-success">
                                                    <span class="las la-list"></span>
                                                    Danh sách category đã thêm
                                                </span>
                                                <button name="remove" class="btn btn-danger">Xóa</button>
                                            </div>
                                            <?php foreach($result_exist_category as $row) { ?>
                                                <div class="input-group mb-3">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <input type="checkbox" name="select_remove[]"
                                                                value="<?= $row['category_id'] ?>"
                                                                aria-label="Checkbox for following text input">
                                                        </div>
                                                    </div>

                                                    <div class="form-control">
                                                        <label>
                                                            <?= $row['category_name'] ?>
                                                        </label>
                                                    </div>
                                                </div>
                                            <?php } ?>
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
        ClassicEditor
            .create(document.querySelector('#editor'))
            .catch(error => {
                console.error(error);
            });

        $('#file-input').change(function (e) {
            var img = $('#default-img')[0];
            if (this.files[0]) {
                img.src = URL.createObjectURL(this.files[0]);
            }
        });

    })
</script>

</html>