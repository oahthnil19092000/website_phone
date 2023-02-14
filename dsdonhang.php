<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moblie Thảo Linh | Trang chủ</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="stylesheet" href="css/sanpham.css">
    <link rel="icon" href="img/logo2.png">
    <link rel="stylesheet" href="css/dsdonhang.css">
    <script src="js/home.js"></script>
    <?php if (session_id() === '')
        session_start();
        error_reporting(0);
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        function counthd($a, $c){
            $count=0;
            for($i=0;$i<=count($a);$i++){
                if($a[$i]['so hd'].""==$c){
                    $count++;
                }
            }
            echo $count;
        }
    if(isset($_SESSION['errorMessage'])){
        echo "<script type='text/javascript'>
            alert('" . $_SESSION['errorMessage'] . "');
          </script>";
          unset($_SESSION['errorMessage']);
    }    
    ?>

</head>
<?php
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $tongsotien = 0;
    $tongtienkhuyenmai = 0;
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$_SESSION['User']."' AND `ma ad`='00000'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data3[] = $row;
    }
    $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`='".$data3[0]['ma kh']."') b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`!='0') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $connect->close();
?>

<body style="margin: 0;">
    <div class="app">
        <header class="header">
            <div class="grid">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./<?php if(isset($_SESSION['admin'])) echo "admin/quanlysanpham.php"?>" class="header__logo-link">
                            <img src="./img/logo2.png" alt="logo" class="logo-img">
                        </a>
                        <a href="./<?php if(isset($_SESSION['admin'])) echo "admin/"?>" class="header__logo-name-link">
                            <h3 class="logo-name">THẢO LINH MOBILE</h3>
                        </a>

                    </div>
                    <form method="get" class="header_search">
                        <div class="header_search-input-wrap">
                            <input required type="search" name="searchsp" autocomplete="off" class="header_search-input" style="width:98%" placeholder="Tìm kiếm sản phẩm">
                            <div class="header_search-history">
                                <h4 class="header_search-history-heading">Lịch sử tìm kiếm</h4>
                                <ul class="header_search-history-list">
                                    <?php if(isset($_SESSION['tmp'])){
                                        for($i=0; $i < $_SESSION['tmp']; $i++){
                                            ?>
                                                <li class="header_search-history-item">
                                                    <a href="?searchsp=<?php echo $_SESSION['dasearch'.$i]; ?>"><?php echo $_SESSION['dasearch'.$i]; ?></a>
                                                    <a href="server.php?xoatimkiem=<?php echo $i; ?>" class="xoatimkiem">x</a>
                                                </li>
                                            <?php
                                        }
                                    } ?>
                                </ul>
                            </div>
                        </div>
                        <button type="submit" class="header_search-btn">
                            <i class="header_search-btn-icon fas fa-search"></i>
                        </button>
                    </form>
                    <div class="header_cart">
                        <div class="header_cart-wrap">
                            <?php  
                            if(isset($_SESSION['User']))
                            $email = $_SESSION['User'];
                            else $email="";
                            $connect = new mysqli("localhost", "root", "", "mobile");
                            mysqli_set_charset($connect, "utf8");
                            $query = "SELECT `ma kh` FROM `tai khoan` WHERE `use name`='".$email."'";
                            $datasql = mysqli_query($connect, $query);
                            unset($data6);
                            while ($row = mysqli_fetch_array($datasql, 1)) {
                                $data6[] = $row;
                            }
                            if(!empty($data6)){
                                $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `ma kh`='".$data6[0]['ma kh']."' AND `tinh trang`='0'";
                                $datasql = mysqli_query($connect, $query);
                                if(mysqli_num_rows($datasql)!=0){
                                    unset($data6);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data6[] = $row;
                                    }
                                    $query = "SELECT * FROM `chi tiet gio hang` a JOIN (SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`)) b ON (a.`ma sp`=b.`ma sp`) WHERE `ma gh`='".$data6[0]['ma gh']."'";
                                    $datasql = mysqli_query($connect, $query);
                                    unset($data6);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data6[] = $row;
                                    }
                                }else {
                                    unset($data6);
                                }
                            } 
                            $connect->close();
                            ?>
                            <i class="header_cart-icon fas fa-shopping-cart"></i>
                            <span class="header_cart-thongbao"><?php if(!empty($data6)) echo count($data6); else{?> 0 <?php }?> </span>
                            <!-- No sp: header_cart-list--no-cart -->
                            <div class="header_cart-list  ">
                                <img src="./img/giohang.png" alt="giohang" class="header_cart-no-cart-img">
                                <?php if(empty($data6)){ ?>
                                <h5 class="header_cart-heading">Chưa có sản phẩm</h5>
                                <?php } else { 
                                ?>
                                <!-- có sp -->
                                <h5 class="header_cart-heading">Sản phẩm đã thêm</h5>
                                <ul class="header_cart-list-item">
                                    <!-- cart item -->
                                <?php 
                                for($i=0;$i<count($data6);$i++){
                                    ?>
                                    <li class="header_cart-item">
                                        <img src="<?php echo $data6[$i]['hinh anh']; ?>" alt="" class="header_cart-img">
                                        <div class="header_cart-item-info">
                                            <div class="header_cart-item-head">
                                                <h5 class="header_cart-item-name"><?php echo $data6[$i]['ten sp']; ?></h5>
                                                <div class="header_cart-item-price-wrap">
                                                    <span class="header_cart-item-price"><?php echo number_format($data6[$i]['gia sp'], 0, ',', '.')."đ"; ?></span>
                                                    <span class="header_cart-item-daunhan">x</span>
                                                    <span class="header_cart-item-qnt"><?php echo $data6[$i]['so luong'];?></span>
                                                </div>
                                            </div>
                                            <div class="header_cart-item-body">
                                                <span class="header_cart-item-description">
                                                    Phân loại: <?php echo $data6[$i]['ten loai sp'];?>
                                                </span>
                                                <a href="server.php?xoaspgiohang=<?php echo $data6[$i]['ma sp'];?>" style="text-decoration:none" class="header_cart-item-delete">Xóa</a>
                                            </div>
                                        </div>
                                    </li>
                                <?php }?>
                                    
                                </ul>
                                <?php } ?>
                                <button class="header_cart-view-cart btn btn--primary" onclick="window.location.href='giohang.php'">Xem giỏ hàng</button>
                            </div>
                        </div>

                    </div>
                    <div class="header__navbar-list">
                        <li class="header__navbar-item header__navbar-user">
                            <i class="fas fa-user-circle avt"></i>
                            <span class="header__navbar-user-name">
                                <?php if(!isset($_SESSION['khachhang']) && !isset($_SESSION['admin'])){ echo "Tài khoản";} else echo strtoupper(str_replace("@gmail.com","",$_SESSION['User']));?>
                            </span>
                            <?php if(isset($_SESSION['khachhang'])){?>
                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-menu-item">
                                    <a href="./xemthongtin.php?ma=<?php echo  $_SESSION['User']?>">Tài khoản của tôi</a>
                                </li>
                                <li class="header__navbar-user-menu-item">
                                    <a href="themthongtinnguoidung.php">Cập nhật thông tin</a>
                                </li>
                                <li class="header__navbar-user-menu-item">
                                    <a href="dsdonhang.php">Đơn hàng</a>
                                </li>
                                <li class="header__navbar-user-menu-item">
                                    <a href="./server.php?repasswd=<?php echo  $_SESSION['User']?>">Đổi mật khẩu</a>
                                </li>
                                <li class="header__navbar-user-menu-item header__navbar-user-menu-item--separate">
                                    <a href="./server.php?logout=true">Đăng xuất</a>
                                </li>
                            </ul>
                            <?php } else if(!isset($_SESSION['khachhang']) && !isset($_SESSION['admin'])){ ?>
                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-menu-item">
                                    <a  onclick="xuly1()">Đăng nhập</a>
                                </li>
                                <li class="header__navbar-user-menu-item" >
                                    <a onclick="xuly2()">Đăng kí</a>
                                </li>
                                <li class="header__navbar-user-menu-item">
                                    <a href="./forgotpws.php">Quên mật khẩu</a>
                                </li>
                            </ul>
                            <?php }  else if(isset($_SESSION['admin'])){ ?>
                            <ul class="header__navbar-user-menu">
                                <li class="header__navbar-user-menu-item">
                                    <a href="./xemthongtin.php?ma=<?php echo  $_SESSION['User']?>">Tài khoản của tôi</a>
                                </li>
                                <li class="header__navbar-user-menu-item">
                                    <a href="themthongtinnguoidung.php">Cập nhật thông tin</a>
                                </li>
                                <li class="header__navbar-user-menu-item">
                                    <a href="./server.php?repasswd=<?php echo  $_SESSION['User']?>">Đổi mật khẩu</a>
                                </li>
                                <li class="header__navbar-user-menu-item header__navbar-user-menu-item--separate">
                                    <a href="./server.php?logout=true">Đăng xuất</a>
                                </li>
                            </ul>
                            <?php }?>
                        </li>
                </div>
            </div>
        </header>
        <div class="app__container">
            <div class="grid">
                <div class="grid__row app__content">
                    <div class="grid__column-10">
                        <div class="home-sanpham">
                            <table>
                                <tr>
                                    <th style="width: 3%;">Mã đơn hàng</th>
                                    <th style="width: 13%;">Tên khách hàng</th>
                                    <th style="width: 15%;">Sản phẩm</th>
                                    <th style="width: 10%;">Hình ảnh</th>
                                    <th style="width: 5%;">Số lượng</th>
                                    <th style="width: 7%;">Khuyến mãi</th>
                                    <th style="width: 10%;">Tổng giá</th>
                                    <th style="width: 100px">Quản lí</th>
                                </tr>
                                <?php 
                                if(!empty($data))
                                for($i=0;$i<count($data);$i++){
                                ?>
                                <tr>
                                    <?php if($i==0 || $data[$i]['so hd']!=$data[$i-1]['so hd']){?>
                                    <td rowspan="<?php counthd($data, (String)$data[$i]['so hd']) ?>"><?php echo $data[$i]['so hd'] ?></td>
                                    <td rowspan="<?php counthd($data, (String)$data[$i]['so hd']) ?>"><?php echo $data[$i]['ho ten kh'] ?></td>
                                    <?php }?>
                                    <td><?php echo $data[$i]['ten sp'] ?> </td>
                                    <td><img src="<?php  echo $data[$i]['hinh anh']?>" alt="samsung" class="img_dh"></td>
                                    <td><?php echo $data[$i]['so luong'] ?></td>
                                    <td><?php
                                    $connect = new mysqli("localhost", "root", "", "mobile");
                                    mysqli_set_charset($connect, "utf8");
                                    $query = "SELECT b.*, `ten khuyen mai`, `tg bat dau`, `tg ket thuc` FROM `khuyen mai` a JOIN `chi tiet khuyen mai` b ON (a.`ma khuyen mai` = b.`ma khuyen mai`) WHERE `ma sp`='".$data[$i]['ma sp']."' AND `tg ket thuc` >= '".date('Y-m-d 00:00:00')."'";
                                    $datasql = mysqli_query($connect, $query);
                                    unset($data2);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data2[] = $row;
                                    }
                                    $connect->close();
                                    $max = 0;
                                    $pos = -1;
                                    if(!empty($data2)) {
                                        for($i=0;$i<count($data2);$i++){
                                            if($max < $data2[$i]['phan tram khuyen mai']){
                                                $max = $data2[$i]['phan tram khuyen mai'];
                                            }
                                        }
                                        echo $max."%";
                                    } else echo "0%";
                                    ?></td>
                                    <td><?php echo number_format($data[$i]['gia sp'], 0, ',', '.')."đ"?></td>
                                    <?php if($i==0 || $data[$i]['so hd']!=$data[$i-1]['so hd']){?>
                                    <td rowspan="<?php counthd($data, (String)$data[$i]['so hd']) ?>" >
                                    <div style="display:flex">
                                        <?php if($data[$i]['tinh trang']!=4){ ?>
                                        <a href="./xemhoadon.php?xemhoadon=<?php echo $data[$i]['so hd']?>" class="iconhd">
                                            <div class="nutdh">Xem</div>
                                        </a>
                                        <!-- <a href="./inhoadon/?inhoadon=<?php echo $data[$i]['so hd']?>"  class="iconhd">
                                            <div class="nutxdh nutdh">In</div>
                                        </a> -->
                                        <?php 
                                            if($data[$i]['tinh trang']==1){
                                                ?>
                                                <a href="./server.php?huydonhang=<?php echo $data[$i]['so hd']?>"  class="iconhd">
                                                    <div class="nutxdh nutdh" style="background:red">Hủy đặt hàng</div>
                                                </a>
                                                <?php
                                            }

                                        ?>
                                        <?php } if($data[$i]['tinh trang']==4){
                                            ?>
                                            <a class="iconhd">
                                                <div class="nutxdh nutdh" style="background:red">Đơn hàng đã bị hủy</div>
                                            </a>
                                            <?php
                                        }?>
                                    </div>
                                        
                                    </td>
                                    <?php }?>
                                </tr>
                                <?php }?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <footer class="footer">
            <div>
                <h3 class="footer__heading">THAOLINH MOBILE</h3>
                <div class="footer_shop">
                    <ul class="footer-list">
                        <li class="footer-item">
                            <p class="footer-item__link"> <b>Địa chỉ:</b> &nbsp 412, 30/4, Hưng Lợi, Ninh Kiều, Cần Thơ</p>
                        </li>
                        <li class="footer-item">
                            <p class="footer-item__link"> <b>Điện thoại:</b> &nbsp 0359348111</p>
                        </li>
                        <li class="footer-item">
                            <p class="footer-item__link"><b>Email: </b>&nbsp linh7651234@gmail.com</p>
                        </li>
                    </ul>
                </div>
                      
            </div>
            <div class="footer__bottom">
                <div class="grid">
                    <p class="footer__text">© 2021 - Bản quyền thuộc về Cửa hàng THAOLINH MOBILE</p>
                </div>
            </div>
        </footer>
    </div>
    <!-- modal layout (đang ký/dang nhap) -->
    <?php if(!isset($_SESSION['admin']) && !isset($_SESSION['khachhang'])){?>
    <div class="modal"
        style="<?php if(!isset($_SESSION['error-register']) && !isset($_SESSION['error-login'] )) echo "display:none"; ?>">
        <div class="modal__overlay"></div>

        <div class="modal__body">
            <!-- login form -->
            <div class="auth-form" id="login-form"
                style="<?php if(isset($_SESSION['error-register'])) echo "display:none;"?>">
                <form method="POST" action="./server.php" class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="dangky">Đăng nhập</h3>
                        <span class="dangnhap"
                            onclick="document.getElementById('login-form').style.display='none';document.getElementById('register-form').style.display='block';">Đăng
                            ký</span>
                    </div>
                    <div class="auth-form__form">
                        <?php 
                            if(isset($_SESSION['error-login'])){
                        ?>
                        <div class="auth-form__group error">Vui lòng kiểm tra lại email hoặc mật khẩu</div>
                        <?php
                        }?>
                        <div class="auth-form__group">
                            <input type="text" class="auth-form__input" name="email" placeholder="Email của bạn"
                                required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" name="password"
                                placeholder="Mật khẩu của bạn" required>
                        </div>

                    </div>
                    <div class="auth-form__pass">
                        <div class="auth-form__help">
                            <a href="" class="auth-form__help-link auth-form__help-quenmk ">Quên mật khẩu</a>
                            <span class="auth-form__help-gach"></span>
                            <a href="" class="auth-form__help-link">Cần trợ giúp?</a>
                        </div>
                    </div>

                    <div class="auth-form__nut">
                        <button class="btn btn--normal auth-form__nut-back" type="button"
                            onclick="document.getElementsByClassName('modal')[0].style.display='none';">TRỞ LẠI</button>
                        <button class="btn btn--primary" type="submit">ĐĂNG NHẬP</button>
                    </div>
                </form>
                <div class="auth-form_mangxh">

                    <a href="" class="auth-form_mangxh--facebook btn btn--size-s btn--with-icon">
                        <i class="auth-form_mangxh-icon fab fa-facebook-square"></i>
                        <span class="auth-form_mangxh-title">
                            Đăng nhập Facebook
                        </span>
                    </a>
                    <a href="" class="auth-form_mangxh--google btn btn--size-s btn--with-icon">
                        <i class="auth-form_mangxh-icon fab fa-google"></i>
                        <span class="auth-form_mangxh-title">
                            Đăng nhập Google
                        </span>
                    </a>
                </div>
            </div>
            <!-- Register form -->
            <div class="auth-form" id="register-form"
                style="<?php if(isset($_SESSION['error-register'])) echo "display:block;"?>">
                <form method="POST" action="./server.php" class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="dangky">Đăng ký</h3>
                        <span class="dangnhap"
                            onclick="document.getElementById('login-form').style.display='block';document.getElementById('register-form').style.display='none';">Đăng
                            nhập</span>
                    </div>
                    <div class="auth-form__form">
                        <?php
                            if(isset($_SESSION['error-register'])){
                                if($_SESSION['error-register']=="repsw"){
                        ?>
                        <div class="auth-form__group error">Mật khẩu chưa khớp</div>
                        <?php
                                }
                                else if($_SESSION['error-register']=="signup-email"){
                                    ?>
                        <div class="auth-form__group error">Email đã được sử dụng</div>
                        <?php
                                }
                        }?>
                        <div class="auth-form__group">
                            <input type="text" class="auth-form__input" name="signup-email" placeholder="Email của bạn"
                                required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" name="signup-psw"
                                placeholder="Mật khẩu của bạn" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" name="signup-repsw"
                                placeholder="Nhập lại mật khẩu của bạn" required>
                        </div>
                    </div>
                    <div class="auth-form__chinhsach">
                        <p class="auth-form__policy-text">Bằng việc đăng ký, bạn đã đồng ý với shop về
                            <a href="" class="auth-form__text-link">Điều khoản dịch vụ</a>&
                            <a href="" class="auth-form__text-link">Chính sách bảo mật</a>
                        </p>
                    </div>

                    <div class="auth-form__nut">
                        <button class="btn btn--normal auth-form__nut-back" type="button"
                            onclick="document.getElementsByClassName('modal')[0].style.display='none';">TRỞ LẠI</button>
                        <button class="btn btn--primary" type="submit">ĐĂNG KÝ</button>
                    </div>
                </form>
                <div class="auth-form_mangxh">

                    <a href="" class="auth-form_mangxh--facebook btn btn--size-s btn--with-icon">
                        <i class="auth-form_mangxh-icon fab fa-facebook-square"></i>
                        <span class="auth-form_mangxh-title">
                            Kết nối với Facebook
                        </span>
                    </a>
                    <a href="" class="auth-form_mangxh--google btn btn--size-s btn--with-icon">
                        <i class="auth-form_mangxh-icon fab fa-google"></i>
                        <span class="auth-form_mangxh-title">
                            Kết nối với Google
                        </span>
                    </a>
                </div>

            </div>

        </div>
    </div>
    <?php }?>
</body>
<?php

//mail:linh7651234@gmail.com
//pass: thaolinh
//pass ứng dụng: otwufltqwpdyjdil
?>

</html>