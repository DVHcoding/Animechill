<?php
include ('./database/config.php');
session_start();
if (isset($_SESSION['user']) && $_SESSION['user'] !== '') {
    $email = $_SESSION['user'][1];
} else {
    echo '<script>location.href="index.php"</script>';
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&family=Roboto:ital,wght@0,100;0,400;0,500;0,700;0,900;1,100&display=swap"
        rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        li {
            list-style: none;
        }

        .momo-box {
            background-color: white;
            width: 100%;
            height: 100vh;
            display: grid;
            place-items: center;
            font-family: 'Poppins', sans-serif;
        }

        .container {
            display: flex;
            align-items: start;
            gap: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .box-left {
            background-color: #f4f4f4;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            display: grid;
            place-items: center;
            padding-block: 1rem;
        }

        .box-right {
            background-color: #f4f4f4;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding-inline: 30px;
            padding-block: 10px;
        }

        .box-right h3 {
            font-size: 15px;
        }

        .box-right p {
            font-size: 13px;
            color: #747171;
            margin-top: 10px;
        }

        .info-item {
            border-bottom: 1px solid #d2caca;
            max-width: 20rem;
        }

        .info-item span {
            font-size: 14px;
        }

        .gemstone {
            width: 1rem;
        }



        .success {
            border: none;
            outline: none;
            background-color: #ff9300;
            padding-block: 5px;
            padding-inline: 9px;
            border-radius: 4px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            margin-top: 20px;
            cursor: pointer;

        }

        .return {
            border: none;
            outline: none;
            background-color: #4949c7;
            padding-block: 5px;
            padding-inline: 9px;
            border-radius: 4px;
            color: #fff;
            font-family: 'Poppins', sans-serif;
            font-weight: 500;
            margin-top: 20px;
            cursor: pointer;
        }

        .success:hover {
            background-color: #cc7f14;
        }

        .box-left h4 {
            font-size: 20px;
            font-weight: 600;
        }

        .box-left p {
            margin-bottom: 20px;
        }

        .box-left img {
            width: 50%;
            border-radius: 10px;
        }

        .box-button {
            display: flex;
            gap: 10px;
            align-items: center;
        }
    </style>
</head>

<body>

    <div class="momo-box">
        <div class="container">
            <div class="box-left">
                <h4>Quét mã QR để thanh toán</h4>
                <p>Sử dụng App Banking hoặc ứng dụng camera hỗ trợ qr code để quét mã</p>
                <img src="./assets/imgs/icons/bank.png" alt="">
            </div>

            <div class="box-right">
                <h3>Thông tin đơn hàng</h3>
                <ul class="info-list">
                    <li class="info-item">
                        <p>Tên chủ tài khoản</p>
                        <span>Đỗ Văn Hùng</span>
                    </li>
                    <li class="info-item">
                        <p>Email khách hàng</p>
                        <span>
                            <?= $email ?>
                        </span>
                    </li>
                    <li class="info-item">
                        <p>Đơn giá</p>
                        <span>10.000đ ~ 10 <img src="./assets/imgs/icons/gemstone.png" alt="gemstone"
                                class="gemstone"></span>
                    </li>
                    <li class="info-item">
                        <p>Lưu ý</p>
                        <span>
                            Xin vui lòng nhập đúng thông tin email khách hàng trong nội dung chuyển khoản
                        </span>
                    </li>
                </ul>

                <a href="index.php">
                    <button class="return">Trang chủ</button>
                </a>
            </div>
        </div>
    </div>


</body>

</html>