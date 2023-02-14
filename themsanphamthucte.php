<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Thêm Seri</title>
    <link rel="stylesheet" type="text/css" href="css/themseri.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
    <?php if (session_id() === '')
        session_start(); 
        if(isset($_SESSION['admin']) && isset($_POST['themspthucte-seri'])){
            $masp = $_POST['themspthucte-masp'];
            $seri = $_POST['themspthucte-seri'];
            $connect = new mysqli("localhost", "root", "", "mobile");
            mysqli_set_charset($connect, "utf8");
            $query = "SELECT * FROM `san pham` a JOIN `loai san pham` b ON (a.`ma loai sp`=b.`ma loai sp`) WHERE `ma sp`='".$masp."'";
            $datasql = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            } 
            $query = "SELECT * FROM `san pham cu the` WHERE `so seri`='".$seri."'";
            $datasql = mysqli_query($connect, $query);
            if(mysqli_num_rows($datasql)==0){
                $query = "INSERT INTO `san pham cu the`(`so seri`, `ma sp`) VALUES ('".$seri."','".$masp."')";
                mysqli_query($connect, $query);
                $query = "INSERT INTO `phieu bao hanh`(`ma bao hanh`, `so hd`, `so seri`, `ten bao hanh`, `ngay bao hanh`) VALUES ('".date("mdHis")."','0','".$seri."','Bảo hành ".$data[0]['ten loai sp']."','')";
                mysqli_query($connect, $query);
            }
            $connect->close();
        }
    ?>
</head>

<body>
    <form action="" method="POST">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Thêm sản phẩm thực tế</h1>

                    <div class="seri">
                        <input type="text" name="themspthucte-seri" class="inputText" placeholder="Vui lòng nhập seri" required />
                        <input type="text" name="themspthucte-masp" value='<?php echo $_SESSION['spcuthe']?>' hidden>
                    </div>
                    <div class="action">
                        <input type="submit" class="register-buttton" value="Thêm Seri" name="register">
                        <input type="button" class="register-buttton1" value="Trở về" onclick="window.location.href='server.php?troveqlsp=on'">
                        
                    </div>
                    
                </div>
            </div>
        </div>
    </form>
</body>

</html>