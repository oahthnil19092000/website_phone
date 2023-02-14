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
                    <h1><?php if(!empty($_GET)) echo "Sửa loại sản phẩm"; else echo "Thêm loại sản phẩm mới";?></h1>
                    <div class="container">
                        <div class="item2">
                        <input type="text" value="<?php if(!empty($_GET)) echo $_GET['ma']; else echo date('mdHis');?>" name="loaisp-ma" hidden>
                            <div class="namekm">
                                <input type="text" name="loaisp-name" class="inputText" value="<?php if(!empty($_GET)) echo $_GET['ten'];?>" placeholder="Vui lòng nhập tên loại sản phẩm"
                                    required />

                            </div>
                            <div class="namekm">
                                <select name="loaisp-mancc" class="inputText" required>
                                    <option value="<?php if(!empty($_GET)) echo $_GET['ncc'];?>"><?php if(!empty($_GET)) echo $_GET['tenncc']; else echo "Chọn nhà cung cấp"?></option>
                                    <?php
                                    for($i = 0 ; $i < count($data) ; $i++){
                                        echo "<option value=\"".$data[$i]['ma ncc']."\">".$data[$i]['ten ncc']."</option>";
                                    }
                                    ?>
                                </select>
                            </div>
                            
                        </div>
                    </div>

                    <input type="submit" class="register-buttton" value="<?php if(!empty($_GET)) echo "Sửa loại sản phẩm"; else echo "Thêm loại sản phẩm mới";?>" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>