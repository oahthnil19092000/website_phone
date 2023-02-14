<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ThaoLinh Mobile | Admin</title>
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" />
    <link href="https://fonts.googleapis.com/css2?family=Cormorant:wght@500&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/index.css">
    <link rel="stylesheet" href="../css/index.css">
    <link rel="stylesheet" href="../css/base.css">
    <link rel="stylesheet" href="css/base.css">
    <link rel="icon" href="../img/logo2.png">
    <?php if (session_id() === '')
        session_start(); 
    ?>
</head>
<body style="margin: 0; ">
    <div class="app">
        <header class="header">
            <div class="grid">
                <div class="header-with-search">
                    <div class="header__logo">
                        <a href="./" class="header__logo-link">
                            <img src="../img/logo2.png" alt="logo" class="logo-img">
                        </a>
                        <a href="./" class="header__logo-name-link">
                            <h3 class="logo-name">THẢO LINH MOBILE</h3>
                        </a>
                    </div>
                <ul class="header__navbar-list">
                    <li class="header__navbar-item header__navbar-user">
                        <i class="fas fa-user-circle avt"></i>
                        <span class="header__navbar-user-name">
                            <?php if(!isset($_SESSION['khachhang']) && !isset($_SESSION['admin'])){ echo "Tài khoản";} else echo strtoupper(str_replace("@gmail.com","",$_SESSION['User']));?>
                        </span>
                        <?php if(isset($_SESSION['admin'])){ ?>
                        <ul class="header__navbar-user-menu">
                            <li class="header__navbar-user-menu-item">
                                <a href="../xemthongtin.php?ma=<?php echo  $_SESSION['User']?>">Tài khoản của tôi</a>
                            </li>
                            <li class="header__navbar-user-menu-item">
                                <a href="../themthongtinnguoidung.php">Cập nhật thông tin</a>
                            </li>
                            <li class="header__navbar-user-menu-item">
                                    <a href="../server.php?repasswd=<?php echo  $_SESSION['User']?>">Đổi mật khẩu</a>
                            </li>
                            <li class="header__navbar-user-menu-item header__navbar-user-menu-item--separate">
                                <a href="../server.php?logout=true">Đăng xuất</a>
                            </li>
                        </ul>
                        <?php }?>
                    </li>
                </ul>
            </div>
        </header>
        <div class="app__container">
            <div class="grid">
                <div class="grid__row app__content">
                    <div class="grid__column-2">
                        <nav class="category">
                            <ul class="category-list">
                                <li class="category-item category-item--active">
                                    <a href="./" class="category-item__link">
                                        <i class="fas fa-chart-bar"></i>
                                        Thống kê
                                    </a>
                                </li>
                                <li class="category-item ">
                                    <a href="./donhang.php" class="category-item__link">
                                        <i class="fas fa-baby-carriage"></i>
                                        Quản lí đơn hàng
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlibinhluan.php" class="category-item__link">
                                        <i class="fas fa-comment-dots"></i>
                                        Quản lí bình luận đánh giá
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanliloaisp.php" class="category-item__link">
                                        <i class="fas fa-mobile"></i>
                                        Quản lí loại sản phẩm
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlysanpham.php" class="category-item__link">
                                        <i class="fal fa-phone-square-alt"></i>
                                        Quản lí sản phẩm
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlinhacungcap.php" class="category-item__link">
                                        <i class="fas fa-handshake"></i>
                                        Quản lí nhà cung cấp
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./khachhang.php" class="category-item__link">
                                        <i class="fas fa-portrait"></i>
                                        Quản lí khách hàng
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlikhuyenmai.php" class="category-item__link">
                                        <i class="fas fa-percent"></i>
                                        Quản lí khuyến mãi
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="grid__column-10">
                        <div class="home-filter">
                            <h3 class="home-filter__header">Thống kê cửa hàng</h3>
                            <div class="home-filter-1">
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                        <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `tai khoan` WHERE `ma ad`='00000' AND `password` NOT LIKE '_!%';";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Khách hàng</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT a.*,`ten ncc` FROM `loai san pham` a JOIN `nha cung cap` b ON (a.`ma ncc`=b.`ma ncc`) WHERE `ma loai sp`!='0'";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Loại sản phẩm</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `san pham` WHERE `han bao hanh`!='-1000';";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk"> Sản phẩm</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT a.*,b.`ngay lap`,b.`so luong` FROM `san pham` a JOIN (SELECT a.`ngay lap`,b.* FROM (SELECT a.* FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`='3') a JOIN `chi tiet gio hang` b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
                                        $datasql = mysqli_query($connect, $query);
                                        unset($data);
                                        while ($row = mysqli_fetch_array($datasql, 1)) {
                                            $data[] = $row;
                                        }
                                        $connect->close();
                                        $tongdoanhthu=0;
                                    if(!empty($data))
                                    for($i = 0; $i < count($data) ; $i++){
                                        $date=date_create($data[$i]['ngay lap']);
                                        $ngaymua = date_format($date,"Y/m/d 00:00:00");
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT b.*, `ten khuyen mai`, `tg bat dau`, `tg ket thuc` FROM `khuyen mai` a JOIN `chi tiet khuyen mai` b ON (a.`ma khuyen mai` = b.`ma khuyen mai`) WHERE `ma sp`='".$data[$i]['ma sp']."' AND `tg ket thuc` >= '".$ngaymua."' AND `tg bat dau` <= '".$ngaymua."'";
                                        $datasql = mysqli_query($connect, $query);
                                        while ($row = mysqli_fetch_array($datasql, 1)) {
                                            $data2[] = $row;
                                        }
                                        $connect->close();
                                        $max = 0;
                                        $pos = -1;
                                        if(!empty($data2)) {
                                        for($j=0;$j<count($data2);$j++){
                                            if($max < $data2[$j]['phan tram khuyen mai']){
                                            $max = $data2[$j]['phan tram khuyen mai'];
                                            $pos = $j;
                                            }
                                            }
                                        }
                                        $tongdoanhthu += ( $data[$i]['gia sp'] - $data[$i]['gia sp']*$max/100 )*$data[$i]['so luong'];
                                    }
                                    echo number_format($tongdoanhthu, 0, ',', '.')."đ";
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Tổng doanh thu</p>
                                </div>
                            </div>
                            <h3 class="home-filter__header">Thống kê đơn hàng</h3>
                            <div class="home-filter-1">
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`>'0'";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Đơn hàng</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`='1'";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Đã đặt</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`='2'";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Đang giao</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`='3'";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Đã giao</p>
                                </div>
                                <div class="grid__column-4">
                                    <span class="grid__column-soluong">
                                    <?php
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `tinh trang`='4'";
                                        $datasql = mysqli_query($connect, $query);
                                        echo mysqli_num_rows($datasql);
                                        $connect->close();
                                    ?>
                                    </span>
                                    <p class="grid__column-tentk">Đã hủy</p>
                                </div>
                            </div>
                        </div>
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
</body>

</html>