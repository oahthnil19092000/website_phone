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
    <link rel="icon" href="img/logo2.png">
    <script src="js/home.js"></script>
    
    <?php if (session_id() === '')
            session_start(); 
            date_default_timezone_set("Asia/Ho_Chi_Minh");
        if(isset($_SESSION['errorMessage'])){
            echo "<script type='text/javascript'>
                alert('" . $_SESSION['errorMessage'] . "');
            </script>";
            unset($_SESSION['errorMessage']);
        } 
        if(isset($_GET['searchsp'])){
            if(!isset($_SESSION['tmp'])){
                $_SESSION['dasearch0']=$_GET['searchsp'];
                $_SESSION['tmp']=1;
            }
            else{
                for($i=$_SESSION['tmp']; $i >= 1; $i--){
                    $_SESSION['dasearch'.$i]=$_SESSION['dasearch'.($i-1)];
                }
                $_SESSION['dasearch0']=$_GET['searchsp'];
                if($_SESSION['tmp']<5)
                    $_SESSION['tmp']++;
            } 
        }
        function in_data($array, $key)
        {
            if (!empty($array))
                foreach ($array as &$v) {
                    if ($v['ten sp'] == $key)
                        return true;
                }
            return false;
        }   
    ?>
</head>

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
                    <div class="grid__column-2">
                        <nav class="category">
                            <div class="hienthi_dmsp">
                                <h3 class="category-heading category-item--active" onclick="if(dmsp.style.display=='none')dmsp.style.display='block'; else dmsp.style.display='none';"> 
                                    <i class="fas fa-align-justify"></i>
                                    DANH MỤC SẢN PHẨM
                                </h3>
                                <div class="dmsp" id="dmsp">
                                <ul class="category-list">
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="iPHONE") echo "category-item-choosed";?>">
                                        <a href="?searchsp=iPHONE" class="category-item__link">iPHONE</a>
                                    </li>
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="VSMART") echo "category-item-choosed";?>">
                                        <a href="?searchsp=VSMART" class="category-item__link"> VSMART </a>
                                    </li>
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="SAMSUNG") echo "category-item-choosed";?>">
                                        <a href="?searchsp=SAMSUNG" class="category-item__link">SAMSUNG</a>
                                    </li>
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="OPPO") echo "category-item-choosed";?>">
                                        <a href="?searchsp=OPPO" class="category-item__link">OPPO</a>
                                    </li>
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="VIVO") echo "category-item-choosed";?>">
                                        <a href="?searchsp=VIVO" class="category-item__link">VIVO</a>
                                    </li>
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="XIAOMI") echo "category-item-choosed";?>">
                                        <a href="?searchsp=XIAOMI" class="category-item__link">XIAOMI</a>
                                    </li>
                                    <li class="category-item <?php if(isset($_GET['searchsp']) && $_GET['searchsp']=="HUAWEI") echo "category-item-choosed";?>">
                                        <a href="?searchsp=HUAWEI" class="category-item__link">HUAWEI</a>
                                    </li>
                                </ul>
                                </div>
                            </div>
                            
                        </nav>
                    </div>

                    <div class="grid__column-10">
                        <div class="home-filter">
                            <div class="home-filter-1">
                                <span class="home-filter__label">Mức giá</span>
                                <a href="?timtu=sp<4000000"><button class="home-filter__btn btn <?php if(isset($_GET['timtu'])) if($_GET['timtu']=="sp<4000000") echo "btn--primary" ?>">Dưới 4 triệu</button></a>
                                <a href="?timtu=sp from 4000000 to 8000000"><button class="home-filter__btn btn <?php if(isset($_GET['timtu'])) if($_GET['timtu']=="sp from 4000000 to 8000000") echo "btn--primary" ?>">Từ 4 triệu đến 8 triệu</button></a>
                                <a href="?timtu=sp from 8000000 to 12000000"><button class="home-filter__btn btn <?php if(isset($_GET['timtu'])) if($_GET['timtu']=="sp from 8000000 to 12000000") echo "btn--primary" ?>">Từ 8 triệu đến 12 triệu</button></a>
                                <a href="?timtu=sp>12000000"><button class="home-filter__btn btn <?php if(isset($_GET['timtu'])) if($_GET['timtu']=="sp>12000000") echo "btn--primary" ?>">Từ 12 triệu</button></a>
                            </div>

                            <div class="home-filter-2">
                                <span class="home-filter__label">Sắp xếp theo</span>
                                <a href="?timtheo=1"><button class="home-filter__btn btn <?php if(isset($_GET['timtheo'])) if($_GET['timtheo']==1) echo "btn--primary" ?>">Phổ biến</button></a>
                                <a href="./"><button class="home-filter__btn btn <?php if(!isset($_GET['timtheo'])) echo "btn--primary"?>">Mới nhất</button></a>
                                <a href="?timtheo=2"><button class="home-filter__btn btn <?php if(isset($_GET['timtheo'])) if($_GET['timtheo']==2) echo "btn--primary" ?>">Bán chạy</button></a>

                                <div class="select-input">
                                    <span class="select-input__label">Giá</span>
                                    <i class="select-input__icon fas fa-angle-down"></i>
                                    <ul class="select-input__list">
                                        <li class="select-input__item">
                                            <a href="?sapxep=ASC" class="select-input__link">Giá: thấp đến cao <?php if(isset($_GET['sapxep'])) if($_GET['sapxep']=="ASC"){ ?><span class="fas fa-check"></span><?php }?></a>
                                        </li>
                                        <li class="select-input__item">
                                            <a href="?sapxep=DESC" class="select-input__link">Giá: cao đến thấp <?php if(isset($_GET['sapxep'])) if($_GET['sapxep']=="DESC"){ ?><span class="fas fa-check"></span><?php }?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="home-filter__page">
                                    <span class="home-filter__page-num">
                                        <?php 
                                        $connect = new mysqli("localhost", "root", "", "mobile");
                                        mysqli_set_charset($connect, "utf8");
                                        $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`) ORDER BY b.`ma sp` DESC";
                                        $datasql = mysqli_query($connect, $query);
                                        $tmp = mysqli_num_rows($datasql);
                                        $connect->close();
                                        if($tmp%15==0) $tmp = ($tmp- $tmp%15)/15;
                                        else $tmp = ($tmp- $tmp%15)/15 +1;
                                        ?>
                                        <span class="home-filter__page-current">1</span>/<?php echo $tmp?>
                                    </span>
                                    <div class="home-filter__page-ctrl">
                                        <span onclick="prepage()" class="home-filter__page-btn home-filter__page-btn--disabled" id="prepage">
                                            <i class="home-filter__page-icon fas fa-angle-left"></i>
                                        </span>
                                        <span onclick="nextpage()" class="home-filter__page-btn" id="nextpage">
                                            <i class="home-filter__page-icon fas fa-angle-right"></i>
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="home-sanpham">
                            <?php 
                                $connect = new mysqli("localhost", "root", "", "mobile");
                                mysqli_set_charset($connect, "utf8");
                                $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`) ORDER BY b.`ma sp` DESC";
                                $datasql = mysqli_query($connect, $query);
                                while ($row = mysqli_fetch_array($datasql, 1)) {
                                    $data[] = $row;
                                }
                                if (isset($_GET['searchsp'])) {
                                    unset($data);
                                    $search = explode(' ', $_GET['searchsp']);
                                    for ($z = count($search); $z >= 1; $z--) {
        
                                        if ($z != 1) {
                                            for ($i = 0; $i < $z; $i++) {
                                                $string[] = $search[$i];
                                            }
                                            $a = implode(' ', $string);
                                            unset($string);
                                            $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`) WHERE `ten sp` LIKE '%" . $a . "%' ORDER BY b.`ma sp` DESC";
                                            $datasql = mysqli_query($connect, $query);
                                            while ($row = mysqli_fetch_array($datasql, 1)) {
                                                if(!empty($data)){
                                                    if (!in_data($data, $row['ten sp']))
                                                        $data[] = $row;
                                                }else {
                                                    $data[] = $row;
                                                }
                                            }
                                        } else {
                                            for ($i = 0; $i < count($search); $i++) {
                                                $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`)  WHERE `ten sp` LIKE '%" . $search[$i] . "%' ORDER BY b.`ma sp` DESC;";
                                                $datasql = mysqli_query($connect, $query);
                                                while ($row = mysqli_fetch_array($datasql, 1)){
                                                    if(!empty($data)){
                                                        if (!in_data($data, $row['ten sp']))
                                                            $data[] = $row;
                                                    }else {
                                                        $data[] = $row;
                                                    }
                                                }
                                            }
                                        } 
        
                                    }
                                }
                                if(isset($_GET['timtu'])){
                                    $timtu = $_GET['timtu'];
                                    $gia = str_replace("sp","`gia sp`",$timtu);
                                    $gia = str_replace("from","BETWEEN",$gia);
                                    $gia = str_replace("to","AND",$gia);
                                    unset($data);
                                    $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`) WHERE ".$gia." ORDER BY b.`ma sp` DESC";
                                    $datasql = mysqli_query($connect, $query);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data[] = $row;
                                    }
                                }
                                if(isset($_GET['sapxep'])){
                                    unset($data);
                                    $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`) ORDER BY b.`gia sp` ".$_GET['sapxep']."";
                                    $datasql = mysqli_query($connect, $query);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data[] = $row;
                                    }
                                }
                                if(!empty($data))
                                    for($i=0;$i<count($data);$i++){
                                        unset($data1);
                                        unset($data2);
                                        $query = "SELECT b.`tom tat`, a.`gia tri thong so` FROM `chi tiet thong so` a JOIN `thong so ky thuat` b ON (a.`ma ts` = b.`ma ts`) WHERE a.`ma sp`= '".$data[$i]['ma sp']."'";
                                        $datasql = mysqli_query($connect, $query);
                                        while ($row = mysqli_fetch_array($datasql, 1)) {
                                            $data1[] = $row;
                                        }
                                        $query = "SELECT b.*, `ten khuyen mai`, `tg bat dau`, `tg ket thuc` FROM `khuyen mai` a JOIN `chi tiet khuyen mai` b ON (a.`ma khuyen mai` = b.`ma khuyen mai`) WHERE `ma sp`='".$data[$i]['ma sp']."' AND `tg ket thuc` >= '".date('Y-m-d 00:00:00')."' AND `tg bat dau` <= '".date('Y-m-d 00:00:00')."'";
                                        $datasql = mysqli_query($connect, $query);
                                        while ($row = mysqli_fetch_array($datasql, 1)) {
                                            $data2[] = $row;
                                        }
                                        if(empty($data2)) $khuyenmai=0; else{
                                            $max=0;            
                                            for($j=0;$j<count($data2);$j++){
                                                if($max < $data2[$j]['phan tram khuyen mai']){
                                                    $max = $data2[$j]['phan tram khuyen mai'];
                                                    $pos = $j;
                                                }
                                            }
                                            $khuyenmai = $max;
                                        }
                                        $gia = $data[$i]['gia sp'];
                                        if($i%15==0){
                                            ?>
                                            <div class="grid__row1" id="page<?php echo $i/15 +1?>" style="<?php if($i/15 +1!=1) echo "display:none"; else echo "display:flex";?>">
                                            <?php
                                        }
                                        ?>
                                        <div class="grid__column-2-4">
                                            <a class="home-sp-item" href="sanpham.php?search=<?php echo  $data[$i]['ma sp']; ?>">
                                                <div class="home-sp-item__img"
                                                    style="background-image: url('<?php echo  $data[$i]['hinh anh']?>');"></div>
                                                <h4 class="home-sp-item__name"><?php echo  $data[$i]['ten sp'];
                                                if($data[$i]['han bao hanh']==-1000){?>
                                                    | <i>Đã ngừng kinh doanh</i>
                                                    <?php } ?></h4>
                                                <div class="home-sp-item__gia">
                                                    <?php if($khuyenmai>0) {?>
                                                    <span class="home-sp-item__gia-cu"><?php echo number_format($gia, 0, ',', '.')."đ";?></span>
                                                    <span class="home-sp-item__gia-moi"><?php echo number_format($gia-$gia*$khuyenmai/100, 0, ',', '.')."đ";?></span>
                                                    <?php } else {?>
                                                    <span class="home-sp-item__gia-moi"><?php echo number_format($gia, 0, ',', '.')."đ";?></span>
                                                    <?php } ?>
                                                </div>
                                                <?php if($khuyenmai>0) {?>
                                                <div class="home-sp-item-sale-off">
                                                    <span class="home-sp-item-sale-percent"><?php echo $khuyenmai."%"?></span>
                                                    <span class="home-sp-item-sale-label">GIẢM</span>
                                                </div>
                                                <?php }?>
                                            </a>
                                        </div>
                                        <?php if($i%15==14){
                                            ?>
                                            </div>
                                            <?php
                                        }
                                    }     
                                $connect->close();
                                if(count($data)%15<14){
                                ?>
                                    </div>
                                <?php }
                            ?>     
                        </div>

                        <ul class="phantrang home-sanpham__phantrang">
                            <li class="phantrang-item ">
                                <span onclick="prepage()" class="phantrang-item__link" >
                                    <i class="phantrang-item__icon  fas fa-angle-left"></i>
                                </span>
                            </li>
                            <?php 
                            if(count($data)%15==0) $tmp = count($data)/15;
                            else $tmp = count($data)/15 +1;
                            for($x=1;$x<$tmp;$x++){?>
                            <li class="phantrang-item phantrang-item--active">
                                <input type="radio" name="pagepage" class="pagepage" id="page<?php  echo $x.$x ?>" <?php if($x==1) echo "checked";?> hidden>
                                <span onclick="page<?php  echo $x.$x ?>.checked='true';chuyentrang('<?php  echo $x ?>')" class="phantrang-item__link"><?php  echo $x ?></span>
                            </li>
                            <?php } ?>
                            <li class="phantrang-item">
                                <span onclick="nextpage()" class="phantrang-item__link">
                                    <i class="phantrang-item__icon  fas fa-angle-right"></i>
                                </span>
                            </li>
                        </ul>
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
    <div class="modal" style="<?php if(!isset($_SESSION['error-register']) && !isset($_SESSION['error-login'] ) && !isset($_SESSION['dangnhaplai'])) echo "display:none"; ?>">
        <div class="modal__overlay"></div>

        <div class="modal__body" >
            <!-- login form -->
            <div class="auth-form" id="login-form" style="<?php if(isset($_SESSION['error-register'])) echo "display:none;"; if(isset($_SESSION['dangnhaplai'])) { unset($_SESSION['dangnhaplai']);}?>">
                <form method="POST" action="./server.php" class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="dangky">Đăng nhập</h3>
                        <span class="dangnhap" onclick="document.getElementById('login-form').style.display='none';document.getElementById('register-form').style.display='block';">Đăng ký</span>
                    </div>
                    <div class="auth-form__form">
                        <?php 
                            if(isset($_SESSION['error-login'])){
                        ?>
                        <div class="auth-form__group error">Vui lòng kiểm tra lại email hoặc mật khẩu</div>
                        <?php
                        }?>
                        <div class="auth-form__group">
                            <input type="text" class="auth-form__input" name="email" placeholder="Email của bạn" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" name="password" placeholder="Mật khẩu của bạn" required>
                        </div>

                    </div>
                    <div class="auth-form__pass">
                        <div class="auth-form__help">
                            <a href="./forgotpws.php" class="auth-form__help-link auth-form__help-quenmk ">Quên mật khẩu</a>
                            <span class="auth-form__help-gach"></span>
                            <a href="" class="auth-form__help-link">Cần trợ giúp?</a>
                        </div>
                    </div>

                    <div class="auth-form__nut">
                        <button class="btn btn--normal auth-form__nut-back" type="button" onclick="document.getElementsByClassName('modal')[0].style.display='none';">TRỞ LẠI</button>
                        <button class="btn btn--primary" type="submit">ĐĂNG NHẬP</button>
                    </div>
                </form>
            </div>
            <!-- Register form -->
            <div class="auth-form" id="register-form" style="<?php if(isset($_SESSION['error-register'])) echo "display:block;"?>">
                <form method="POST" action="./server.php" class="auth-form__container">
                    <div class="auth-form__header">
                        <h3 class="dangky">Đăng ký</h3>
                        <span class="dangnhap" onclick="document.getElementById('login-form').style.display='block';document.getElementById('register-form').style.display='none';">Đăng nhập</span>
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
                            <input type="text" class="auth-form__input" name="signup-email" placeholder="Email của bạn" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" name="signup-psw" placeholder="Mật khẩu của bạn" required>
                        </div>
                        <div class="auth-form__group">
                            <input type="password" class="auth-form__input" name="signup-repsw" placeholder="Nhập lại mật khẩu của bạn" required>
                        </div>
                    </div>
                    <div class="auth-form__chinhsach">
                        <p class="auth-form__policy-text">Bằng việc đăng ký, bạn đã đồng ý với shop về
                            <a href="" class="auth-form__text-link">Điều khoản dịch vụ</a>&
                            <a href="" class="auth-form__text-link">Chính sách bảo mật</a>
                        </p>
                    </div>

                    <div class="auth-form__nut">
                        <button class="btn btn--normal auth-form__nut-back" type="button" onclick="document.getElementsByClassName('modal')[0].style.display='none';">TRỞ LẠI</button>
                        <button class="btn btn--primary" type="submit">ĐĂNG KÝ</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
    <?php }?>
</body>
<?php
//mail:linh7651234@gmail.com
//pass: thaolinh
//pass ứng dụng: datlzzrwblnaawoj
?>
</html>