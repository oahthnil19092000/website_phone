<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/index.css">
    <link rel="icon" href="../img/logo2.png">
    <title>Thảo Linh Moblie</title>
</head>
<!--  -->

<body onload="window.print()" onclick="window.history.back();">
    <div id="page" class="page">
        <div class="header">
            <div class="logo"><img src="../img/logo2.png" style="border-radius:50px"/></div>
            <div class="company" style="color:#047baa;"><b>CỬA HÀNG ĐIỆN THOẠI DI ĐỘNG<BR>THẢO LINH</b></div>
        </div>
        <br />
        <div class="title">
            <h3>HÓA ĐƠN THANH TOÁN</h3>
            -------oOo-------
        </div>
        <br />
        <br />
        <table class="TableData">
            <tr>
                <th>STT</th>
                <th>Tên</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
            </tr>
            <?php
            session_start();
            date_default_timezone_set("Asia/Ho_Chi_Minh");
            if (isset($_GET['inhoadon'])){
                $tongsotien = 0;
                $tongtienkhuyenmai = 0;
                $connect = new mysqli("localhost", "root", "", "mobile");
                mysqli_set_charset($connect, "utf8");
                $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' AND `so hd`='".$_GET['inhoadon']."') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
                $datasql = mysqli_query($connect, $query);
                while ($row = mysqli_fetch_array($datasql, 1)) {
                    $data[] = $row;
                }
                

                for($i=0; $i<  count($data); $i++){
                    $query = "SELECT b.*, `ten khuyen mai`, `tg bat dau`, `tg ket thuc` FROM `khuyen mai` a JOIN `chi tiet khuyen mai` b ON (a.`ma khuyen mai` = b.`ma khuyen mai`) WHERE `ma sp`='".$data[$i]['ma sp']."' AND `tg ket thuc` >= '".date('Y-m-d 00:00:00')."'";
                    $datasql = mysqli_query($connect, $query);
                    unset($data2);
                    while ($row = mysqli_fetch_array($datasql, 1)) {
                        $data2[] = $row;
                    }
                    $query = "SELECT * FROM `admin` WHERE `ma ad`='".$data[0]['ma ad']."'";
                    $datasql = mysqli_query($connect, $query);
                    unset($data3);
                    while ($row = mysqli_fetch_array($datasql, 1)) {
                        $data3[] = $row;
                    }
                    $max = 0;
                    $pos = -1;
                    if(!empty($data2)) {
                        for($j=0;$j<count($data2);$j++){
                            if($max < $data2[$j]['phan tram khuyen mai']){
                                $max = $data2[$j]['phan tram khuyen mai'];
                            }
                        }
                    }     
                ?>
            <tr>
                <td><?php echo $i+1;  ?></td>
                <td><?php echo  $data[$i]['ten sp']; ?></td>
                <td><?php echo  number_format(($data[$i]['gia sp']), 0, ",", "."); ?></td>
                <td><?php echo  $data[$i]['so luong']; ?></td>
                <td><?php echo  number_format(($data[$i]['so luong']*$data[$i]['gia sp']), 0, ",", ".")." ₫"; ?></td>
            </tr>
            <?php
                    $tongsotien += $data[$i]['so luong']*$data[$i]['gia sp'];
                    $tongtienkhuyenmai += $data[$i]['so luong']*$data[$i]['gia sp']*$max/100;
                }
                $connect->close();
                $date=date_create($data[0]['ngay lap']);
            }
            ?>
            <tr>
                <td colspan="4" class="tong">Thành tiền</td>
                <td class="cotSo"><?php echo number_format(($tongsotien), 0, ",", ".")." ₫" ?></td>
            </tr>
            <tr>
                <td colspan="4" class="tong">Khuyến mãi</td>
                <td class="cotSo"><?php echo number_format(($tongtienkhuyenmai), 0, ",", ".")." ₫" ?></td>
            </tr>
            <tr>
                <td colspan="4" class="tong">Tổng cộng</td>
                <td class="cotSo"><?php echo number_format(($tongsotien-$tongtienkhuyenmai), 0, ",", ".")." ₫" ?></td>
            </tr>
        </table>
        <div class="footer-left"> <br />
            Khách hàng <br> <br> <br> <br> <br> <?php echo $data[0]['ho ten kh'] ?></div>
        <div class="footer-right"> Cần thơ, ngày <?php echo date_format($date,"d"); ?> tháng
            <?php echo date_format($date,"m"); ?> năm <?php echo date_format($date,"Y"); ?><br />
            Nhân viên <br> <br> <br> <br> <br> <?php if(!empty($data3[0]['ho ten ad'])) echo $data3[0]['ho ten ad']; else echo "ADMIN"; ?></div>
    </div>
</body>

</html>