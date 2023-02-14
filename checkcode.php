<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Xác nhận</title>
    <link rel="stylesheet" type="text/css" href="css/forgotpws.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
    <?php
    if (session_id() === '') session_start();
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    $_SESSION['errorMessage']="Mã xác thực đã quá hạn";
    header("Refresh:180; url=./");
    
    ?>
</head>

<body>
    <form action="./server.php" method="post">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Xác nhận email</h1>
                    <?php 
                            if(isset($_SESSION['error-saixacthuc'])){
                        ?>
                        <div>Mã xác thực không khớp</div>
                        <?php
                        }?>
                    <div class="email">
                        <input type="number" name="xacthuc-maxt" class="inputText" required />
                        <span class="floating-label">Vui lòng điền mã xác thực</span>
                    </div>

                    <input type="submit" class="register-buttton" value="Xác thực" name="register">
                    <div class="login--button">
                        <a class="btn" data-popup-open="register-popup" href="./server.php?recode=recode">Gửi lại mã xác
                            nhận</a>
                        <button type="button" class="btn" onclick="window.history.back()"> Trở lại</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
</body>

</html>