<?php

// select comic at index.php file
function select_comic()
{
    include ('./database/config.php');
    global $result_top_view, $result_new_comic, $completedComics, $updatingComics, $result_chapter,
    $result_manga, $page, $total_pages;

    // Truy vấn truyện có nhiều lượt xem nhất (sắp xếp theo ngày và số lượt xem)
    $query_top_view = "SELECT * FROM comic ORDER BY comic_views DESC LIMIT 3";
    $stmt_top_view  = $pdo->prepare($query_top_view);
    $stmt_top_view->execute();
    $result_top_view = $stmt_top_view->fetchAll(PDO::FETCH_ASSOC);


    // Làm pagination cho truyện mới 
    if (isset($_GET['page'])) {
        $page = $_GET['page'];
    } else {
        $page = 1;
    }
    $show_each_page = 6; // Hiển thị 6 truyện mỗi trang
    // giả sử đang ở dòng số 1 thì sẽ là (1-1) * 6 sẽ là 0 => bắt đầu từ dòng số 0
    // nếu ở dòng số 2 thì sẽ là (2-1) * 6 sẽ là 6 => offset bắt đầu từ dòng số 6 ...
    $offset                = ($page - 1) * $show_each_page;
    $sql_select_total_row  = "SELECT * FROM comic WHERE comic_status = 'Ongoing'";
    $stmt_select_total_row = $pdo->prepare($sql_select_total_row);
    $stmt_select_total_row->execute();
    $total_rows = $stmt_select_total_row->rowCount();

    // ví dụ: tìm đc 20 row thì sẽ là (20/8) = 2.5. Hàm ceil sẽ làm tròn lên thành 3. Tức là 3 page
    // ví dụ 4.3 thì hàm ceil vẫn sẽ làm tròn lên 5
    $total_pages = ceil($total_rows / $show_each_page);


    // Truy vấn truyện mới
    $queryNew = "SELECT * FROM comic WHERE comic_status = 'Ongoing' ORDER BY comic_date DESC LIMIT $offset, 6";
    $stmtNew  = $pdo->prepare($queryNew);
    $stmtNew->execute();
    $result_new_comic = $stmtNew->fetchAll(PDO::FETCH_ASSOC);


    // Truy vấn truyện đã hoàn thành
    $queryCompleted = "SELECT * FROM comic WHERE comic_status = 'Completed' ORDER BY comic_date DESC";
    $stmtCompleted  = $pdo->prepare($queryCompleted);
    $stmtCompleted->execute();
    $completedComics = $stmtCompleted->fetchAll(PDO::FETCH_ASSOC);

    // Truy vấn truyện đang cập nhật
    $queryUpdating = "SELECT * FROM comic WHERE comic_status = 'Upcoming' ORDER BY comic_date DESC";
    $stmtUpdating  = $pdo->prepare($queryUpdating);
    $stmtUpdating->execute();
    $updatingComics = $stmtUpdating->fetchAll(PDO::FETCH_ASSOC);

    // Truy vấn chapters
    $query_chapter = "SELECT * 
                      FROM chapter 
                      INNER JOIN comic ON chapter.comic_id = comic.comic_id ORDER BY chapter.chapter_id ASC LIMIT 4";
    $stmt_chapter  = $pdo->prepare($query_chapter);
    $stmt_chapter->execute();
    $result_chapter = $stmt_chapter->fetchAll(PDO::FETCH_ASSOC);

    // Truy vấn Manga


}


// select chapter at product.php file
function select_product()
{
    include ('./database/config.php');
    if (isset($_GET['comic_id'])) {
        global $comic_id, $comic_name, $comic_author, $comic_description,
        $comic_img, $comic_views, $comic_date, $comic_status, $comic_like, $comic_follow,
        $result_select_chapter, $result_select_comment, $quantity_comment, $premium, $comic_price,
        $bought, $user_premium;

        $comic_id = $_GET['comic_id'];

        // Lấy truyện ứng với id 
        $sql  = "SELECT * FROM comic WHERE comic_id = $comic_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result            = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $comic_name        = $result[0]['comic_name'];
        $comic_author      = $result[0]['comic_author'];
        $comic_description = $result[0]['comic_description'];
        $comic_img         = $result[0]['comic_img'];
        $comic_views       = $result[0]['comic_views'];
        $comic_date        = $result[0]['comic_date'];
        $comic_status      = $result[0]['comic_status'];
        $comic_like        = $result[0]['like'];
        $comic_follow      = $result[0]['follow'];

        // Lấy chapter tương ứng với id
        $sql_select_chapter  = "SELECT * FROM chapter WHERE comic_id = ? ORDER BY chapter_id DESC";
        $stmt_select_chapter = $pdo->prepare($sql_select_chapter);
        $stmt_select_chapter->execute([$comic_id]);
        $result_select_chapter = $stmt_select_chapter->fetchAll(PDO::FETCH_ASSOC);

        // Lấy comment ứng với id 
        $sql_select_comment  = "SELECT * FROM comment WHERE comic_id = $comic_id";
        $stmt_select_comment = $pdo->prepare($sql_select_comment);
        $stmt_select_comment->execute();
        $quantity_comment      = $stmt_select_comment->rowCount();
        $result_select_comment = $stmt_select_comment->fetchAll(PDO::FETCH_ASSOC);


        // Update views khi người dùng nhấn đọc từ đầu
        if (isset($_POST['first_read'])) {
            $sql_update_views  = "UPDATE comic
	                             SET
	                             	comic_views= comic_views + 1
	                             WHERE comic_id = ?";
            $stmt_update_views = $pdo->prepare($sql_update_views);
            $stmt_update_views->execute([$comic_id]);

            /**  
             * them truyen da doc vao user database
             */

            if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
                $email = $_SESSION['user'][1];

                // Lấy dữ liệu hiện tại từ cột read_comic trong database
                $sql_get_read_comic  = "SELECT read_comic FROM `user` WHERE email = ?";
                $stmt_get_read_comic = $pdo->prepare($sql_get_read_comic);
                $stmt_get_read_comic->execute([$email]);
                $current_read_comic = $stmt_get_read_comic->fetchColumn(); // json
                $current_array      = json_decode($current_read_comic, true); // chuyen thanh mang

                $new_comic_user = array(
                    'comic_id'    => $comic_id,
                    'comic_img'   => $comic_img,
                    'comic_views' => $comic_views
                );

                // Kiểm tra xem có dữ liệu cũ hay không
                if ($current_read_comic == NULL) {
                    // Nếu không có dữ liệu cũ, thì chỉ cần sử dụng truyện mới
                    $comic_user = $new_comic_user;
                } else {
                    // Kiểm tra xem truyện có tồn tại trong danh sách hay không
                    $comic_exists = false;
                    foreach ($current_array as $item) {
                        if ($item['comic_id'] == $comic_id) {
                            $comic_exists = true;
                            break;
                        }
                    }

                    // Nếu truyện chưa tồn tại, thêm vào danh sách
                    if (!$comic_exists) {
                        $comic_user = array_merge($current_array, [$new_comic_user]);
                    } else {
                        $comic_user = $current_array;
                    }
                }

                // chuyen mang thanh json va them vao user database
                $comic_user_json = json_encode($comic_user, JSON_UNESCAPED_UNICODE);

                $sql_update_read_chapter = "UPDATE `user`
                                            SET read_comic = ?
                                            WHERE email = ?";

                $stmt_update_read_chapter = $pdo->prepare($sql_update_read_chapter);
                $stmt_update_read_chapter->execute([$comic_user_json, $email]);
            }
            echo '<script>location.href="detail_product.php?comic_id=' . $comic_id . '&chapter=1";</script>';
        }


        // Kiểm tra xem truyện có phải premium hay không ?
        $sql_select_comic_premium  = "SELECT * FROM comic WHERE comic_id = ?";
        $stmt_select_comic_premium = $pdo->prepare($sql_select_comic_premium);
        $stmt_select_comic_premium->execute([$comic_id]);
        $result_select_comic_premium = $stmt_select_comic_premium->fetchAll(PDO::FETCH_ASSOC);
        $premium                     = $result_select_comic_premium[0]['premium'];
        $comic_price                 = $result_select_comic_premium[0]['price'];
        $user_premium                = $result_select_comic_premium[0]['user_premium'];

        $email_array = explode(", ", $user_premium);

        if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
            if (in_array($_SESSION['user'][1], $email_array)) {
                $bought = "bought";
            } else {
                $bought = "not_bought";
            }


        }

        // Nếu người dùng nhấn vào truyện premium
        if (isset($_POST['buy_premium'])) {
            if (isset($_SESSION['user']) && $_SESSION['user'] != '') {
                $email = $_SESSION['user'][1];

                // Lay coin cua nguoi dung;
                $sql_select_coin_user  = "SELECT coin from user WHERE email = ?";
                $stmt_select_coin_user = $pdo->prepare($sql_select_coin_user);
                $stmt_select_coin_user->execute([$email]);
                $coin_of_user = $stmt_select_coin_user->fetchColumn();

                if ($comic_price <= $coin_of_user) {
                    echo '<script>
                var x = confirm("Bạn có chắc muốn mua không ?");
                var email = "' . $email . '"; // Sử dụng giá trị của biến PHP $email
                var comic_id = "' . $comic_id . '";
                var coin_of_user = "' . $coin_of_user . '";
                var comic_price = "' . $comic_price . '";

                if(x) {
                    location.href=`buy_comic_premium.php?email=${email}&comic_id=${comic_id}&coin_of_user=${coin_of_user}&comic_price=${comic_price}`;
                }
            </script>';
                } else {
                    echo '<script>alert("Bạn không đủ kim cương!")</script>';
                }
            } else {
                echo '<script>location.href="login.php"</script>';
            }
        }
    }
}


function select_detail_product()
{
    include ('./database/config.php');
    if (isset($_GET['comic_id']) || $_GET['chapter']) {
        global $comic_id, $comic_name, $comic_author, $comic_description, $comic_img,
        $comic_views, $comic_date, $comic_status, $chapter_number, $result_chapter_list, $chapter,
        $result_chapter_img, $chapter_last, $quantity_comment, $result_select_comment;

        $comic_id = $_GET['comic_id'];
        $chapter  = $_GET['chapter'];

        // select comic_name and chapter for top detail_product
        $sql  = "SELECT * 
                FROM comic 
                INNER JOIN chapter ON comic.comic_id = chapter.comic_id 
                WHERE comic.comic_id = $comic_id AND chapter.chapter_id = $chapter";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $row_stmt = $stmt->rowCount();
        if ($row_stmt > 0) {
            $result            = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $comic_name        = $result[0]['comic_name'];
            $comic_author      = $result[0]['comic_author'];
            $comic_description = $result[0]['comic_description'];
            $comic_img         = $result[0]['comic_img'];
            $comic_views       = $result[0]['comic_views'];
            $comic_date        = $result[0]['comic_date'];
            $comic_status      = $result[0]['comic_status'];
            $chapter_number    = $result[0]['chapter_number'];
        } else {
            $sql  = "SELECT * FROM comic WHERE comic_id = $comic_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();
            $result            = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $comic_name        = $result[0]['comic_name'];
            $comic_author      = $result[0]['comic_author'];
            $comic_description = $result[0]['comic_description'];
            $comic_img         = $result[0]['comic_img'];
            $comic_views       = $result[0]['comic_views'];
            $comic_date        = $result[0]['comic_date'];
            $comic_status      = $result[0]['comic_status'];
            $chapter_number    = 'Chapter ' . $chapter;
        }

        // select chapter for bottom detail_product
        $sql_chapter_list  = "SELECT * FROM chapter WHERE comic_id = $comic_id ORDER BY chapter_id DESC";
        $stmt_chapter_list = $pdo->prepare($sql_chapter_list);
        $stmt_chapter_list->execute();
        $result_chapter_list = $stmt_chapter_list->fetchAll(PDO::FETCH_ASSOC);


        // select image for content detail_product 
        $sql_chapter_img  = "SELECT image_url 
                             FROM chapter_img 
                             INNER JOIN chapter ON chapter_img.chapter_id = chapter.chapter_id
                             INNER JOIN comic ON chapter.comic_id = comic.comic_id
                             WHERE comic.comic_id = $comic_id AND chapter.id = $chapter";
        $stmt_chapter_img = $pdo->prepare($sql_chapter_img);
        $stmt_chapter_img->execute();
        $result_chapter_img = $stmt_chapter_img->fetchAll(PDO::FETCH_ASSOC);


        // lấy chapter cuối cùng làm nút chapter tiếp theo
        $sql_chapter_last  = "SELECT * FROM chapter WHERE comic_id = $comic_id ORDER BY chapter_id DESC LIMIT 1";
        $stmt_chapter_last = $pdo->prepare($sql_chapter_last);
        $stmt_chapter_last->execute();
        $row_chapter_last = $stmt_chapter_last->rowCount();

        if ($row_chapter_last > 0) {
            $result_chapter_last = $stmt_chapter_last->fetchAll(PDO::FETCH_ASSOC);
            $chapter_last        = $result_chapter_last[0]["id"];
        }


        // Lấy comment ứng với id 
        $sql_select_comment  = "SELECT * FROM comment WHERE comic_id = $comic_id";
        $stmt_select_comment = $pdo->prepare($sql_select_comment);
        $stmt_select_comment->execute();
        $quantity_comment      = $stmt_select_comment->rowCount();
        $result_select_comment = $stmt_select_comment->fetchAll(PDO::FETCH_ASSOC);


    }

}


function search()
{
    include ('./database/config.php');
    if (isset($_POST['search_btn'])) {
        global $result_search, $title;

        $search_input = $_POST['search_input'];
        $sql_search   = "SELECT * FROM comic WHERE comic_name LIKE '%$search_input%'";
        $stmt_search  = $pdo->prepare($sql_search);
        $stmt_search->execute();
        $result_search = $stmt_search->fetchAll(PDO::FETCH_ASSOC);
        $title         = "Kết quả tìm kiếm cho " . $search_input . ": ";

    }
}

function category_comic()
{
    include ('./database/config.php');
    if (isset($_GET['category_id']) && isset($_GET['cate_name'])) {
        global $result, $cate_name;
        $category_id = $_GET['category_id'];
        $cate_name   = $_GET['cate_name'];

        $sql  = "SELECT * 
                FROM comic
                INNER JOIN comic_category ON comic.comic_id = comic_category.comic_id 
                AND comic_category.category_id = $category_id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);


    }
}

function hot_comic()
{
    include ('./database/config.php');
    global $result;

    $sql  = "SELECT * FROM comic ORDER BY comic_views DESC LIMIT 10";
    $stmt = $pdo->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
}


// comment function
function comment()
{
    include ('./database/config.php');
    if (isset($_POST['comment_btn'])) {

        if (!isset($_SESSION['user']) || $_SESSION['user'] == '') {
            echo '<script>alert("Bạn phải đăng nhập!")</script>';
        } else {
            $username        = $_SESSION['user'][0];
            $comic_id        = $_GET['comic_id'];
            $comment_content = $_POST['comment_content'];

            $sql_insert_comment  = "INSERT INTO `comment`
	                               (comment_id, user_name, comment_content, comic_id)
	                               VALUES (NULL, ?, ?, ?)";
            $stmt_insert_comment = $pdo->prepare($sql_insert_comment);
            $stmt_insert_comment->execute([$username, $comment_content, $comic_id]);

            if (isset($_GET['chapter'])) {
                $chapter = $_GET['chapter'];
                echo '<script>location.href="detail_product.php?comic_id=' . $comic_id . '&chapter=' . $chapter . '";</script>';
            } else {
                echo '<script>location.href="product.php?comic_id=' . $comic_id . '";</script>';
            }

        }
    }
}

// login & sign-up forms
function login()
{
    include ('./database/config.php');

    if (isset($_POST['login'])) {
        $email = $_POST['email'];

        $sql_select_email  = "SELECT * FROM user WHERE email = ?";
        $stmt_select_email = $pdo->prepare($sql_select_email);
        $stmt_select_email->execute([$email]);
        $row = $stmt_select_email->rowCount();

        if ($row < 1) {
            echo '<span style="color: red; font-size:13px;">Tài khoản không tồn tại!</span>';

        } else {
            $result_select = $stmt_select_email->fetchAll(PDO::FETCH_ASSOC);
            $username_db   = $result_select[0]['username'];
            $email_db      = $result_select[0]['email'];
            $password_db   = $result_select[0]['password'];
            $role          = $result_select[0]['role'];

            if ($email == $email_db && password_verify($_POST['password'], $password_db)) {
                $_SESSION['user'] = [$username_db, $email_db, $role];

                if ($role == 1 || $role == 2) {
                    echo '<script>location.href="./admin/index.php";</script>';
                } else {
                    echo '<script>location.href="index.php";</script>';
                }
            } else {
                echo '<span style="color: red; font-size:13px;">Tài khoản hoặc mật khẩu không chính xác!</span>';
            }


        }

    }

    if (isset($_POST['register'])) {
        $email_register = $_POST['email_register'];
        $username       = $_POST['username'];
        $password       = $_POST['password_register'];

        $sql_select_email  = "SELECT * FROM user WHERE email = ?";
        $stmt_select_email = $pdo->prepare($sql_select_email);
        $stmt_select_email->execute([$email_register]);
        $row = $stmt_select_email->rowCount();

        if ($row > 0) {
            echo '<span style="color: red; font-size:13px;">Tài khoản đã tồn tại!</span>';
        } else {
            $password_hash    = password_hash($password, PASSWORD_BCRYPT);
            $sql_insert_user  = "INSERT INTO `user`
	                            (user_id, username, email, `password`, role, read_comic)
	                            VALUES (NULL, ?, ?, ?, 0, '[]')";
            $stmt_insert_user = $pdo->prepare($sql_insert_user);
            $stmt_insert_user->execute([$username, $email_register, $password_hash]);
            echo '<script>
                    var x = confirm("Đăng ký thành công. Hãy đăng nhập nào!.");
                if (x) {
                        location.href = "login.php";
                    } 
                 </script>';
        }

    }
}


// truyen da doc
function read_comic()
{
    include ('./database/config.php');
    global $array_comic;

    $email = $_SESSION['user'][1];

    $sql_select = "SELECT read_comic
	               FROM `user`
	               WHERE email = ?";

    $stmt_select = $pdo->prepare($sql_select);
    $stmt_select->execute([$email]);
    $result_select_comic_json = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
    $data_comic               = $result_select_comic_json[0]['read_comic'];
    $array_comic              = json_decode($data_comic, true);

}


// like and follow
function like_and_follow()
{
    include ('./database/config.php');
    if (isset($_GET['comic_id'])) {
        $comic_id = $_GET['comic_id'];

        if (isset($_POST['like'])) {
            $sql_update_like  = "UPDATE comic
	                            SET
	                            	`like`= `like` + 1
	                            WHERE comic_id = ?;";
            $stmt_update_like = $pdo->prepare($sql_update_like);
            $stmt_update_like->execute([$comic_id]);

            echo '<script>alert("Cảm ơn bạn đã thích bộ truyện!");</script>';
        }

        if (isset($_POST['follow'])) {
            $sql_update_follow  = "UPDATE comic
	                              SET
	                              	`follow`= `follow` + 1
	                              WHERE comic_id = ?;";
            $stmt_update_follow = $pdo->prepare($sql_update_follow);
            $stmt_update_follow->execute([$comic_id]);

            echo '<script>alert("Cảm ơn bạn đã theo dõi bộ truyện!");</script>';
        }

        if (isset($_POST['report'])) {
            echo '<script>alert("Chúng tôi sẽ cập nhật chức năng này sớm nhất có thể!");</script>';
        }
    }
}



?>
