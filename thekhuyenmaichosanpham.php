<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Thêm khuyến mãi</title>
    <link rel="stylesheet" type="text/css" href="css/themseri.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
</head>

<body>
    <?php if(isset($_GET['ma'])){ ?>
    <form action="server.php" method="post">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Thêm khuyến mãi cho sản phẩm</h1>

                    <div class="km">
                        <input type="text" name="khuyenmaisp-ma" value="<?php echo $_GET['ma'] ?>" hidden>
                        <select name="khuyenmaisp-loaikm" class="inputText" required>
                            <option>Vui lòng chọn khuyến mãi</option>
                            <?php 
                            date_default_timezone_set("Asia/Ho_Chi_Minh");
                            $connect = new mysqli("localhost", "root", "", "mobile");
                            mysqli_set_charset($connect, "utf8");
                            $query = "SELECT * FROM `khuyen mai` WHERE `tg ket thuc` >'".date('Y-m-d')." 00:00:00';";
                            $datasql = mysqli_query($connect, $query);
                            while ($row = mysqli_fetch_array($datasql, 1)) {
                                $data[] = $row;
                            }
                            $connect->close();
                            if(!empty($data))
                                for($i=0;$i<count($data);$i++){
                                echo "<option value=\"".$data[$i]['ma khuyen mai']."\"'>".$data[$i]['ten khuyen mai']."</option>";
                                }
                            ?>
                        </select>
                        <input type="number" class="inputText" required name="khuyenmaisp-km" min="0" max="100" placeholder="Phần trăm khuyến mãi">
                    </div>

                    <input type="submit" class="register-buttton" value="Thêm khuyến mãi" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>

    <?php }?>
</body>

</html>