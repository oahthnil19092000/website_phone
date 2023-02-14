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
    if (isset($_GET['xemhoadon'])){
        $tongsotien = 0;
        $tongtienkhuyenmai = 0;
        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
        $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' AND `so hd`='".$_GET['xemhoadon']."') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        $query = "SELECT * FROM `admin` WHERE `ma ad`='".$data[0]['ma ad']."'";
        $datasql = mysqli_query($connect, $query);
        unset($data3);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data3[] = $row;
        }
    ?>
    <style>
        body{
            
        }
        #page{
            height: 100%;
            width: 80%;
            margin: 0 auto;
        }
        td{
            text-align: center;
        }
    </style>
</head>
<!--  -->

<body onclick="window.history.back();">
    <div id="page">
        
        <div class="title">
            <h3>ĐƠN HÀNG SỐ <?php echo $_GET['xemhoadon']?></h3>
            -------oOo-------
        </div>
        <div class="thongtincoban">
            <div><b>Mã hóa đơn: </b><?php echo $_GET['xemhoadon']?></div>
            <div><b>Họ tên khách hàng: </b><?php echo $data[0]['ho ten kh']?></div>
            <div><b>Ngày lập hóa đơn: </b><?php $date=date_create($data[0]['ngay lap']); echo "Ngày ".date_format($date,"d").", tháng ".date_format($date,"m").", năm ".date_format($date,"Y")."."; ?></div>
            <div><b>Người duyệt: </b><?php if(!empty($data3[0]['ho ten ad'])) echo $data3[0]['ho ten ad']; else echo ""; ?></div>
            <div><b>Tình trạng đơn hàng: </b>
                    <?php
                        if($data[0]['tinh trang']=='1') 
                            echo "Đặt hàng";
                        else if($data[0]['tinh trang']=='2')
                            echo "Đang giao hàng";
                        else if($data[0]['tinh trang']=='3')
                            echo "Đã giao hàng";
                        else if($data[0]['tinh trang']=='4')
                            echo "Đã hủy";
                        else echo "chưa đặt :))";
                    ?>
            </div>
        </div>
        <br />
        <table class="TableData">
            <tr>
                <th>STT</th>
                <th>Seri sản phẩm</th>
                <th>Hình sản phẩm</th>
                <th>Tên</th>
                <th>Đơn giá</th>
                <th>Số lượng</th>
                <th>Thành tiền</th>
                <th>Khuyến mãi</th>

            </tr>
            <?php
            
                

                for($i=0; $i<  count($data); $i++){
                    $query = "SELECT b.*, `ten khuyen mai`, `tg bat dau`, `tg ket thuc` FROM `khuyen mai` a JOIN `chi tiet khuyen mai` b ON (a.`ma khuyen mai` = b.`ma khuyen mai`) WHERE `ma sp`='".$data[$i]['ma sp']."' AND `tg ket thuc` >= '".date('Y-m-d 00:00:00')."'";
                    $datasql = mysqli_query($connect, $query);
                    unset($data2);
                    while ($row = mysqli_fetch_array($datasql, 1)) {
                        $data2[] = $row;
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
                    $tongsotien += $data[$i]['so luong']*$data[$i]['gia sp'];
                    $tongtienkhuyenmai += $data[$i]['so luong']*$data[$i]['gia sp']*$max/100;     
                ?>
            <tr>
                <td><?php echo $i+1;  ?></td>
                <td><?php 
                $query = "SELECT * FROM `san pham cu the` a JOIN `phieu bao hanh` b ON (a.`so seri`=b.`so seri`) WHERE `so hd`='".$_GET['xemhoadon']."' AND `ma sp`='".$data[$i]['ma sp']."'";
                $datasql = mysqli_query($connect, $query);
                unset($data5);
                while ($row = mysqli_fetch_array($datasql, 1)) {
                    $data5[] = $row;
                }
                if(!empty($data5)){
                    for($j=0;$j<count($data5);$j++){
                        if(count($data5)==1){
                            echo $data5[$j]['so seri'];
                        }
                        else{
                            echo $data5[$j]['so seri']."<br>";
                        }
                    }
                }
                ?></td>
                <td>
                    <img src="<?php echo  $data[$i]['hinh anh']; ?>" style="height:70px">
                </td>
                <td><?php echo  $data[$i]['ten sp']; ?></td>
                <td><?php echo  number_format(($data[$i]['gia sp']), 0, ",", "."); ?></td>
                <td><?php echo  $data[$i]['so luong']; ?></td>
                <td><?php echo  number_format(($data[$i]['so luong']*$data[$i]['gia sp']), 0, ",", ".")." ₫"; ?></td>
                <td><?php echo $max."%";?></td>
            </tr>
            <?php
                    
                }
                $connect->close();
                
            }
            ?>
            <tr>
                <td colspan="7" class="tong">Thành tiền</td>
                <td class="cotSo"><?php echo number_format(($tongsotien), 0, ",", ".")." ₫" ?></td>
            </tr>
            <tr>
                <td colspan="7" class="tong">Khuyến mãi</td>
                <td class="cotSo"><?php echo number_format(($tongtienkhuyenmai), 0, ",", ".")." ₫" ?></td>
            </tr>
            <tr>
                <td colspan="7" class="tong">Tổng cộng</td>
                <td class="cotSo"><?php echo number_format(($tongsotien-$tongtienkhuyenmai), 0, ",", ".")." ₫" ?></td>
            </tr>
        </table>
        
    </div>
</body>

</html>