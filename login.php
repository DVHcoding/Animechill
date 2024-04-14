<?php
include('./database/config.php');
session_start();
?>

<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login</title>

        <style>
            * {
                margin: 0;
                padding: 0;
                font-family: sans-serif;
            }

            .hero {
                height: 100%;
                width: 100%;
                background: linear-gradient(rgba(0, 0, 0, 0.4), rgba(0, 0, 0, 0.4)),
                    url('login_image/banner.jpg');
                background-position: center;
                background-size: cover;
                position: absolute;
            }

            .form-box {
                width: 380px;
                height: 480px;
                position: relative;
                margin: 6% auto;
                background: #fff;
                padding: 5px;
                overflow: hidden;
                border-radius: 10px;
            }

            .button-box {
                width: 220px;
                margin: 35px auto;
                position: relative;
                box-shadow: 0 0 20px 9px #ff61241f;
                border-radius: 30px;
            }

            .toggle-btn {
                padding: 10px 30px;
                cursor: pointer;
                background: transparent;
                border: 0;
                outline: none;
                position: relative;
            }

            #btn {
                top: 0;
                left: 0;
                position: absolute;
                width: 110px;
                height: 100%;
                background: linear-gradient(to right, #ff105f, #ffad06);
                border-radius: 30px;
                transition: .5s;
            }

            .social-icons {
                margin: 30px;
                text-align: center;
            }

            .social-icons img {
                width: 30px;
                margin: 0 12px;
                box-shadow: 0 0 20px 0 #7f7f7f3d;
                cursor: pointer;
                border-radius: 50%;
            }

            .input-group {
                top: 180px;
                position: absolute;
                width: 280px;
                transition: .5s;
            }

            .input-field {
                width: 100%;
                padding: 10px 0;
                margin: 5px 0;
                border-left: 0;
                border-top: 0;
                border-right: 0;
                border-bottom: 1px solid #999;
                outline: none;
                background: transparent;
            }

            .submit-btn {
                width: 85%;
                padding: 10px 30px;
                cursor: pointer;
                display: block;
                margin: auto;
                margin-top: 20px;
                border: 0;
                outline: none;
                border-radius: 30px
            }

            .submit-btn:hover {
                background: linear-gradient(to right, #ff105f, #ffad06);
            }

            #login {
                left: 50px;
            }

            #register {
                left: 450px;
            }
        </style>
    </head>

    <body>
        <?php include('./assets/controller/function_frontend.php') ?>

        <div class="hero">

            <div class="form-box">
                <div class="button-box">
                    <div id="btn"></div>
                    <button class="toggle-btn" onclick="login()" ;>Login</button>
                    <button class=" toggle-btn" onclick="register()">Sign-up</button>
                </div>

                <div class="social-icons">
                    <img src="./login_image/fb.png" alt="">
                    <img src="./login_image/tw.png" alt="">
                    <img src="./login_image/gp.png" alt="">
                </div>

                <form action="" method="POST" id="login" class="input-group">
                    <input type="text" class="input-field" name="email" placeholder="Email" required>
                    <input type="password" class="input-field" name="password" placeholder="Enter password" required
                        style="margin-bottom: 15px;">

                    <?php login() ?>
                    <button type="submit" class="submit-btn" name="login">Login</button>
                </form>

                <form action="" method="POST" id="register" class="input-group">
                    <input type="text" class="input-field" name="username" placeholder="Username" required>
                    <input type="email" class="input-field" name="email_register" placeholder="Email" required>
                    <input type="password" class="input-field" name="password_register" placeholder="Enter password"
                        required>

                    <button type="submit" class="submit-btn" name="register">Register</button>
                </form>
            </div>
        </div>

        <script>
            var x = document.getElementById("login");
            var y = document.getElementById("register");
            var z = document.getElementById("btn");

            function register() {
                x.style.left = "-400px";
                y.style.left = "50px";
                z.style.left = "110px";
            }

            function login() {
                x.style.left = "50px";
                y.style.left = "450px";
                z.style.left = "0";
            }

        </script>
    </body>

</html>