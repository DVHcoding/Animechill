<?php
if(!isset($_SESSION['user']) && $_SESSION['user'][2] != 1 || $_SESSION['user'][2] != 2) {
    echo '<script>location.href="../login.php";</script>';
    exit();
} else {
    if(isset($_POST['logout'])) {
        session_destroy();
        echo '<script>location.href="/animechill/login.php";</script>';
    }
}
?>

<header>
    <div class="header-content">
        <label for="menu-toggle">
            <span class="las la-bars"></span>
        </label>

        <div class="header-menu">
            <div class="notify-icon">
                <span class="las la-envelope"></span>
                <span class="notify">4</span>
            </div>

            <div class="notify-icon">
                <span class="las la-bell"></span>
                <span class="notify">3</span>
            </div>

            <form action="" method="POST" class="user">
                <div class="bg-img" style="background-image: url(/humg-dashboard/admin/assets/img/avatar.jpg)"></div>

                <button type="submit" name="logout" class="btn-grad">
                    <span class="las la-power-off"></span>
                    <span>Logout</span>
                </button>
            </form>
        </div>
    </div>
</header>