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
                                <option>ID</option>
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
                                    <th><input type="checkbox" name="select_all" id="select_all"></th>
                                    <th><span class="las la-sort"></span>UserName</th>
                                    <th><span class="las la-sort"></span>Comment</th>
                                    <th><span class="las la-sort"></span>Comic</th>
                                    <th><span class="las la-sort"></span> ACTIONS</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php
                                /**
                                 * Hiển thị comments
                                 */
                                include('./controller/function.php');
                                select_comments();
                                /**
                                 * Xoa comments
                                 */
                                delete_comment();
                                ?>

                                <?php foreach($result_comments as $row) { ?>
                                    <tr>
                                        <td><input type="checkbox" value="<?= $row['comment_id'] ?>" name="select">
                                        </td>

                                        <td>
                                            <?= $row['user_name'] ?>
                                        </td>

                                        <td>
                                            <?= $row['comment_content'] ?>
                                        </td>

                                        <td>
                                            <img src="../assets/imgs/<?= $row['comic_img'] ?>" alt="" style="width: 60px;">
                                        </td>

                                        <td>
                                            <div class="actions">
                                                <a href="comment.php?link=comment&comment_id=<?= $row['comment_id'] ?>">
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

            var comment_id = $('input[name="select"]:checked').map(function () {
                return $(this).val();
            }).get();

            $.post("./delete/delete_select_comment.php", {
                comment_id: comment_id
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