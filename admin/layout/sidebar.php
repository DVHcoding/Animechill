<div class="sidebar">
    <!-- side-header -->
    <div class="side-header">
        <h3>A<span>nimechill</span></h3>
    </div>


    <!-- side-content -->
    <div class="side-content">
        <div class="side-menu">
            <ul>
                <?php
                if (isset($_GET[ 'link' ])) {
                    $link = $_GET[ 'link' ];
                }
                ?>

                <li>
                    <a href="/animechill/admin/index.php?link=index"
                        class="<?php echo (!isset($_GET[ 'link' ]) || $link == 'index') ? ' active' : ''; ?>">
                        <span class="las la-home"></span>
                        <small>Dashboard</small>
                    </a>
                </li>
                <li>
                    <a href="/animechill/admin/category.php?link=category"
                        class="<?php echo ($link == 'category') ? ' active' : ''; ?>">
                        <span class="las la-list"></span>
                        <small>Category</small>
                    </a>
                </li>
                <li>
                    <a href="/animechill/admin/comics.php?link=comics"
                        class="<?php echo ($link == 'comics') ? ' active' : ''; ?>">
                        <span class="las la-quran"></span>
                        <small>Comics</small>
                    </a>
                </li>
                <li>
                    <a href="/animechill/admin/comment.php?link=comment"
                        class="<?php echo ($link == 'comment') ? ' active' : ''; ?>">
                        <span class="las la-comments"></span>
                        <small>Comment</small>
                    </a>
                </li>
                <li>
                    <a href="/animechill/admin/user.php?link=user"
                        class="<?php echo ($link == 'user') ? ' active' : ''; ?>">
                        <span class="las la-users"></span>
                        <small>User</small>
                    </a>
                </li>
                <li>
                    <a href="/animechill/index.php">
                        <span class="las la-door-open"></span>
                        <small>Home</small>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>