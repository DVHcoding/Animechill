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

    <style>
        .search_box {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        .search_box button {
            position: absolute;
            right: 0;
            border: none;
            outline: none;
            background: none;
            cursor: pointer;
            opacity: 0;
            pointer-events: none;
        }
    </style>
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


            <div class="page-content">
                <div class="records table-responsive">
                    <div class="record-header">
                        <div class="add">
                            <span>Entries</span>
                            <select>
                                <option value="">ID</option>
                            </select>
                        </div>

                        <div class="browse">
                            <form action="" method="POST" class="search_box">
                                <input type="search" placeholder="Search" class="record-search" name="search_input">
                                <button type="submit" name="search">
                                    <span class="las la-search"></span>
                                </button>
                            </form>
                            <div class="action_btn">
                                <button class="remove_btn" id="delete">Xóa</button>

                                <a href="./create/create_comics.php?link=comics">
                                    <button class="add_btn">Thêm</button>
                                </a>
                            </div>
                        </div>
                    </div>


                    <!------------------------------------------------------------------------------>
                    <!--                              MAIN BODY                                    ->
                    <!------------------------------------------------------------------------------>

                    <div>
                        <table width="100%">
                            <thead>
                                <tr>
                                    <th style="width: 5%;"><input type="checkbox" name="select_all" id="select_all">
                                    </th>
                                    <th style="width: 15%;"><span class="las la-sort"></span>Comic Name</th>
                                    <th><span class="las la-sort"></span>Comic Author</th>
                                    <th style="width: 20%;"><span class="las la-sort"></span>Comic description
                                    </th>
                                    <th><span class="las la-sort"></span>Comic Image</th>
                                    <th><span class="las la-sort"></span>Comic Views</th>
                                    <th><span class="las la-sort"></span>Comic Date</th>
                                    <th style="width: 15%;"><span class="las la-sort"></span>Comic Category</th>
                                    <th><span class="las la-sort"></span>Comic Status</th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                /**
                                 * Hiển thị comics 
                                 */
                                include('./controller/function.php');
                                select_comic();

                                /**
                                 *  Xóa comics
                                 */
                                delete_comic();
                                ?>

                                <?php foreach($result as $row) { ?>
                                    <tr>
                                        <td><input type="checkbox" value="<?= $row['comic_id'] ?>" name="select">
                                        </td>

                                        <td>
                                            <?= $row['comic_name'] ?>
                                        </td>

                                        <td>
                                            <?= $row['comic_author'] ?>
                                        </td>

                                        <td>
                                            <?= substr($row['comic_description'], 0, 100) ?>
                                            <!-- gioi han 100 ki tu -->
                                        </td>


                                        <td>
                                            <img src="../assets/imgs/<?= $row['comic_img'] ?>" alt="" style="width: 60px;">
                                        </td>

                                        <td>
                                            <?= $row['comic_views'] ?>
                                        </td>

                                        <td>
                                            <?= $row['comic_date'] ?>
                                        </td>

                                        <?php
                                        // Create an array to store category names for the current comic
                                        $category_names = [];

                                        // Iterate over the $data array to find matching categories
                                        foreach($data as $cate) {
                                            if($cate['comic_id'] == $row['comic_id']) {
                                                $category_names[] = $cate['category_names'];
                                            }
                                        }
                                        ?>
                                        <td>
                                            <?= implode(', ', $category_names) ?>
                                        </td>
                                        <td>
                                            <?php if($row['comic_status'] == 'Ongoing') {
                                                echo 'Mới đăng';
                                            } elseif($row['comic_status'] == 'Upcoming') {
                                                echo 'Đang cập nhật';
                                            } elseif($row['comic_status'] == 'Completed') {
                                                echo 'Đã hoàn thành';
                                            } ?>
                                        </td>

                                        <td>
                                            <div class="actions">
                                                <a
                                                    href="./update/update_comics.php?link=comics&comic_id=<?= $row['comic_id'] ?>">
                                                    <span class="las la-pen" style="color: orange;"></span>
                                                </a>
                                                <a href="comics.php?link=comics&comic_id=<?= $row['comic_id'] ?>">
                                                    <span class="las la-trash-alt" style="color: red;"></span>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
</body>


<script>
    $(document).ready(function () {

        $("#delete").click(function (e) {
            e.preventDefault();

            var comic_id = $('input[name="select"]:checked').map(function () {
                return $(this).val();
            }).get();

            $.post("./delete/delete_select_comics.php", {
                comic_id: comic_id
            },
                function (result) {
                    location.reload();
                }
            );
        });



        // select tat ca
        $('#select_all').change(function () {
            // Đặt trạng thái của tất cả các ô checkbox khác giống với ô "slected All"
            $('input[name="select"]').prop('checked', $(this).prop('checked'));
        });

        //Đặt lại sự kiện cho tất cả các ô checkbox
        $('input[name="select"]').change(function () {
            // Nếu tất cả các ô checkbox khác đều được chọn, đặt trạng thái của "Check All" là chọn
            $('#select_all').prop('checked', $('input[name="select"]:checked').length === $('input[name="select"]').length);
        });
    });

</script>

</html>