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
        function in_data($array, $key)
        {
            if (!empty($array))
                foreach ($array as &$v) {
                    if ($v['ten loai sp'] == $key)
                        return true;
                }
            return false;
        }
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
                            <!-- <h3 class="category-heading">Sản Phẩm</h3> -->
                            <ul class="category-list">
                                <li class="category-item">
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
                                <li class="category-item category-item--active">
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
                            <h3 class="home-filter__header">Quản lí loại sản phẩm</h3>
                            <div class="btn_themsp">
                                <form method="get" action="">
                                    <div class="timkiem">
                                        <input type="text" name="search" placeholder="Tìm kiếm tên loại sản phẩm">
                                        <button type="submit" class="icon_timkiem">
                                            <i class=" fas fa-search"></i>
                                        </button>
                                    </div>
                                </form>
                                <button class="nut nut--themsp" onclick="window.location.href='../themloaisanpham.php'">Thêm loại sản phẩm</button>
                            </div>
                            <table>
                                <tr>
                                    <th style="width: 25px">STT</th>
                                    <th style="width: 70px">Mã loại sản phẩm</th>
                                    <th style="width: 100px">Tên loại sản phẩm</th>
                                    <th style="width: 150px">Nhà cung cấp</th>
                                    <th style="width: 100px">Quản lí</th>
                                </tr>
                                <?php 
                                $connect = new mysqli("localhost", "root", "", "mobile");
                                mysqli_set_charset($connect, "utf8");
                                $query = "SELECT a.*,`ten ncc` FROM `loai san pham` a JOIN `nha cung cap` b ON (a.`ma ncc`=b.`ma ncc`) WHERE `ma loai sp`!='0'";
                                $datasql = mysqli_query($connect, $query);
                                while ($row = mysqli_fetch_array($datasql, 1)) {
                                    $data[] = $row;
                                }
                                if (isset($_GET['search'])) {
                                    unset($data);
                                    $search = explode(' ', $_GET['search']);
                                    for ($z = count($search); $z >= 1; $z--) {
        
                                        if ($z != 1) {
                                            for ($i = 0; $i < $z; $i++) {
                                                $string[] = $search[$i];
                                            }
                                            $a = implode(' ', $string);
                                            unset($string);
                                            $query = "SELECT a.*,`ten ncc` FROM `loai san pham` a JOIN `nha cung cap` b ON (a.`ma ncc`=b.`ma ncc`) WHERE `ten loai sp` LIKE '%" . $a . "%'";
                                            $datasql = mysqli_query($connect, $query);
                                            while ($row = mysqli_fetch_array($datasql, 1)) {
                                                if(!empty($data)){
                                                    if (!in_data($data, $row['ten loai sp']))
                                                        $data[] = $row;
                                                }else {
                                                    $data[] = $row;
                                                }
                                            }
                                        } else {
                                            for ($i = 0; $i < count($search); $i++) {
                                                $query = "SELECT a.*,`ten ncc` FROM `loai san pham` a JOIN `nha cung cap` b ON (a.`ma ncc`=b.`ma ncc`) WHERE `ten loai sp` LIKE '%" . $search[$i] . "%'";
                                                $datasql = mysqli_query($connect, $query);
                                                while ($row = mysqli_fetch_array($datasql, 1)){
                                                    if(!empty($data)){
                                                        if (!in_data($data, $row['ten loai sp']))
                                                            $data[] = $row;
                                                    }else {
                                                        $data[] = $row;
                                                    }
                                                }
                                            }
                                        } 
        
                                    }
                                }
                                if(!empty($data))
                                for($i=0;$i<count($data);$i++){
                                ?>
                                <tr>
                                    <td><?php echo $i+1?></td>
                                    <td><?php echo $data[$i]['ma loai sp'] ?></td>
                                    <td><?php echo $data[$i]['ten loai sp'] ?></td>
                                    <td><?php echo $data[$i]['ten ncc'] ?></td>
                                    <td>
                                        <a href="../themloaisanpham.php?ma=<?php echo $data[$i]['ma loai sp'] ?>&ten=<?php echo $data[$i]['ten loai sp'] ?>&ncc=<?php echo $data[$i]['ma ncc'] ?>&tenncc=<?php echo $data[$i]['ten ncc'] ?>" class="icon-sua">
                                           <i class="sp_icon fas fa-edit">Sửa</i>
                                        </a>
                                        <a href="../server.php?xoaloaisp=<?php echo $data[$i]['ma loai sp'] ?>" class="icon-xoa">
                                            <i class="sp_icon fas fa-trash">Xóa</i>
                                        </a>
                                    </td>
                                </tr>
                                <?php }?>
                            </table>
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