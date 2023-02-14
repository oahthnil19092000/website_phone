<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Cập nhật</title>
    <link rel="stylesheet" type="text/css" href="css/themthongtin.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
    <script type="text/javascript" async="" src="./js/loadjson.js"></script>
    <?php
    if (session_id() === '')
    session_start(); 
    $email = $_SESSION['User'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$email."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    if(!empty($data))
    if($data[0]['ma ad'] != "00000"){
        $query = "SELECT * FROM `admin` WHERE `ma ad`='".$data[0]['ma ad']."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data1[] = $row;
        }
    }else {
        $query = "SELECT * FROM `khach hang` WHERE `ma kh`='".$data[0]['ma kh']."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data2[] = $row;
        }
    }
    if(isset($data1))
        $diachi = $data1[0]['dia chi'];
    else if(isset($data2))
        $diachi = $data2[0]['dia chi'];
        if($diachi != ""){
    $tinh = substr($diachi, strrpos($diachi,", ")+2);
    $diachi = str_replace(", ".$tinh, "", $diachi);
    $huyen = substr($diachi, strrpos($diachi,", ")+2);
    $diachi = str_replace(", ".$huyen, "", $diachi);
    $xa = substr($diachi, strrpos($diachi,", ")+2);
    $diachi = str_replace(", ".$xa, "", $diachi);
    }
    ?>
</head>

<body>
    <form action="./server.php" method="post">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Cập nhật thông tin người dùng</h1>
                    <div class="container">
                        <div class="item1">
                            <div class="namekh">
                                <input type="text" name="thongtinnd-name" class="inputText" placeholder="Vui lòng nhập tên" value="<?php if(isset($data1)) echo $data1[0]['ho ten ad']; else if(isset($data2)) echo $data2[0]['ho ten kh']; ?>" required />

                            </div>
                            <div class="ngaysinh">
                                <input type="date" name="thongtinnd-ngaysinh" class="inputText" value="<?php if(isset($data1)) echo $data1[0]['ngay sinh']; else if(isset($data2)) echo $data2[0]['ngay sinh kh']; ?>" required />

                            </div>
                            <div class="cmnd">
                                <input type="number" class="inputText" name="thongtinnd-cmnd" placeholder="Vui lòng nhập CMND/CCCD" value="<?php if(isset($data1)) echo $data1[0]['cmnd']; else if(isset($data2)) echo $data2[0]['cmnd']; ?>" required />

                            </div>
                            <div class="tel">
                                <input type="tel" class="inputText" name="thongtinnd-tel" placeholder="Vui lòng nhập số điện thoại" value="<?php if(isset($data1)) echo $data1[0]['so dien thoai']; else if(isset($data2)) echo $data2[0]['sdt']; ?>" required />

                            </div>
                        </div>
                        <div class="item2">
                            <div class="diachi">
                                <input type="text" class="inputText" name="thongtinnd-diachicuthe" id="diachi"
                                    placeholder="Vui lòng nhập Số nhà, Hẻm , Đường" value="<?php echo $diachi ?>" required />

                            </div>
                            <div class="tinh">
                                <select class="inputText" id="tinh" required>
                                    <option value="0000"><?php if(isset($tinh)) echo $tinh; else echo "Vui lòng chọn tỉnh thành phố";?></option>
                                </select>
                            </div>
                            <div class="huyen">
                                <select class="inputText" id="huyen" required>
                                    <option value="0000"><?php if(isset($huyen)) echo $huyen; else echo "Vui lòng chọn quận huyện";?></option>
                                </select>
                            </div>
                            <div class="xa">
                                <select class="inputText" id="xa" name="thongtinnd-diachi3cap" required>
                                    <option value="<?php if(isset($xa)) echo $xa.", ".$huyen.", ".$tinh; else echo "0000" ?>"><?php if(isset($xa)) echo $xa; else echo "Vui lòng chọn xã phường thị trấn" ?></option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <input type="submit" class="register-buttton" value="Cập nhật thông tin" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                    
                </div>
            </div>
        </div>
    </form>
</body>

</html>