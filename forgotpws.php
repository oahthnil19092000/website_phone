<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Quên mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="css/forgotpws.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
</head>

<body>
    <form action="./server.php" method="post">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Quên mật khẩu</h1>
                    <?php if (session_id() === '') session_start();
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                            if(isset($_SESSION['error-noemail'])){
                        ?>
                        <div>Vui lòng kiểm tra lại email</div>
                        <?php
                        }?>
                    <div class="email">
                        <input type="text" name="quenmatkhau-email" class="inputText" required />
                        <span class="floating-label">Vui lòng điền email</span>
                    </div>

                    <input type="submit" class="register-buttton" value="Gửi mã xác thực" name="register">
                    <div class="login--button">
                        <span>Tiếp tục đăng nhập</span>
                        <a class="btn" data-popup-open="register-popup" href="server.php?dangnhaplai=on">Đăng nhập</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>