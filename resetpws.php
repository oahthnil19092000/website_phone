<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Đổi mật khẩu</title>
    <link rel="stylesheet" type="text/css" href="css/resetpws.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
</head>

<body>
    <form method="POST" action="./server.php">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Đổi mật khẩu</h1>
                    <?php if (session_id() === '') session_start();
                    date_default_timezone_set("Asia/Ho_Chi_Minh");
                            if(isset($_SESSION['error-repass'])){
                        ?>
                        <div>Mật khẩu chưa khớp</div>
                        <?php
                        }?>
                    <div class="email">
                        <input type="text" name="repass" class="inputText" required />
                        <span class="floating-label">Vui lòng nhập mật khẩu mới</span>
                    </div>
                    <div class="email">
                        <input type="text" name="repass2" class="inputText" required />
                        <span class="floating-label">Vui lòng nhập lại mật khẩu mới</span>
                    </div>

                    <input type="submit" class="register-buttton" value="Đổi mật khẩu" name="register">
                    <button type="button" class="register-buttton" onclick="window.location.href='server.php?backtohome=1'"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>