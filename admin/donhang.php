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
        error_reporting(0);
        function counthd($a, $c){
            $count=0;
            for($i=0;$i<count($a);$i++){
                if($a[$i]['so hd'].""==$c){
                    $count++;
                }
            }
            echo $count;
        }
        function counttt($a){
            $count=0;
            if(!empty($a)){
                for($i=0;$i<count($a);$i++){
                    if($a[$i]['tinh trang'].""=="1" && $a[$i]['so hd']!=$a[$i-1]['so hd']){
                        $count++;
                    }
                }
            }
            return $count;
        }
        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
        $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000') b ON (a.`ma gh`=b.`ma gh`)  WHERE `tinh trang`!='0') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`) ORDER BY `tinh trang` ASC";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        if (isset($_GET['search'])) {
            unset($data);
            $search = $_GET['search'];
            $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' AND a.`ma gh` LIKE '%" . $search . "%') b ON (a.`ma gh`=b.`ma gh`)  WHERE `tinh trang`!='0') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
            $datasql = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            }
        }
        if (isset($_GET['tinhtrang'])) {
            unset($data);
            $search = $_GET['tinhtrang'];
            $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' ) b ON (a.`ma gh`=b.`ma gh`)  WHERE `tinh trang`!='0') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`) AND `tinh trang`='" . $search . "'";
            $datasql = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            }
        }
        $dhcd=counttt($data);
    if(isset($_SESSION['thieuhang'])){
        $query = "SELECT * FROM `san pham` WHERE `ma sp`='".$_SESSION['thieuhang']."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data4[] = $row;
        }
        unset($_SESSION['thieuhang']);
    
    ?>
    
    <script>
        alert("Kh??ng ????? s???n ph???m: <?php echo $data4[0]['ten sp']?>");
    </script>
    <?php unset($data4);}?>
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
                            <h3 class="logo-name">TH???O LINH MOBILE</h3>
                        </a>
                    </div>
                <ul class="header__navbar-list">
                    <li class="header__navbar-item header__navbar-user">
                        <i class="fas fa-user-circle avt"></i>
                        <span class="header__navbar-user-name">
                            <?php if(!isset($_SESSION['khachhang']) && !isset($_SESSION['admin'])){ echo "T??i kho???n";} else echo strtoupper(str_replace("@gmail.com","",$_SESSION['User']));?>
                        </span>
                        <?php if(isset($_SESSION['admin'])){ ?>
                        <ul class="header__navbar-user-menu">
                            <li class="header__navbar-user-menu-item">
                                <a href="../xemthongtin.php?ma=<?php echo  $_SESSION['User']?>">T??i kho???n c???a t??i</a>
                            </li>
                            <li class="header__navbar-user-menu-item">
                                <a href="../themthongtinnguoidung.php">C???p nh???t th??ng tin</a>
                            </li>
                            <li class="header__navbar-user-menu-item">
                                    <a href="../server.php?repasswd=<?php echo  $_SESSION['User']?>">?????i m???t kh???u</a>
                            </li>
                            <li class="header__navbar-user-menu-item header__navbar-user-menu-item--separate">
                                <a href="../server.php?logout=true">????ng xu???t</a>
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
                                <li class="category-item">
                                    <a href="./" class="category-item__link">
                                        <i class="fas fa-chart-bar"></i>
                                            Th???ng k??
                                    </a>
                                </li>
                                <li class="category-item category-item--active ">
                                    <a href="./donhang.php" class="category-item__link">
                                        <i class="fas fa-baby-carriage"></i>
                                        Qu???n l?? ????n h??ng
                                        <?php if($dhcd!=0){?>
                                        <i class="fas fa-comment" style="position:absolute; font-size:50px; top:-20px; right:-20px; font-style:fas; color:#ff81b5"></i>
                                        <div style="position:absolute; font-size:30px; top:-7px; right:0px; font-style:fas; color:white"><?php echo $dhcd;?></div>
                                        <?php }?>
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlibinhluan.php" class="category-item__link">
                                        <i class="fas fa-comment-dots"></i>
                                        Qu???n l?? b??nh lu???n ????nh gi??
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanliloaisp.php" class="category-item__link">
                                        <i class="fas fa-mobile"></i>
                                        Qu???n l?? lo???i s???n ph???m
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlysanpham.php" class="category-item__link">
                                        <i class="fal fa-phone-square-alt"></i>
                                        Qu???n l?? s???n ph???m
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlinhacungcap.php" class="category-item__link">
                                        <i class="fas fa-handshake"></i>
                                        Qu???n l?? nh?? cung c???p
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./khachhang.php" class="category-item__link">
                                        <i class="fas fa-portrait"></i>
                                        Qu???n l?? kh??ch h??ng
                                    </a>
                                </li>
                                <li class="category-item">
                                    <a href="./quanlikhuyenmai.php" class="category-item__link">
                                        <i class="fas fa-percent"></i>
                                        Qu???n l?? khuy???n m??i
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>

                    <div class="grid__column-10">
                        <div class="home-filter">
                            <h3 class="home-filter__header">Qu???n l?? ????n h??ng</h3>
                            <div style="display:flex; justify-content:space-between">
                                
                                <div class="qlsp">
                                    <a href="donhang.php" class="qlsp_link">T???t c???</a>
                                    <a href="?tinhtrang=1" class="qlsp_link">?????t h??ng</a>
                                    <a href="?tinhtrang=2" class="qlsp_link">??ang giao</a>
                                    <a href="?tinhtrang=3" class="qlsp_link">???? giao</a>
                                    <a href="?tinhtrang=4" class="qlsp_link">???? h???y</a>
                                </div>
                                <div class="btn_themsp">
                                    <form method="get" action="">
                                        <div class="timkiem">
                                            <input type="text" name="search" placeholder="T??m ki???m m?? ????n h??ng" required>
                                            <button type="submit" class="icon_timkiem">
                                                <i class=" fas fa-search"></i>
                                            </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <table>
                                <tr>
                                    <th style="width: 3%;">M?? ????n h??ng</th>
                                    <th style="width: 13%;">T??n kh??ch h??ng</th>
                                    <th style="width: 15%;">S???n ph???m</th>
                                    <th style="width: 10%;">H??nh ???nh</th>
                                    <th style="width: 5%;">S??? l?????ng</th>
                                    <th style="width: 7%;">Khuy???n m??i</th>
                                    <th style="width: 10%;">T???ng gi??</th>
                                    <th style="width: 100px">Qu???n l??</th>
                                </tr>
                                <?php 
                                if(!empty($data))
                                for($i=0;$i<count($data);$i++){
                                ?>
                                <tr>
                                    <?php if($i==0 || $data[$i]['so hd']!=$data[$i-1]['so hd']){?>
                                    <td rowspan="<?php counthd($data, $data[$i]['so hd']) ?>"><?php echo $data[$i]['so hd'] ?></td>
                                    <td rowspan="<?php counthd($data, $data[$i]['so hd']) ?>"><?php echo $data[$i]['ho ten kh'] ?></td>
                                    <?php }?>
                                    <td><?php echo $data[$i]['ten sp'] ?> </td>
                                    <td><img src=".<?php  echo $data[$i]['hinh anh']?>" alt="samsung" class="img_dh"></td>
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
                                    $max = 0;
                                    $pos = -1;
                                    if(!empty($data2)) {
                                        for($j=0;$j<count($data2);$j++){
                                            if($max < $data2[$j]['phan tram khuyen mai']){
                                                $max = $data2[$j]['phan tram khuyen mai'];
                                            }
                                        }
                                        echo $max."%";
                                    } else echo "0%";
                                    ?></td>
                                    <td><?php echo number_format($data[$i]['gia sp']*$data[$i]['so luong'] - $data[$i]['gia sp']*$data[$i]['so luong']*$max/100, 0, ',', '.')."??"?></td>
                                    <?php if($i==0 || $data[$i]['so hd']!=$data[$i-1]['so hd']){?>
                                    <td rowspan="<?php counthd($data, $data[$i]['so hd']) ?>" >
                                    <div style="display:flex">
                                        <?php if($data[$i]['tinh trang']!=4){ ?>
                                        <a href="../xemhoadon.php?xemhoadon=<?php echo $data[$i]['so hd']?>" class="iconhd">
                                            <div class="nutxdh nutdh">Xem</div>
                                        </a>
                                        <?php }
                                        if($data[$i]['tinh trang']<3){
                                            if($data[$i]['tinh trang'] == 1){?>
                                        <a href="../server.php?tinhtrangdonhang=<?php echo $data[$i]['tinh trang']?>&donhang=<?php echo $data[$i]['so hd']?>" class="iconhd">
                                            <div class="nutdh">Duy???t ????n</div>
                                        </a>
                                        <?php }if($data[$i]['tinh trang'] == 2) { ?>
                                        <a href="../server.php?tinhtrangdonhang=<?php echo $data[$i]['tinh trang']?>&donhang=<?php echo $data[$i]['so hd']?>" class="iconhd">
                                            <div class="nutdh">Giao h??ng</div>
                                        </a>
                                        <?php }?>
                                        <a href="../server.php?huydonhang=<?php echo $data[$i]['so hd']?>"  class="iconhd">
                                            <div class="nuthdh">H???y ????n</div>
                                        </a>
                                        <?php } else  if($data[$i]['tinh trang']==3){ ?>
                                            <div class="nutdh">???? giao</div>
                                        <?php } else  if($data[$i]['tinh trang']==4){ ?>
                                            <div class="nuthdh">???? h???y ????n h??ng</div>
                                        <?php } 
                                        if($data[$i]['tinh trang']!=4){ ?>
                                        <a href="../inhoadon/?inhoadon=<?php echo $data[$i]['so hd']?>"  class="iconhd">
                                            <div class="nutxdh nutdh">In</div>
                                        </a>
                                        <?php }?>
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
    </div>
    <footer class="footer">
        <div>
            <h3 class="footer__heading">THAOLINH MOBILE</h3>
                <div class="footer_shop">
                    <ul class="footer-list">
                        <li class="footer-item">
                            <p class="footer-item__link"> <b>?????a ch???:</b> &nbsp 412, 30/4, H??ng L???i, Ninh Ki???u, C???n Th??</p>
                        </li>
                        <li class="footer-item">
                            <p class="footer-item__link"> <b>??i???n tho???i:</b> &nbsp 0359348111</p>
                        </li>
                        <li class="footer-item">
                            <p class="footer-item__link"><b>Email: </b>&nbsp linh7651234@gmail.com</p>
                        </li>
                    </ul>
                </div>          
        </div> 
        <div class="footer__bottom">
            <div class="grid">
                <p class="footer__text">?? 2021 - B???n quy???n thu???c v??? C???a h??ng THAOLINH MOBILE</p>
            </div>
        </div>            
    </footer>                                        
</body>

</html>