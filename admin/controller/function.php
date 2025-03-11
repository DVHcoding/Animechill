<?php


// Hiển thị category ở file category.php
function select_category()
{
    include __DIR__ . '/../../database/config.php';

    if (isset($_POST['search'])) {
        $search_input = $_POST['search_input'];
        $sql          = "SELECT * FROM category WHERE category_name LIKE '%$search_input%'";
    } else {
        $sql = "SELECT * FROM category";
    }
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}



// Thêm category ở file create_category.php
function create_category()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_POST['submit'])) {
        $category_name = $_POST['category_name'];

        $sql = "INSERT INTO category
                	(category_id, category_name)
                	VALUES (NULL, ?)";

        $statement = $pdo->prepare($sql);
        $statement->execute([$category_name]);
        echo '<script>location.href="../category.php?link=category";</script>';
    }
}


// Xóa category ở file category.php
function delete_category()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['category_id'])) {
        $category_id = $_GET['category_id'];
        $sql         = "DELETE FROM category WHERE category_id = ?";
        $statement   = $pdo->prepare($sql);
        $statement->execute([$category_id]);
        echo '<script>location.href="category.php?link=category"</script>';
    }
}


// update category ở file update_category.php
function update_category()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['category_id'])) {
        global $category_name;

        $category_id = $_GET['category_id'];
        $sql         = "SELECT * FROM category WHERE category_id = ?";
        $statement   = $pdo->prepare($sql);
        $statement->execute([$category_id]);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $category_name = $row['category_name'];
        }


        if (isset($_POST['submit'])) {
            $category_name = $_POST['category_name'];

            $sql       = "UPDATE category
                        	SET
                        		category_id=?,
                        		category_name=?
                        	WHERE category_id=?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$category_id, $category_name, $category_id]);
            echo '<script>location.href="../category.php?link=category";</script>';
        }
    }
}



// Hiển thị comic ở file comic.php
function select_comic()
{
    include __DIR__ . '/../../database/config.php';
    global $total_views, $total_user, $total_chapter, $total_comic, $result, $data;

    if (isset($_POST['search'])) {
        $search_input = $_POST['search_input'];
        $sql          = "SELECT * FROM comic WHERE comic_name LIKE '%$search_input%'";
    } else {
        $sql = "SELECT * FROM comic";
    }
    $statement = $pdo->prepare($sql);
    $statement->execute();
    $result = $statement->fetchAll(PDO::FETCH_ASSOC);


    /**
     * Hiển thị category cho từng truyện
     */

    $sql_select_all_category  = "SELECT comic_id, GROUP_CONCAT(comic_category.category_id) AS category_ids,
                                GROUP_CONCAT(category.category_name) AS category_names
                                FROM comic_category
                                INNER JOIN category ON comic_category.category_id = category.category_id
                                GROUP BY comic_id";
    $stmt_select_all_category = $pdo->prepare($sql_select_all_category);
    $stmt_select_all_category->execute();

    $data = [];
    while ($row = $stmt_select_all_category->fetch(PDO::FETCH_ASSOC)) {
        $data[] = [
            'comic_id'       => $row['comic_id'],
            'category_ids'   => $row['category_ids'],
            'category_names' => $row['category_names']
        ];
    }


    /**
     * select total views in comic
     */
    $sql_select_total_views  = "SELECT SUM(comic_views) as total_views FROM comic";
    $stmt_select_total_views = $pdo->prepare($sql_select_total_views);
    $stmt_select_total_views->execute();
    $result_total_views = $stmt_select_total_views->fetch(PDO::FETCH_ASSOC);
    $total_views        = $result_total_views['total_views'];


    /**
     * select total user in comic
     */
    $sql_select_total_user  = "SELECT COUNT(*) AS total_user FROM user";
    $stmt_select_total_user = $pdo->prepare($sql_select_total_user);
    $stmt_select_total_user->execute();
    $result_total_user = $stmt_select_total_user->fetch(PDO::FETCH_ASSOC);
    $total_user        = $result_total_user['total_user'];

    /**
     * select total chapter in comic
     */
    $sql_select_total_chapter  = "SELECT COUNT(*) AS total_chapter FROM chapter";
    $stmt_select_total_chapter = $pdo->prepare($sql_select_total_chapter);
    $stmt_select_total_chapter->execute();
    $result_total_chapter = $stmt_select_total_chapter->fetch(PDO::FETCH_ASSOC);
    $total_chapter        = $result_total_chapter['total_chapter'];

    /**
     * select total comic in comic
     */
    $sql_select_total_comic  = "SELECT COUNT(*) AS total_comic FROM comic";
    $stmt_select_total_comic = $pdo->prepare($sql_select_total_comic);
    $stmt_select_total_comic->execute();
    $result_total_comic = $stmt_select_total_comic->fetch(PDO::FETCH_ASSOC);
    $total_comic        = $result_total_comic['total_comic'];


}


// Thêm category ở file create_comics.php
function create_comic()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_POST['submit'])) {
        $comic_name        = $_POST['comic_name'];
        $comic_author      = $_POST['comic_author'];
        $comic_description = $_POST['comic_description'];
        $comic_date        = $_POST['comic_date'];
        $comic_status      = $_POST['comic_status'];

        $comic_img = time() . '-' . $_FILES['comic_img']['name'];
        $comic_tmp = $_FILES['comic_img']['tmp_name'];
        $save_at   = __DIR__ . './../../assets/imgs/';


        $sql = "INSERT INTO comic
            	(comic_id, comic_name, comic_author, comic_description, comic_img, comic_views, 
            	comic_date, comic_status)
            	VALUES (NULL, ?, ?, ?, ?, 0, ?, ?)";

        $statement = $pdo->prepare($sql);
        $statement->execute([$comic_name, $comic_author, $comic_description, $comic_img, $comic_date, $comic_status]);
        move_uploaded_file($comic_tmp, $save_at . $comic_img);


        echo '<script>location.href="../comics.php?link=comics";</script>';
    }
}

// Xóa comic ở file comic.php
function delete_comic()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['comic_id'])) {
        $comic_id = $_GET['comic_id'];

        $sql_select  = "SELECT comic_img FROM comic WHERE comic_id = ?";
        $stmt_select = $pdo->prepare($sql_select);
        $stmt_select->execute([$comic_id]);
        $result  = $stmt_select->fetchAll(PDO::FETCH_ASSOC);
        $old_img = $result[0]['comic_img'];
        $save_at = __DIR__ . './../../assets/imgs/' . $old_img;

        if (isset($old_img)) {
            $sql       = "DELETE FROM comic WHERE comic_id = ?";
            $statement = $pdo->prepare($sql);
            $statement->execute([$comic_id]);
            unlink($save_at);
            echo '<script>location.href="comics.php?link=comics"</script>';
        }
    }
}


// update comic ở file update_comic.php
function update_comic()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['comic_id'])) {
        global $comic_id, $comic_old_name, $comic_old_img, $comic_old_author, $comic_old_description, $comic_old_date,
        $comic_old_status;

        $comic_id  = $_GET['comic_id'];
        $sql       = "SELECT * FROM comic WHERE comic_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$comic_id]);

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $comic_old_name        = $row['comic_name'];
            $comic_old_img         = $row['comic_img'];
            $comic_old_author      = $row['comic_author'];
            $comic_old_description = $row['comic_description'];
            $comic_old_date        = $row['comic_date'];
            $comic_old_status      = $row['comic_status'];

        }


        if (isset($_POST['submit'])) {
            $comic_name        = $_POST['comic_name'];
            $comic_author      = $_POST['comic_author'];
            $comic_description = $_POST['comic_description'];
            $comic_date        = $_POST['comic_date'];
            $comic_status      = $_POST['comic_status'];

            if ($_FILES['comic_img']['error'] == UPLOAD_ERR_OK) {
                $comic_img = time() . $_FILES['comic_img']['name'];
                $comic_tmp = $_FILES['comic_img']['tmp_name'];
                $save_at   = '../../assets/imgs/';
                $sql       = "UPDATE comic
                          SET
                          	comic_id=?,
                          	comic_name=?,
                          	comic_author=?,
                          	comic_description=?,
                          	comic_img=?,
                          	comic_date=?,
                          	comic_status=?
                          WHERE comic_id=?";
                $statement = $pdo->prepare($sql);
                $statement->execute([$comic_id, $comic_name, $comic_author, $comic_description, $comic_img, $comic_date, $comic_status, $comic_id]);
                move_uploaded_file($comic_tmp, $save_at . $comic_img);
                unlink($save_at . $comic_old_img);
            } else {
                // khi Không chọn file và lấy ảnh cũ
                $sql       = "UPDATE comic
                SET
                comic_id=?,
                comic_name=?,
                comic_author=?,
                comic_description=?,
                comic_date=?,
                comic_status=?
                WHERE comic_id=?";
                $statement = $pdo->prepare($sql);
                $statement->execute([$comic_id, $comic_name, $comic_author, $comic_description, $comic_date, $comic_status, $comic_id]);
            }

            echo '<script>location.href="../comics.php?link=comics";</script>';
        }
    }
}


function update_cate_comic()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['comic_id'])) {
        global $comic_id, $result_category, $result_exist_category;

        $comic_id = $_GET['comic_id'];

        /** 
         * Select nhung category ma $comic_id chua co
         */
        $sql_select_category  = "SELECT *
                                FROM category 
                                WHERE NOT EXISTS (
                                      SELECT * 
                                      FROM comic_category 
                                      WHERE comic_category.category_id = category.category_id
                                      AND comic_category.comic_id = ? 
                                 );";
        $stmt_select_category = $pdo->prepare($sql_select_category);
        $stmt_select_category->execute([$comic_id]);
        $result_category = $stmt_select_category->fetchAll(PDO::FETCH_ASSOC);

        /**
         * Select nhung category ma $comic_id co roi
         */
        $sql_exist_category  = "SELECT *
                               FROM category 
                               WHERE EXISTS (
                                     SELECT * 
                                     FROM comic_category 
                                     WHERE comic_category.category_id = category.category_id
                                     AND comic_category.comic_id = ? 
                                 );";
        $stmt_exist_category = $pdo->prepare($sql_exist_category);
        $stmt_exist_category->execute([$comic_id]);
        $result_exist_category = $stmt_exist_category->fetchAll(PDO::FETCH_ASSOC);


        /**
         * Them nhung category chua co
         */
        if (isset($_POST['add'])) {
            $select_category = (isset($_POST['select_add'])) ? $_POST['select_add'] : '';

            if (empty($select_category)) {
                echo '<script>alert("Bạn phải chọn ít nhất một danh mục.");</script>';
            } else {
                foreach ($select_category as $category_id) {
                    $sql_insert_category  = "INSERT INTO comic_category
                                            (comic_id, category_id)
                                            VALUES (?, ?)";
                    $stmt_insert_category = $pdo->prepare($sql_insert_category);
                    $stmt_insert_category->execute([$comic_id, $category_id]);
                }
                echo '<script>location.href="update_cate_comics.php?link=comics&comic_id=' . $comic_id . '";</script>';
            }
        }

        /**
         * Xoa nhung category da co
         */

        if (isset($_POST['remove'])) {
            $select_category = (isset($_POST['select_remove'])) ? $_POST['select_remove'] : '';
            if (empty($select_category)) {
                echo '<script>alert("Bạn phải chọn ít nhất một danh mục.");</script>';
            } else {
                foreach ($select_category as $category_id) {
                    $sql_delete_category = "DELETE FROM comic_category WHERE comic_id = ? AND category_id = ?";

                    $stmt_delete_category = $pdo->prepare($sql_delete_category);
                    $stmt_delete_category->execute([$comic_id, $category_id]);
                }
                echo '<script>location.href="update_cate_comics.php?link=comics&comic_id=' . $comic_id . '";</script>';
            }
        }
    }
}

function update_chapter_comic()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['comic_id'])) {

        global $result_chapter, $comic_id;

        $comic_id = $_GET['comic_id'];
        /**
         * select het chapter tuong ung voi comic_id
         */
        $sql_select_chapter  = "SELECT * FROM chapter WHERE comic_id = ?";
        $stmt_select_chapter = $pdo->prepare($sql_select_chapter);
        $stmt_select_chapter->execute([$comic_id]);
        $result_chapter = $stmt_select_chapter->fetchAll(PDO::FETCH_ASSOC);


        /**
         * Them chapter
         */

        if (isset($_POST['add_chapter'])) {

            $chapter_name = $_POST['chapter_name'];
            $id           = $_POST['id'];
            $chapter_date = $_POST['chapter_date'];

            $sql_insert_chapter  = "INSERT INTO chapter
	                               (chapter_id, chapter_number, chapter_date, comic_id, id)
	                               VALUES (NULL, ?, ?, ?, ?)";
            $stmt_insert_chapter = $pdo->prepare($sql_insert_chapter);
            $stmt_insert_chapter->execute([$chapter_name, $chapter_date, $comic_id, $id]);
            echo '<script>location.href="update_chap_comics.php?link=comics&comic_id=' . $comic_id . '"</script>';

        }


        /**
         * Xoa chapter
         */

        if (isset($_POST['remove'])) {
            $chapter_select = $_POST['select_remove'];

            foreach ($chapter_select as $chapter_id) {
                $sql_delete_chapter  = "DELETE FROM chapter WHERE chapter_id=?";
                $stmt_delete_chapter = $pdo->prepare($sql_delete_chapter);
                $stmt_delete_chapter->execute([$chapter_id]);
            }

            echo '<script>location.href="update_chap_comics.php?link=comics&comic_id=' . $comic_id . '"</script>';
        }
    }

}

function update_chapter_img()
{
    include __DIR__ . '/../../database/config.php';
    global $result_chapter_img, $comic_id, $chapter;

    /**
     * hien thi chapter_img 
     */
    if (isset($_GET['comic_id'])) {
        $comic_id = $_GET['comic_id'];
        $chapter  = $_GET['chapter'];

        // select image for content detail_product 
        $sql_chapter_img  = "SELECT image_url 
                            FROM chapter_img 
                            INNER JOIN chapter ON chapter_img.chapter_id = chapter.chapter_id
                            INNER JOIN comic ON chapter.comic_id = comic.comic_id
                            WHERE comic.comic_id = $comic_id AND chapter.chapter_id = $chapter";
        $stmt_chapter_img = $pdo->prepare($sql_chapter_img);
        $stmt_chapter_img->execute();
        $result_chapter_img = $stmt_chapter_img->fetchAll(PDO::FETCH_ASSOC);

    }

    /**
     * upload chapter_image
     */

    if (isset($_POST['upload'])) {
        $allFilesUploaded = true; // Khởi tạo biến flag

        foreach ($_FILES['files']['tmp_name'] as $key => $tmp_name) {
            $chapter_img = time() . '-' . $_FILES['files']['name'][$key];
            $chapter_tmp = $_FILES['files']['tmp_name'][$key];
            $save_at     = __DIR__ . './../../assets/imgs/';

            $move_file = move_uploaded_file($chapter_tmp, $save_at . $chapter_img);

            if ($move_file) {
                $insert = "INSERT INTO chapter_img
                (chapter_img_id, chapter_id, image_url)
                VALUES (NULL, ?, ?)";

                $stmt_insert = $pdo->prepare($insert);
                $stmt_insert->execute([$chapter, $chapter_img]);
            } else {
                $allFilesUploaded = false; // Nếu có lỗi khi upload file, đặt biến flag thành false
            }
        }

        // Chuyển hướng trang sau khi đã xử lý tất cả các file
        if ($allFilesUploaded) {
            echo '<script>location.href="update_chapter_img.php?link=comics&comic_id=' . $comic_id . '&chapter=' . $chapter . '";</script>';
            exit(); // Đảm bảo kết thúc kịch bản sau khi chuyển hướng
        } else {
            echo '<script>alert("Có lỗi xảy ra khi upload file.");</script>';
        }
    }



}


// select comment at comment.php file
function select_comments()
{
    include __DIR__ . '/../../database/config.php';
    global $result_comments;

    if (isset($_POST['search'])) {
        $search_input       = $_POST['search_input'];
        $sql_select_comment = "SELECT *
                            FROM comment
                            INNER JOIN comic ON comment.comic_id = comic.comic_id
                            WHERE comment.comment_content LIKE '%$search_input%'";
    } else {
        $sql_select_comment = "SELECT *
                            FROM comment
                            INNER JOIN comic ON comment.comic_id = comic.comic_id;";
    }

    $stmt_select_comment = $pdo->prepare($sql_select_comment);
    $stmt_select_comment->execute();
    $result_comments = $stmt_select_comment->fetchAll(PDO::FETCH_ASSOC);
}


// Xóa comment ở file comment.php
function delete_comment()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['comment_id'])) {
        $comment_id = $_GET['comment_id'];

        $sql       = "DELETE FROM comment WHERE comment_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$comment_id]);
        echo '<script>location.href="comment.php?link=comment"</script>';
    }
}


// select user at user.php file
function select_user()
{
    include __DIR__ . '/../../database/config.php';
    global $result_users, $role;

    $role = $_SESSION['user'][2];

    if (isset($_POST['search'])) {
        $search_input    = $_POST['search_input'];
        $sql_select_user = "SELECT * FROM user WHERE username LIKE '%$search_input%' OR email LIKE '%$search_input%'";
    } else {
        $sql_select_user = "SELECT * FROM user";
    }

    $stmt_select_user = $pdo->prepare($sql_select_user);
    $stmt_select_user->execute();
    $result_users = $stmt_select_user->fetchAll(PDO::FETCH_ASSOC);
}

// delete user at user.php file
function delete_user()
{
    include __DIR__ . '/../../database/config.php';
    if (isset($_GET['user_id'])) {
        $user_id   = $_GET['user_id'];
        $sql       = "DELETE FROM user WHERE user_id = ?";
        $statement = $pdo->prepare($sql);
        $statement->execute([$user_id]);
        echo '<script>location.href="user.php?link=user"</script>';
    }
}



// update user at update_user.php file
function update_user()
{
    include __DIR__ . '/../../database/config.php';
    global $result_role;

    if (isset($_GET['user_id'])) {
        $user_id          = $_GET['user_id'];
        $sql_select_role  = "SELECT role FROM user WHERE user_id = ?";
        $stmt_select_role = $pdo->prepare($sql_select_role);
        $stmt_select_role->execute([$user_id]);
        $result_role = $stmt_select_role->fetchColumn();

        // update
        if (isset($_POST['update'])) {
            $role            = $_POST['role'];
            $sql_update_role = "UPDATE `user`
	                            SET
	                            	role=?
	                            WHERE user_id = ?";

            $stmt_update_role = $pdo->prepare($sql_update_role);
            $stmt_update_role->execute([$role, $user_id]);
            echo '<script>location.href="../user.php?link=user";</script>';
        }

    }

}

?>
