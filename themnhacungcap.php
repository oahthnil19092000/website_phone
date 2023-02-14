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
        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
        $query = "SELECT * FROM `nha cung cap`";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        $connect->close();
    ?>
</head>

<body>
    <form action="./server.php" method="post">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1><?php if(!empty($_GET)) echo "Sửa nhà cung cấp"; else echo "Thêm nhà cung cấp mới";?></h1>
                    <div class="container">
                        <div class="item2">
                        <input type="text" value="<?php if(!empty($_GET)) echo $_GET['ma']; else echo date('mdHis');?>" name="ncc-ma" hidden>
                            <div class="namekm">
                                <input type="text" name="ncc-name" class="inputText" value="<?php if(!empty($_GET)) echo $_GET['ten'];?>" placeholder="Vui lòng nhập tên nhà cung cấp"
                                    required />

                            </div>
                            <div class="namekm">
                                <input type="text" name="ncc-diachi" class="inputText" value="<?php if(!empty($_GET)) echo $_GET['diachi'];?>" placeholder="Vui lòng nhập địa chỉ nhà cung cấp"
                                    required />

                            </div>
                            
                        </div>
                    </div>

                    <input type="submit" class="register-buttton" value="<?php if(!empty($_GET)) echo "Sửa nhà cung cấp"; else echo "Thêm nhà cung cấp mới";?>" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>