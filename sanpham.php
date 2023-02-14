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
    ?>

</head>
<?php if(isset($_GET['search'])){
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT b.*, a.`ten loai sp` FROM `loai san pham` a JOIN `san pham` b ON (a.`ma loai sp` = b.`ma loai sp`) WHERE `ma sp`='".$_GET['search']."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "SELECT b.`tom tat`, a.`gia tri thong so` FROM `chi tiet thong so` a JOIN `thong so ky thuat` b ON (a.`ma ts` = b.`ma ts`) WHERE a.`ma sp`= '".$_GET['search']."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data1[] = $row;
    }
    $query = "SELECT b.*, `ten khuyen mai`, `tg bat dau`, `tg ket thuc` FROM `khuyen mai` a JOIN `chi tiet khuyen mai` b ON (a.`ma khuyen mai` = b.`ma khuyen mai`) WHERE `ma sp`='".$_GET['search']."' AND '".date('Y-m-d 00:00:00')."' BETWEEN `tg bat dau` AND `tg ket thuc` ";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data2[] = $row;
    }
    $query = "SELECT b.*, a.* FROM `san pham cu the` a JOIN `phieu bao hanh` b ON (a.`so seri`=b.`so seri`) WHERE b.`so hd`='0' AND `ma sp`='".$_GET['search']."'";
    $datasql = mysqli_query($connect, $query);
    $tongsosp = mysqli_num_rows($datasql);
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
                            <div class="ttsanpham">
                                <div>
                                    <div class="thongtin">
                                        <div class="anhsanpham">
                                            <img src="<?php echo $data[0]['hinh anh'] ?>" alt="">
                                        </div>
                                        <div class="ttsp">
                                            <div class="chitiet">
                                                <div class="tensp">
                                                    <?php echo $data[0]['ten sp'] ?>
                                                </div>
                                                <div class="thuonghieu">
                                                    <b>Thương hiệu : </b><?php echo $data[0]['ten loai sp']  ?>
                                                </div>
                                                <div class="thuonghieu">
                                                    <b>Bảo hành chính hảng : </b><?php if($data[0]['han bao hanh']/365 >= 1) echo ($data[0]['han bao hanh']/365)." năm"; else if($data[0]['han bao hanh']/365 < 1 && $data[0]['han bao hanh']/365 >= 0) echo ($data[0]['han bao hanh']/30)." tháng"; ?>
                                                </div>
                                                <div class="thuonghieu">
                                                    <b>Số lượng trong kho : </b><?php echo $tongsosp ?>
                                                </div>
                                                <div class="thuonghieu">
                                                <b><?php if($data[0]['han bao hanh']==-1000) echo "Không còn kinh doanh sản phẩm này"?></b>
                                                </div>
                                            </div>
                                            <div class="giakm">
                                                <div class="giasp">
                                                <?php 
                                                    $max = 0;
                                                    $pos = -1;
                                                    if(!empty($data2)) {
                                                        
                                                        for($i=0;$i<count($data2);$i++){
                                                            if($max < $data2[$i]['phan tram khuyen mai']){
                                                                $max = $data2[$i]['phan tram khuyen mai'];
                                                                $pos = $i;
                                                            }
                                                        }
                                                        
                                                    } ?>
                                                    <?php
                                                    if($max!=0)
                                                     echo "<del>".number_format($data[0]['gia sp'], 0, ',', '.')."đ</del><br>";
                                                     echo number_format($data[0]['gia sp']-$data[0]['gia sp']*$max/100, 0, ',', '.')."đ" ?>
                                                </div>
                                                <div class="khuyenmaisp">
                                                    <?php echo "<b>".$max." %</b>"; ?>
                                                </div>
                                            </div>
                                            <?php if($pos>=0){ ?>
                                            <div class="cokhuyenmai">
                                                <b>Chương trình khuyến mãi:</b>
                                                <?php echo $data2[$pos]['ten khuyen mai']; ?>
                                            </div>
                                            <?php }?>
                                            <form method="post" action="server.php" class="themvaogiohang">
                                                <div class="soluong">
                                                    <input type="text" name="maspchogiohang" value="<?php echo $_GET['search'];?>" hidden>
                                                    <button type="button"  onclick="bot()">-</button>
                                                    <input type="number" name="soluong" id="soluong" value="1" min="1" required max="<?php echo $tongsosp ?>">
                                                    <button type="button" id="add" onclick="them(<?php echo $tongsosp ?>)">+</button>
                                                </div>
                                                <div class="btnadd">
                                                    <button type="submit" <?php if($data[0]['han bao hanh']==-1000 || isset($_SESSION['admin']) || !isset($_SESSION['khachhang'])) echo "disabled"?>>
                                                        <i class="fas fa-shopping-cart" ></i>
                                                        Thêm vào giỏ hàng
                                                    </button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                    <div class="chitiet-baohanh">
                                        <div class="chitietccuthe">
                                            <h4>THÔNG SỐ KỸ THUẬT</h4>
                                            <?php 
                                            if(!empty($data1))
                                            for($i=0; $i <count($data1); $i++){?>
                                                <div class="chitiet-container">
                                                    <div class="chitiet-item">
                                                        <b><?php echo $data1[$i]['tom tat']; ?></b>
                                                    </div>
                                                    <div class="chitiet-item1">
                                                        <?php echo $data1[$i]['gia tri thong so']; ?>
                                                    </div>
                                                </div>
                                            <?php }?>
                                        </div>
                                        <div class="baohanh">
                                            <h4>THÔNG TIN BẢO HÀNH</h4>
                                            <ul class="policy__list">
                                                <li>
                                                    <div class="iconl">
                                                        <i class="icondetail-doimoi"></i>
                                                    </div>
                                                    <p>
                                                        Hư gì đổi nấy <b>12 tháng</b> tại cửa hàng (miễn
                                                        phí tháng đầu) <a
                                                            href="https://www.thegioididong.com/chinh-sach-bao-hanh-san-pham"></a>
                                                        <a href="" title="Chính sách đổi trả">
                                                            Xem chi tiết
                                                        </a>
                                                    </p>
                                                </li>
                                                <li data-field="IsSameBHAndDT">
                                                    <div class="iconl">
                                                        <i class="icondetail-baohanh"></i>
                                                    </div>
                                                    <p>
                                                        Bảo hành <b>chính hãng điện thoại <?php if($data[0]['han bao hanh']/365 >= 1) echo ($data[0]['han bao hanh']/365)." năm"; else echo ($data[0]['han bao hanh']/30)." tháng"; ?></b>
                                                    </p>
                                                </li>

                                                <li>
                                                    <div class="iconl"><i class="icondetail-sachhd"></i></div>
                                                    <p>Bộ sản phẩm gồm: Hộp, Sách hướng dẫn, Cây lấy sim, Cáp Lightning
                                                        - Type C <a href="javascript:" class="hinh-mo-hop-link">Xem
                                                            hình</a></p>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="mota">
                                        
                                        <div class="chitietmota" id="chitietmota">
                                            <h4>MÔ TẢ CHI TIẾT</h4>
                                            <?php echo $data[0]['mo ta san pham'] ?>
                                            <br>
                                            <img src="<?php echo $data[0]['hinh anh'] ?>" alt="">
                                            <br>
                                            Sản phẩm có bán trực tiếp tại của hàng điện thoại di động Thảo Linh hoặc trên website <a href="./">thaolinhmobile.vn</a>
                                        </div>
                                        <button onclick="hienmota(this)">Hiện mô tả</button>
                                        <div id="hiensp">
                                            
                                        </div>
                                        
                                    </div>
                                    <?php if(isset($_SESSION['khachhang'])){ ?>
                                        <div class="mota">
                                            <div class="chitietmota" id="chitietmota">
                                                <h4>ĐÁNH GIÁ</h4>
                                                
                                                <form action="./server.php" method="post" class="form-danhgia">
                                                    <textarea name="danhgia" class="danhgia" placeholder="Vui lòng không đánh giá" required></textarea>
                                                    <input type="text" name="masp-danhgia" value="<?php echo $_GET['search']?>" hidden required>
                                                    <div class="box-danhgia">
                                                        <div>
                                                            <input class="star star-5" id="star-5" type="radio" name="star" value="5" required/>
                                                            <label class="star star-5" for="star-5"></label>
                                                            <input class="star star-4" id="star-4" type="radio" name="star" value="4" required/>
                                                            <label class="star star-4" for="star-4"></label>
                                                            <input class="star star-3" id="star-3" type="radio" name="star" value="3" required/>
                                                            <label class="star star-3" for="star-3"></label>
                                                            <input class="star star-2" id="star-2" type="radio" name="star" value="2" required/>
                                                            <label class="star star-2" for="star-2"></label>
                                                            <input class="star star-1" id="star-1" type="radio" name="star" value="1" required/>
                                                            <label class="star star-1" for="star-1"></label>
                                                        </div>
                                                        <button type="submit" class="btn-danhgia">Đánh giá</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    <?php } ?>
                                    <div class="mota">
                                        
                                        <div class="chitietmota" id="chitietmota3">
                                            <h4>TẤT CẢ ĐÁNH GIÁ</h4>
                                            
                                            <?php 
                                            $connect = new mysqli("localhost", "root", "", "mobile");
                                            mysqli_set_charset($connect, "utf8");
                                            $query = "SELECT a.`ho ten kh`,b.* FROM `khach hang` a JOIN (SELECT b.*,a.`use name` FROM `tai khoan` a JOIN (SELECT  * FROM `binh luan` ) b ON (a.`ma kh`=b.`ma kh`))b ON (a.`ma kh`=b.`ma kh`) WHERE `ma sp`='".$_GET['search']."'";
                                            $datasql = mysqli_query($connect, $query);
                                            $tmp = mysqli_num_rows($datasql);
                                            if($tmp==0){
                                                ?>
                                                    <i>Sản phẩm này chưa có bình luận.</i>
                                                <?php
                                            } else {
                                                unset($data);
                                                while ($row = mysqli_fetch_array($datasql, 1)) {
                                                    
                                                    $data[] = $row;
                                                }
                                                for ($z = 0; $z < count($data); $z++) {
                                                ?>
                                                    <div class="item-danhgia">
                                                        <b><?php if(isset($_SESSION['khachhang']) && $_SESSION['User'] == $data[$z]['use name'])echo "Bạn"; else echo $data[$z]['ho ten kh']?></b>
                                                        <div>
                                                            <div>Điểm đánh giá: <b><?php echo $data[$z]['diem dg']?></b></div>
                                                            <div>
                                                                <i>Nội dung đánh giá:</i>
                                                                <div><?php echo $data[$z]['nd binh luan']?></div>
                                                            </div>
                                                        </div>
                                                        <?php if((isset($_SESSION['khachhang']) && $_SESSION['User'] == $data[$z]['use name']) || isset($_SESSION['admin'])){ ?>
                                                            <a href="./server.php?xoabldg=<?php echo $data[$z]['ma bldg'];?>"><button type="button" class="btn btn-outline-primary">Xóa bình luận</button></a>
                                                        <?php } ?>
                                                    </div>
                                                <?php
                                                }
                                            }
                                            $connect->close();
                                            
                                            ?>
                                        </div>
                                        
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
}
//mail:linh7651234@gmail.com
//pass: thaolinh
//pass ứng dụng: otwufltqwpdyjdil
?>

</html>