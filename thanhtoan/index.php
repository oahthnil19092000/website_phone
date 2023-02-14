<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mobile Thảo Linh | Thanh toán</title>
    <link rel="icon" href="../img/logo2.png">
    <link rel="stylesheet" href="css/thanhtoan.css">
</head>
<body>
    <?php
    if (session_id() === '')
    session_start(); 
    date_default_timezone_set("Asia/Ho_Chi_Minh");
if (isset($_GET['thanhtoan'])) {
    $uname = $_SESSION['User'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$uname."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data1[] = $row;
    }
    $query = "SELECT * FROM `khach hang` WHERE `ma kh`='".$data1[0]['ma kh']."'";
    $datasql = mysqli_query($connect, $query);
    unset($data1);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data1[] = $row;
    }
    $connect->close();
    $diachi = $data1[0]['dia chi'];
    $sdt = $data1[0]['sdt'];
    $dc = explode(", ",$diachi);
    $dc1 = $dc[count($dc)-3].", ".$dc[count($dc)-2].", ".$dc[count($dc)-1];
    $dc2 = str_replace(", ".$dc1,"",$diachi);
                ?>

                <div class="thanhtoan modal" style="display:block" >
                    <span onclick="window.location.href='../'" class="close" title="Close Modal">&times;</span>
                    <form method="POST" action="../server.php" class="modal-content animate">
                        <div class="container">
                            <h1>Đặt hàng</h1>
                            <div class="diachi">
                                <input type="text" name="mahd" value="<?php echo $_GET['thanhtoan'] ?>" style="display:none" />
                                <label>Địa chỉ (Số nhà, ấp / Số nhà, đường, khu):
                                    <input type="text" name="sonha" placeholder="Vui lòng nhập địa chỉ" value="<?php echo $dc2?>" required />
                                </label>
                                <select id="tinh_tp1" name="tinh_tp" required>
                                    <option><?php echo $dc[count($dc)-1]?></option>
                                </select>
                                <select id="quan_huyen1" name="quan_huyen" required>
                                    <option><?php echo $dc[count($dc)-2]?></option>
                                </select>
                                <select id="xa_phuong1" name="xa_phuong" required>
                                    <option value="<?php echo $dc1?>"><?php echo $dc[count($dc)-3]?></option>
                                </select>
                            </div>
                            <div class="sodienthoai">
                                <label>
                                    Số điện thoại :
                                    <input type="tel" value="<?php echo $sdt?>" id="sdtdathang" name="sdtdathang" placeholder="Vui lòng nhập số điện thoại" title="Số điện thoại" pattern="[0]{1}[0-9]{3}[0-9]{3}[0-9]{3}" required />
                                </label>

                            </div>
                            <div class="hinhthucthanhtoan">
                                <h4>Hình thức thanh toán</h4>
                                <input type="radio" id="tienmat" name="hinhthuc" value="0" checked hidden>
                                <input type="radio" id="vnpay" name="hinhthuc" value="1" hidden>
                                <div>
                                    <div class="thanhtoantienmat" onclick="tienmat.checked=true">

                                    </div>
                                    <div class="thanhtoanvnpay" onclick="vnpay.checked=true">

                                    </div>
                                </div>
                                
                            </div>
                            <div class="btn">
                                <button type="submit">Thanh toán</button>
                            </div>
                        </div>
                    </form>
                </div>
                <script>
                    const xhr = new XMLHttpRequest();
                    xhr.open('GET', '../json/tinh_tp.json');
                    xhr.responseType = 'json';
                    xhr.onload = function(e) {
                        if (this.status == 200) {
                            var newContent = '';
                            for (var i in this.response) {
                                newContent += '<option class="event" value="';
                                newContent += this.response[i].code;
                                newContent += '">';
                                newContent += this.response[i].name_with_type;
                                newContent += '</option>';
                            }
                            document.getElementById('tinh_tp1').innerHTML += newContent;
                        }
                    };
                    xhr.send();

                    document.getElementById('tinh_tp1').onchange = function() {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', '../json/quan-huyen/' + this.value + '.json');
                        xhr.responseType = 'json';
                        xhr.onload = function(e) {
                            if (this.status == 200) {
                                var newContent = '';
                                for (var i in this.response) {
                                    newContent += '<option class="event" value="';
                                    newContent += this.response[i].code;
                                    newContent += '">';
                                    newContent += this.response[i].name_with_type;
                                    newContent += '</option>';
                                }
                                document.getElementById('quan_huyen1').innerHTML = newContent;
                            }
                        };
                        xhr.send();
                    }
                    document.getElementById('quan_huyen1').onchange = function() {
                        const xhr = new XMLHttpRequest();
                        xhr.open('GET', '../json/xa-phuong/' + this.value + '.json');
                        xhr.responseType = 'json';
                        xhr.onload = function(e) {
                            if (this.status == 200) {
                                var newContent = '';
                                for (var i in this.response) {
                                    newContent += '<option class="event" value="';
                                    newContent += this.response[i].path_with_type;
                                    newContent += '">';
                                    newContent += this.response[i].name_with_type;
                                    newContent += '</option>';
                                }
                                document.getElementById('xa_phuong1').innerHTML = newContent;
                            }
                        };
                        xhr.send();
                    }
                </script>
            <?php } ?>
</body>
</html>