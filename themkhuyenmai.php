<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Thêm khuyến mãi</title>
    <link rel="stylesheet" type="text/css" href="css/khuyenmai.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
    <?php if (session_id() === '')
        session_start(); 
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        if(!empty($_GET)){
            $ma = $_GET['ma'];
            $ten = $_GET['ten'];
            $bd = $_GET['bd'];
            $kt = $_GET['kt'];
        }
    ?>
</head>

<body>
    <form action="./server.php" method="post">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1><?php if(!empty($_GET)){ echo "Sửa chương trình khuyến mãi"; } else echo "Thêm khuyến mãi mới";?></h1>
                    <div class="container">
                        <div class="item2">
                        <input type="text" value="<?php if(!empty($_GET)){ echo $ma; } else echo date('dHis');?>" name="khuyenmaisp-makm" hidden>
                            <div class="namekm">
                                <input type="text" name="khuyenmaisp-namekm" value="<?php if(!empty($_GET)){ echo $ten; } ?>" class="inputText" placeholder="Vui lòng nhập tên khuyến mãi"
                                    required />

                            </div>
                            <div class="ngaybatdau">
                                <label>
                                    <span class="inputText1">Ngày bắt đầu</span>
                                    <input type="date" value="<?php if(!empty($_GET)){ echo $bd; } ?>" name="khuyenmaisp-bdkm" class="inputText" required />
                                </label>
                            </div>
                            <div class="ngayketthuuc">
                                <label>
                                    <span class="inputText1">Ngày kết thúc</span>
                                    <input type="date" value="<?php if(!empty($_GET)){ echo $kt; } ?>" name="khuyenmaisp-ktkm" class="inputText" required />
                                </label>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="register-buttton" value="<?php if(!empty($_GET)){ echo "Sửa khuyến mãi"; } else echo "Thêm khuyến mãi mới";?>" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>