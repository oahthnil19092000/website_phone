<?php
    ob_start();
    session_start();
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Thông tin thanh toán</title>
        <!-- Bootstrap core CSS -->
        <link href="/thanhtoanvpay/assets/bootstrap.min.css" rel="stylesheet"/>
        <!-- Custom styles for this template -->
        <link href="/thanhtoanvpay/assets/jumbotron-narrow.css" rel="stylesheet">         
        <script src="/thanhtoanvpay/assets/jquery-1.11.3.min.js"></script>
    </head>
    <style>
    @import url(https://fonts.googleapis.com/css?family=Lato:400,300,700);
    body,html {
    height:100%;
    margin:0;
    font-family:lato;
    }
    
    .container {
    height:100%;
    -webkit-box-pack:center;
    -webkit-justify-content:center;
        -ms-flex-pack:center;
            justify-content:center;
    -webkit-box-align:center;
    -webkit-align-items:center;
        -ms-flex-align:center;
            align-items:center;
    display:-webkit-box;
    display:-webkit-flex;
    display:-ms-flexbox;
    display:flex;
    background:-webkit-linear-gradient(#c5e5e5, #ccddf9);
    background:linear-gradient(#c9e5e9,#ccddf9);
    }
    .form-group{
        padding:5px 10px;
    }
    .window {
    width:500px;
    background:#fff;
    display:-webkit-box;
    display:-webkit-flex;
    display:-ms-flexbox;
    display:flex;
    flex-direction: column;
    box-shadow: 0px 15px 50px 10px rgba(0, 0, 0, 0.2);
    border-radius:30px;
    z-index:10;
    }
    .window >div, footer{
        padding: 20px;
    }
    footer{
        display: flex;
    }
    footer p{
        margin: auto;
    }
    button{
        background-color: #ff5d92;;
        color: white;
        padding: 14px 20px;
        margin: 8px 0;
        border: none;
        cursor: pointer;
        width: 100%;
        border-radius: 10px;
    }
    button:hover {
        opacity: 0.8;
    }
    .header{
        display: flex;
    }
    h1{
        color: #047baa;
        margin: auto;
    }
    .a1{
        font-weight:bold;
        color:  #ff5d92;;
    }
</style>
    <body>
        <?php
        require_once("./config.php");
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHashType']);
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $i = 0;
        $hashData = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashData = $hashData . '&' . $key . "=" . $value;
            } else {
                $hashData = $hashData . $key . "=" . $value;
                $i = 1;
            }
        }

        //$secureHash = md5($vnp_HashSecret . $hashData);
		$secureHash = hash('sha256',$vnp_HashSecret . $hashData);
        ?>
        <!--Begin display -->
        <div class="container">   
            <div class='window'>
                <div class="header clearfix">
                    <h1 class="text-muted">Thông tin thanh toán</h1>
                </div>
                <div class="table-responsive">
                    <div class="form-group">
                        <label class="a1">Mã đơn hàng:</label>
                        
                        <label><?php echo $_GET['vnp_TxnRef'] ?></label>
                    </div>    
                    <div class="form-group">

                        <label class="a1">Số tiền:</label>
                        <label><?=number_format($_GET['vnp_Amount']/100) ?> VNĐ</label>
                    </div>  
                    <div class="form-group">
                        <label class="a1">Nội dung thanh toán:</label>
                        <label><?php echo $_GET['vnp_OrderInfo'] ?></label>
                    </div> 
                    <div class="form-group">
                        <label class="a1">Mã phản hồi (vnp_ResponseCode):</label>
                        <label><?php echo $_GET['vnp_ResponseCode'] ?></label>
                    </div> 
                    <div class="form-group">
                        <label class="a1">Mã GD Tại VNPAY:</label>
                        <label><?php echo $_GET['vnp_TransactionNo'] ?></label>
                    </div> 
                    <div class="form-group">
                        <label class="a1">Mã Ngân hàng:</label>
                        <label><?php echo $_GET['vnp_BankCode'] ?></label>
                    </div> 
                    <div class="form-group">
                        <label class="a1">Thời gian thanh toán:</label>
                        <label><?php echo $_GET['vnp_PayDate'] ?></label>
                    </div> 
                    <div class="form-group">
                        <label class="a1">Kết quả:</label>
                        <label>
                            <?php
                            if ($secureHash == $vnp_SecureHash) {
                                if ($_GET['vnp_ResponseCode'] == '00') {
                                    $order_id = $_GET['vnp_TxnRef'];
                                    $money = $_GET['vnp_Amount']/100;
                                    $note = $_GET['vnp_OrderInfo'];
                                    $vnp_response_code = $_GET['vnp_ResponseCode'];
                                    $code_vnpay = $_GET['vnp_TransactionNo'];
                                    $code_bank = $_GET['vnp_BankCode'];
                                    $time = $_GET['vnp_PayDate'];
                                    $date_time = substr($time, 0, 4) . '-' . substr($time, 4, 2) . '-' . substr($time, 6, 2) . ' ' . substr($time, 8, 2) . ' ' . substr($time, 10, 2) . ' ' . substr($time, 12, 2);
                                    // include("../code/modules/kndatabase.php");
                                    $connect = new mysqli("localhost","root","","mobile");
                                    mysqli_set_charset($connect,"utf8");
                                    $taikhoan = $_SESSION['User'];
                                    $sql = "SELECT * FROM payments WHERE order_id = '$order_id'";
                                    $query = mysqli_query($connect, $sql);
                                    $row = mysqli_num_rows($query);
                                    $sql = "SELECT * FROM `hoa don` WHERE `so hd` = '".$order_id."'";
                                    $query = mysqli_query($connect, $sql);
                                    while ($row = mysqli_fetch_array($query, 1)) {
                                        $data[] = $row;
                                    }
                                    
                                        $sql = "UPDATE `gio hang` SET `tinh trang`='1' WHERE `ma gh`='".$data[0]['ma gh']."'";
                                        mysqli_query($connect, $sql);
                                    if ($row > 0) {
                                        $sql = "UPDATE payments SET order_id = '$order_id', money = '$money', note = '$note', vnp_response_code = '$vnp_response_code', code_vnpay = '$code_vnpay', code_bank = '$code_bank' WHERE order_id = '$order_id'";
                                        mysqli_query($connect, $sql);
                                    } else {
                                        $sql = "INSERT INTO payments(order_id, thanh_vien, money, note, vnp_response_code, code_vnpay, code_bank, time) VALUES ('$order_id', '$taikhoan', '$money', '$note', '$vnp_response_code', '$code_vnpay', '$code_bank','$date_time')";
                                        mysqli_query($connect, $sql);
                                    }
                                    echo "GD Thanh cong";
                                } else {
                                    echo "GD Khong thanh cong";
                                }
                            } else {
                                echo "Chu ky khong hop le";
                            }
                            ?>

                        </label>
                        <br>
                        <a href="../">
                            <button>Quay lại</button>
                        </a>
                    </div> 
                </div>
                <p>
                    &nbsp;
                </p>
                <footer class="footer">
                    <p>&copy; Quản lý Tiếng Anh 2020</p>
                </footer>
            </div>
        </div>  
    </body>
</html>
