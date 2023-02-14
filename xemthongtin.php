<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="inhoadon/css/index.css">
    <link rel="icon" href="./img/logo2.png">
    <title>Thảo Linh Moblie</title>
    <?php 
    session_start();
    date_default_timezone_set("Asia/Ho_Chi_Minh");
    if (isset($_GET['ma'])){
        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
        $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$_GET['ma']."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        $user=$data[0]['use name'];
        $pass=$data[0]['password'];
        if($data[0]['ma ad']=="00000"){
            $query = "SELECT * FROM `khach hang` WHERE `ma kh`='".$data[0]['ma kh']."'";
            $datasql = mysqli_query($connect, $query);
            unset($data);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            }
            $ma = $data[0]['ma kh'];
            $ten = $data[0]['ho ten kh'];
            $ngaysinh = $data[0]['ngay sinh kh'];
            $diachi = $data[0]['dia chi'];
            $sdt = $data[0]['sdt'];
            $cmnd = $data[0]['cmnd'];
        } else {
            $query = "SELECT * FROM `admin` WHERE `ma ad`='".$data[0]['ma ad']."'";
            $datasql = mysqli_query($connect, $query);
            unset($data);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            }
            $ma = $data[0]['ma ad'];
            $ten = $data[0]['ho ten ad'];
            $ngaysinh = $data[0]['ngay sinh'];
            $diachi = $data[0]['dia chi'];
            $sdt = $data[0]['so dien thoai'];
            $cmnd = $data[0]['cmnd'];
        }
        $connect->close();
    ?>
        <style>
            body{
                display: flex;
                justify-content: center;
                align-items: center;
                height: 620px;
            }
            .page {
                width: 80%;
                margin: 0 auto;
                min-height: 0;
                border-radius:30px;
            }
            .thongtincoban > div{
                padding: 5px;
            }
        </style>
</head>
<!--  -->

<body onclick="window.history.back();">
    <div class="page">
        
        <div class="title">
            <h3>XEM THÔNG TIN</h3>
            -------oOo-------
        </div>
        <div class="thongtincoban">
            <div><b>Mã người dùng: </b><?php echo $ma?></div>
            <div><b>Tài khoản: </b><?php echo $user?></div>
            <div><b>Mật khẩu: </b><?php  echo $pass ?></div>
            <div><b>Họ tên: </b><?php echo $ten ?></div>
            <div><b>Ngày sinh: </b><?php echo $ngaysinh ?></div>
            <div><b>CMND/ CCCD: </b><?php echo $cmnd ?></div>
            <div><b>Số điện thoại: </b><?php echo $sdt ?></div>
            <div><b>Địa chỉ: </b><?php echo $diachi ?></div>
        </div>
        
    </div>
</body>
    <?php }?>
</html>