<?php 
//nhìn xử lí đăng nhập nha
if (session_id() === '') session_start();//này để bật session
error_reporting(0);//này để sai thì nó cũng k hiện lỗi
date_default_timezone_set("Asia/Ho_Chi_Minh");// này chuyển múi giờ về Asia/Ho_Chi_Minh
//này khi có thằng nào đó gửi 1 cái form lên theo kiểu post (method="post") thì nó sẽ xuất hiện biến $_POST['name']

if(isset($_POST['email'])&&isset($_POST['password'])){//isset ghĩa là có tồn tại isset($_POST['email']) này là có tồn tại biến email gửi lên kiểu post
    if(isset($_SESSION['error-login']))
        unset($_SESSION['error-login']);
    $email = $_POST['email'];
    $password = $_POST['password'];
    $password = md5($password);
    $connect = new mysqli("localhost", "root", "", "mobile"); //này mở cơ sở dữ liệu thông qua biến $connect đặt tên biến là gì cũng đc nhớ
    mysqli_set_charset($connect, "utf8");//quy định cho nó có sài tiếng việt
    
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$email."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
        
    }
    
    //lưu hết tất cả giá trị vô mảng $data
    if(!empty($data)){//nếu mảng data không rỗng
        for($i=0;$i<count($data);$i++){//duyệt hết mảng data
            //xử lí
            if($data[$i]['use name'] == $email){
                if($data[$i]['password']==$password){
                    $_SESSION['User']=$email;
                    if($data[$i]['ma ad'] != "00000"){
                        $_SESSION['admin'] = "admin";
                        header('Location: ./admin/');
                    } else if($data[$i]['ma kh'] != "00000"){
                        $_SESSION['khachhang']="khachhang";
                        header('Location: ./');
                    } 
                    
                } else {
                    $_SESSION['error-login'] = "error-login";
                    header('Location: ./');
                }
            }
        }
    }
    else {
        $_SESSION['error-login'] = "error-login";
        header('Location: ./');
    } 
    $connect->close();
}
if(isset($_POST['signup-email'])&&isset($_POST['signup-psw'])&&isset($_POST['signup-repsw'])){
    if(isset($_SESSION['error-login']))
        unset($_SESSION['error-login']);
    if(isset($_SESSION['error-register']))
        unset($_SESSION['error-register']);
    $email = $_POST['signup-email'];
    $password = $_POST['signup-psw'];
    $repassword = $_POST['signup-repsw'];
    if($password != $repassword){
        $_SESSION['error-register']="repsw";
        header('Location: ./');
    }
    else {
        $password = md5($password);

        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
    
        $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$email."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
            
        }
        
        if(empty($data)){
            $manguoidung = date('mdHis');
            $_SESSION['abc'] = $password;
            if(isset($_SESSION['admin'])){
                $query = "INSERT INTO `admin`(`ma ad`, `ho ten ad`, `ngay sinh`, `so dien thoai`, `dia chi`, `email`, `cmnd`) VALUES ('".$manguoidung."','','','','','','')";
                $datasql = mysqli_query($connect, $query);
                $query = "INSERT INTO `tai khoan`(`use name`, `ma ad`, `ma kh`, `password`) VALUES ('".$email."','".$manguoidung."','00000','".$password."')";
                $datasql = mysqli_query($connect, $query);
            } else {
                $query = "INSERT INTO `khach hang`(`ma kh`, `ho ten kh`, `ngay sinh kh`, `dia chi`, `sdt`, `cmnd`) VALUES ('".$manguoidung."','','','','','')";
                $datasql = mysqli_query($connect, $query);
                $query = "INSERT INTO `tai khoan`(`use name`, `ma ad`, `ma kh`, `password`) VALUES ('".$email."','00000','".$manguoidung."','".$password."')";
                $datasql = mysqli_query($connect, $query);
            }
        } else {
            $_SESSION['error-register']="signup-email";
        }
        
        $connect->close();
        header('Location: ./');
        }
}
if(isset($_GET['logout'])){
    unset($_SESSION['khachhang']);
    unset($_SESSION['admin']);
    unset($_SESSION['User']);
    header('Location: ./');
}
if(isset($_POST['quenmatkhau-email']) || isset($_GET['recode'])){
    if (isset($_SESSION['checkCode'])) {
        unset($_SESSION['checkCode']);
    }
    if(isset($_SESSION['error-noemail']))
        unset($_SESSION['error-noemail']);
    if(isset($_POST['quenmatkhau-email']))
    $sendUsername = $_POST['quenmatkhau-email'];
    else $sendUsername =$_SESSION['namecheck'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $test = false;
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='" . $sendUsername . "'";
    $datasql = mysqli_query($connect, $query);
    if (mysqli_num_rows($datasql)!=0) {
        $_SESSION['GetCode'] = rand(100000, 999999);
        $_SESSION['namecheck'] = $sendUsername;
        $to      = $sendUsername;
        $subject = "Mã xác nhận tài khoản";
        $message = "Chào bạn," . "<br>" . "Đây là email giúp bạn lấy lại mật khẩu" . "<br>" . "Đây là mã xác nhận của bạn:<b>" . $_SESSION['GetCode'] . "</b><br>" . "***********<br><h2>Thảo Linh Mobile</h2><br>Địa chỉ: 1L/1, Hẻm 51, Đường Ba Tháng Hai, Phường Xuân Khánh, Quận Ninh Kiều, Thành Phố Cần Thơ<br>Số điện thoại: 0332934017";
        $header  =  "From:Thảo Linh Mobile\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-type: text/html;charset=UTF-8\r\n";

        if (mail($to, $subject, $message, $header)) {
            header('Location: ./checkcode.php');
        } else {
            $_SESSION['error-noemail']="error-noemail";
            header('Location: ./forgotpws.php');
        }
    }else {
        $_SESSION['error-noemail']="error-noemail";
        header('Location: ./forgotpws.php');
    }


    $connect->close();
}
if (isset($_POST['xacthuc-maxt'])) {
    if(isset($_SESSION['errorMessage'])){
        unset($_SESSION['errorMessage']);
    }
    if(isset($_SESSION['error-saixacthuc'])){
        unset($_SESSION['error-saixacthuc']);
    }
    if ($_POST['xacthuc-maxt'] == $_SESSION['GetCode']) {
        unset($_SESSION['GetCode']);
        header('Location: ./resetpws.php');
    } else {
        $_SESSION['error-saixacthuc']="error-saixacthuc";
        header('Location: ./checkcode.php');
    }
}
if(isset($_GET['repasswd'])){
    $_SESSION['namecheck']=$_GET['repasswd'];
    header('Location: ./resetpws.php');
}
if(isset($_POST['repass'])&&isset($_POST['repass2'])){
    if(isset($_SESSION['error-repass']))
        unset($_SESSION['error-repass']);
    $repass = $_POST['repass'];
    $repass2 = $_POST['repass2'];
    if($repass == $repass2){
        $namecheck = $_SESSION['namecheck'];
        unset($_SESSION['namecheck']);
        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
        $query = "UPDATE `tai khoan` SET `password`='" . md5($repass) . "' WHERE `use name`='" . $namecheck . "'";
        mysqli_query($connect, $query);
        $connect->close();
        header('Location: ./');
    } else {
        $_SESSION['error-repass']="error-repass";
        header('Location: ./resetpws.php');
    }
}
if(isset($_GET['spcuthe'])){
    $_SESSION['spcuthe'] = $_GET['spcuthe'];
    header('Location: ./themsanphamthucte.php');
}
if(isset($_GET['backtohome'])){
    if(isset($_SESSION['khachhang']))
        header('Location: ./'); 
    else if(isset($_SESSION['admin']))
        header('Location: ./admin/'); 
    else header('Location: ./'); 
}
if(isset($_SESSION['User']) && isset($_POST['thongtinnd-name']) && isset($_POST['thongtinnd-ngaysinh']) && isset($_POST['thongtinnd-cmnd'])){
    $email = $_SESSION['User'];
    $name = $_POST['thongtinnd-name'];
    $ngaysinh = $_POST['thongtinnd-ngaysinh'];
    $cmnd = $_POST['thongtinnd-cmnd'];
    $tel = $_POST['thongtinnd-tel'];
    $diachi = $_POST['thongtinnd-diachicuthe'].", ".$_POST['thongtinnd-diachi3cap'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$email."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    if(!empty($data))
    if($data[0]['ma ad'] != "00000"){
        $query = "UPDATE `admin` SET `ho ten ad`='".$name."',`ngay sinh`='".$ngaysinh."',`so dien thoai`='".$tel."',`dia chi`='".$diachi."',`email`='".$email."',`cmnd`='".$cmnd."' WHERE `ma ad`='".$data[0]['ma ad']."'";
        $datasql = mysqli_query($connect, $query);
    }else {
        $query = "UPDATE `khach hang` SET `ho ten kh`='".$name."',`ngay sinh kh`='".$ngaysinh."',`dia chi`='".$diachi."',`sdt`='".$tel."',`cmnd`='".$cmnd."' WHERE `ma kh`='".$data[0]['ma kh']."'";
        $datasql = mysqli_query($connect, $query);
    }
    $connect->close();
    header('Location: ./');
}
if(isset($_SESSION['admin']) && isset($_POST['themsp-name']) && isset($_POST['themsp-gia'])&& isset($_POST['themsp-maloai'])){
    $masp = $_POST['themsp-masp'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `san pham` WHERE `ma sp`='".$masp."'";
    $datasql = mysqli_query($connect, $query);
    $name = $_POST['themsp-name'];
    $hbh = $_POST['themsp-hbh'];
    $loaihbh = $_POST['themsp-loaihbh'];
    $hbh = $hbh * $loaihbh;
    $gia = str_replace(".","",$gia);
    $gia = str_replace("đ","",$gia);
    $maloai = $_POST['themsp-maloai'];
    $thongso = $_POST['themsp-thongso'];
    $mota = $_POST['themsp-mota'];
    if(mysqli_num_rows($datasql)==0){
        $folder = "./uploads/";
        $file_path = $folder . $_FILES['themsp-anh']['name'][0];
        move_uploaded_file($_FILES['themsp-anh']['tmp_name'][0], $file_path);
        $query = "INSERT INTO `san pham`(`ma sp`, `ma loai sp`, `ten sp`, `gia sp`, `mo ta san pham`,`han bao hanh`, `hinh anh`) VALUES ('".$masp."','".$maloai."','".$name."','".$gia."','".$mota."','".$hbh."','".$file_path."')";
        $datasql = mysqli_query($connect, $query);
        $thongso = nl2br($thongso);
        $ts = explode('<br />',$thongso);
        foreach($ts as $tso){
            unset($thso);
            unset($data);
            $thso = explode(': ',$tso);
            $thso[0] = trim($thso[0]);
            
            $query = "SELECT `ma ts` FROM `thong so ky thuat` WHERE `tom tat`='".$thso[0]."'";
            $datasql = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            }
            $query = "INSERT INTO `chi tiet thong so`(`ma sp`, `ma ts`, `gia tri thong so`) VALUES ('".$masp."','".$data[0]['ma ts']."','".$thso[1]."')";
            $datasql = mysqli_query($connect, $query);
        }
    }
    $connect->close();
    header('Location: ./admin/quanlysanpham.php');
}
if(isset($_SESSION['admin']) && isset($_POST['khuyenmaisp-namekm'])){
    $makm = $_POST['khuyenmaisp-makm'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `khuyen mai` WHERE `ma khuyen mai`='".$makm."'";
    $datasql = mysqli_query($connect, $query);
    $namekm = $_POST['khuyenmaisp-namekm'];
    $bdkm = $_POST['khuyenmaisp-bdkm'];
    $ktkm = $_POST['khuyenmaisp-ktkm'];
    if(mysqli_num_rows($datasql)==0){
        $query = "INSERT INTO `khuyen mai`(`ma khuyen mai`, `ten khuyen mai`, `tg bat dau`, `tg ket thuc`) VALUES ('".$makm."','".$namekm."','".$bdkm."','".$ktkm."')";
        mysqli_query($connect, $query);
    } else {
        $query = "UPDATE `khuyen mai` SET `ten khuyen mai`='".$namekm."',`tg bat dau`='".$bdkm."',`tg ket thuc`='".$ktkm."' WHERE `ma khuyen mai`='".$makm."'";
        mysqli_query($connect, $query);
    }
    $connect->close();
    header('Location: ./admin/quanlikhuyenmai.php');
}
if(isset($_SESSION['khachhang']) && isset($_SESSION['User']) && isset($_POST['maspchogiohang']) && isset($_POST['soluong'])){
    $email = $_SESSION['User'];
    $masp = $_POST['maspchogiohang'];
    $sl = $_POST['soluong'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT `ma kh` FROM `tai khoan` WHERE `use name`='".$email."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `ma kh`='".$data[0]['ma kh']."' AND `tinh trang`='0'";
    $datasql = mysqli_query($connect, $query);
    if(mysqli_num_rows($datasql)==0){
        $magh = date('dHis');
        $mahd = date('mdHis');
        $query = "INSERT INTO `gio hang`(`ma gh`, `tinh trang`) VALUES ('".$magh."','0')";
        $datasql = mysqli_query($connect, $query);
        $query = "INSERT INTO `hoa don`(`so hd`, `ma gh`, `ma ad`, `ma kh`, `ngay lap`) VALUES ('".$mahd."','".$magh."','00000','".$data[0]['ma kh']."','');";
        $datasql = mysqli_query($connect, $query);
        $query = "INSERT INTO `chi tiet gio hang`(`ma sp`, `ma gh`, `so luong`) VALUES ('".$masp."','".$magh."','".$sl."')";
        $datasql = mysqli_query($connect, $query);
    } else {
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data1[] = $row;
        }
        $query = "SELECT * FROM `chi tiet gio hang` WHERE `ma sp`='".$masp."' AND `ma gh`='".$data1[0]['ma gh']."'";
        $datasql = mysqli_query($connect, $query);
        if(mysqli_num_rows($datasql)==0){
            $query = "INSERT INTO `chi tiet gio hang`(`ma sp`, `ma gh`, `so luong`) VALUES ('".$masp."','".$data1[0]['ma gh']."','".$sl."')";
            $datasql = mysqli_query($connect, $query);
        } else {
            $query = "UPDATE `chi tiet gio hang` SET `so luong`='".$sl."' WHERE `ma sp`='".$masp."' AND `ma gh`='".$data1[0]['ma gh']."'";
            $datasql = mysqli_query($connect, $query);
        }
    }
    $connect->close();
    header('Location: ./');
}
if(isset($_SESSION['khachhang']) && isset($_SESSION['User']) && isset($_GET['xoaspgiohang'])){
    $email = $_SESSION['User'];
    $masp = $_GET['xoaspgiohang'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT `ma kh` FROM `tai khoan` WHERE `use name`='".$email."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "SELECT * FROM `hoa don` a JOIN `gio hang` b ON (a.`ma gh`=b.`ma gh`) WHERE `ma kh`='".$data[0]['ma kh']."' AND `tinh trang`='0'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data1[] = $row;
    }
    $query = "DELETE FROM `chi tiet gio hang` WHERE `ma sp`='".$masp."' AND `ma gh`='".$data1[0]['ma gh']."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./');
}
if(isset($_GET['troveqlsp'])){
    unset($_SESSION['spcuthe']);
    header('Location: ./admin/quanlysanpham.php');
}
if(isset($_GET['dangnhaplai'])){
    $_SESSION['dangnhaplai']="on";
    header('Location: ./');
}
if(isset($_SESSION['admin']) && isset($_GET['donhang']) && isset($_GET['tinhtrangdonhang'])){
    $ma = $_GET['donhang'];
    $tinhtrang = $_GET['tinhtrangdonhang'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    if($tinhtrang==1){
        $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' AND `so hd`='".$_GET['donhang']."') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        for($i=0; $i<  count($data); $i++){
            $masp = $data[$i]['ma sp'];
            $query = "SELECT a.* FROM `san pham cu the` a JOIN `phieu bao hanh` b ON (a.`so seri`=b.`so seri`) WHERE `so hd`='0' AND `ma sp`='".$masp."'";
            $datasql = mysqli_query($connect, $query);
            unset($data1);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data1[] = $row;
            }
            if(!empty($data1)){
                if(count($data1) >= $data[$i]['so luong']){
                    for($j=0; $j < $data[$i]['so luong']; $j++){
                        $query = "UPDATE `phieu bao hanh` SET `so hd`='".$ma."', `ngay bao hanh`='".date("Y-m-d")."' WHERE `so seri`='".$data1[$j]['so seri']."'";
                        $datasql = mysqli_query($connect, $query);
                    }
                    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$_SESSION['User']."'";
                    $datasql = mysqli_query($connect, $query);
                    unset($data2);
                    while ($row = mysqli_fetch_array($datasql, 1)) {
                        $data2[] = $row;
                    }
                    $query = "UPDATE `hoa don` SET `ma ad`='".$data2[0]['ma ad']."',`ngay lap`='".date("Y-m-d H:i:s")."' WHERE `so hd`='".$_GET['donhang']."'";
                    $datasql = mysqli_query($connect, $query);
                    $query = "UPDATE `gio hang` SET `tinh trang`='2' WHERE `ma gh`='".$data[$i]['ma gh']."'";
                    $datasql = mysqli_query($connect, $query);
                } else {
                    $_SESSION['thieuhang']=$data[$i]['ma sp'];
                }
            }
        }
        
    } else if($tinhtrang==2){
        $query = "SELECT * FROM `hoa don` WHERE `so hd`='".$_GET['donhang']."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        $query = "UPDATE `gio hang` SET `tinh trang`='3' WHERE `ma gh`='".$data[0]['ma gh']."'";
        $datasql = mysqli_query($connect, $query);
    }
    $connect->close();
    header('Location: ./admin/donhang.php');
}
if( isset($_GET['huydonhang'])){
    $ma = $_GET['huydonhang'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' AND `so hd`='".$_GET['huydonhang']."') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`)";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "UPDATE `gio hang` SET `tinh trang`='4' WHERE `ma gh`='".$data[0]['ma gh']."'";
    mysqli_query($connect, $query);
    $query = "UPDATE `phieu bao hanh` SET `so hd`='0', `ngay bao hanh`='' WHERE `so hd`='".$ma."'";
    mysqli_query($connect, $query);
    $connect->close();
    if(isset($_SESSION['admin']))
    header('Location: ./admin/donhang.php');
    else 
    header('Location: ./dsdonhang.php');
}
if (isset($_POST['mahd']) && isset($_POST['xa_phuong']) && isset($_SESSION['khachhang'])) {
    $mahd = $_POST['mahd'];
    $diachi = $_POST['sonha'] . ", " . $_POST['xa_phuong'];
    $time = date("Y-m-d H:i:s");
    $hinhthuc = $_POST['hinhthuc'];
    $sdt = $_POST['sdtdathang'];
    $uname = $_SESSION['User'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    if ($hinhthuc == 0){
        $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$uname."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data1[] = $row;
        }
        $query = "UPDATE `khach hang` SET `sdt`='".$sdt."' WHERE `ma kh`='".$data1[0]['ma kh']."'";
        $datasql = mysqli_query($connect, $query);
        $query = "UPDATE `hoa don` SET `dia chi giao`='".$diachi."',`ngay lap`='".date("Y-m-d H:i:s")."' WHERE `so hd`='".$mahd."'";
        $datasql = mysqli_query($connect, $query);
        $query = "SELECT * FROM `hoa don`  WHERE `so hd`='".$mahd."'";
        $datasql = mysqli_query($connect, $query);
        unset($data1);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data1[] = $row;
        }
        $query = "UPDATE `gio hang` SET `tinh trang`='1' WHERE `ma gh`='".$data1[0]['ma gh']."'";
        $datasql = mysqli_query($connect, $query);
        header('Location: ./');
    }
    
    if ($hinhthuc == 1){
        $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$uname."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data1[] = $row;
        }
        $query = "UPDATE `khach hang` SET `sdt`='".$sdt."' WHERE `ma kh`='".$data1[0]['ma kh']."'";
        $datasql = mysqli_query($connect, $query);
        $query = "UPDATE `hoa don` SET `dia chi giao`='".$diachi."',`ngay lap`='".date("Y-m-d H:i:s")."' WHERE `so hd`='".$mahd."'";
        $datasql = mysqli_query($connect, $query);
        header('Location: ./thanhtoanvnpay/?thanhtoan=' . $mahd);
    }
    $connect->close();
        
}
if(isset($_GET['madhduyet'])){
    $magh = $_GET['madhduyet'];
    $thaotac = 1;
    $soluong = 0;
    if(isset($_GET['tang'])){
        $masp = $_GET['tang'];
    } else if(isset($_GET['giam'])){
        $thaotac = -1;
        $masp = $_GET['giam'];
    } else if(isset($_GET['thaydoi'])){
        $masp = $_GET['thaydoi'];
    }
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT  `so luong` FROM `chi tiet gio hang` WHERE `ma sp`='".$masp."' AND `ma gh`='".$magh."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "SELECT b.*, a.* FROM `san pham cu the` a JOIN `phieu bao hanh` b ON (a.`so seri`=b.`so seri`) WHERE b.`ngay bao hanh`='0000-00-00' AND `ma sp`='".$masp."'";
    $datasql = mysqli_query($connect, $query);
    $tongsosp = mysqli_num_rows($datasql);
    $soluong = $data[0]['so luong'] + $thaotac ;
    if(isset($_GET['thaydoi'])){
        $masp = $_GET['thaydoi'];
        $soluong = (int) $_GET['soluong'];
    } 
    
    
    if($soluong == 0){
        $soluong = 1;
    } else if($soluong > $tongsosp){
        $soluong = $tongsosp;
    }
    $query = "UPDATE `chi tiet gio hang` SET `so luong`='".$soluong."'  WHERE `ma sp`='".$masp."' AND `ma gh`='".$magh."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./giohang.php');
}
if(isset($_SESSION['admin']) && isset($_POST['loaisp-ma'])){
    $ma = $_POST['loaisp-ma'];
    $name = $_POST['loaisp-name'];
    $mancc = $_POST['loaisp-mancc'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `loai san pham` WHERE `ma loai sp`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    if(mysqli_num_rows($datasql) != 0){
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        $query = "UPDATE `loai san pham` SET `ten loai sp`='".$name."',`ma ncc`='".$mancc."' WHERE `ma loai sp`='".$ma."'";
        $datasql = mysqli_query($connect, $query);
    } else {
        $query = "INSERT INTO `loai san pham`(`ma loai sp`, `ten loai sp`, `ma ncc`) VALUES ('".$ma."','".$name."','".$mancc."')";
        $datasql = mysqli_query($connect, $query);
    }
    $connect->close();
    header('Location: ./admin/quanliloaisp.php');
}
if(isset($_SESSION['admin']) && isset($_GET['xoaloaisp'])){
    $ma = $_GET['xoaloaisp'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "UPDATE `san pham` SET `ma loai sp`='0' WHERE `ma loai sp`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $query = "DELETE FROM `loai san pham` WHERE `ma loai sp`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./admin/quanliloaisp.php');
}
if(isset($_SESSION['admin']) && isset($_POST['suasp-name']) && isset($_POST['suasp-gia'])&& isset($_POST['suasp-maloai'])){
    $masp = $_POST['suasp-masp'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `san pham` WHERE `ma sp`='".$masp."'";
    $datasql = mysqli_query($connect, $query);

    $name = $_POST['suasp-name'];
    $gia = $_POST['suasp-gia'];
    $gia = str_replace(".","",$gia);
    $gia = str_replace("đ","",$gia);
    $hbh = $_POST['suasp-hbh'];
    $loaihbh = $_POST['suasp-loaihbh'];
    $hbh = $hbh * $loaihbh;
    $maloai = $_POST['suasp-maloai'];
    $thongso = $_POST['suasp-thongso'];
    $mota = $_POST['suasp-mota'];
    if(mysqli_num_rows($datasql)!=0){
        $query = "UPDATE `san pham` SET `ma loai sp`='".$maloai."',`ten sp`='".$name."',`gia sp`='".$gia."',`han bao hanh`='".$hbh."',`mo ta san pham`='".$mota."' WHERE `ma sp`='".$masp."'";
        $datasql = mysqli_query($connect, $query);
        $thongso = nl2br($thongso);
        $ts = explode('<br />',$thongso);
        $query = "DELETE FROM `chi tiet thong so` WHERE `ma sp`='".$masp."'";
        $datasql = mysqli_query($connect, $query);
        foreach($ts as $tso){
            unset($thso);
            unset($data);
            $thso = explode(': ',$tso);
            $thso[0] = trim($thso[0]);
            $query = "SELECT `ma ts` FROM `thong so ky thuat` WHERE `tom tat`='".$thso[0]."'";
            $datasql = mysqli_query($connect, $query);
            while ($row = mysqli_fetch_array($datasql, 1)) {
                $data[] = $row;
            }
            $query = "INSERT INTO `chi tiet thong so`(`ma sp`, `ma ts`, `gia tri thong so`) VALUES ('".$masp."','".$data[0]['ma ts']."','".$thso[1]."')";
            $datasql = mysqli_query($connect, $query);
        }
    }
    $connect->close();
    header('Location: ./admin/quanlysanpham.php');
}
if(isset($_SESSION['admin']) && isset($_POST['ncc-ma'])){
    $ma = $_POST['ncc-ma'];
    $name = $_POST['ncc-name'];
    $diachi = $_POST['ncc-diachi'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `nha cung cap` WHERE `ma ncc`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    if(mysqli_num_rows($datasql) != 0){
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data[] = $row;
        }
        $query = "UPDATE `nha cung cap` SET `ten ncc`='".$name."',`dia chi ncc`='".$diachi."' WHERE `ma ncc`='".$ma."'";
        $datasql = mysqli_query($connect, $query);
    } else {
        $query = "INSERT INTO `nha cung cap`(`ma ncc`, `ten ncc`, `dia chi ncc`) VALUES ('".$ma."','".$name."','".$diachi."')";
        $datasql = mysqli_query($connect, $query);
    }
    $connect->close();
    header('Location: ./admin/quanlinhacungcap.php');
}
if(isset($_SESSION['admin']) && isset($_GET['xoasanphamnay'])){
    $ma = $_GET['xoasanphamnay'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "UPDATE `san pham` SET `han bao hanh`='-1000' WHERE `ma sp`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./admin/quanlysanpham.php');
}
if(isset($_SESSION['admin']) && isset($_GET['xoanhacungcapnay'])){
    $ma = $_GET['xoanhacungcapnay'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "UPDATE `loai san pham` SET `ma ncc`='0' WHERE `ma ncc`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $query = "DELETE FROM `nha cung cap` WHERE `ma ncc`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./admin/quanlinhacungcap.php');
}
if(isset($_SESSION['admin']) && isset($_GET['xoanguoidung'])){
    $ma = $_GET['xoanguoidung'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "UPDATE `tai khoan` SET `password`='_!".$data[0]['password']."' WHERE `use name`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./admin/khachhang.php');
}
if(isset($_SESSION['admin']) && isset($_GET['xoakhuyenmainay'])){
    $ma = $_GET['xoakhuyenmainay'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "DELETE FROM `chi tiet khuyen mai` WHERE `ma khuyen mai`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $query = "DELETE FROM `khuyen mai` WHERE `ma khuyen mai`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./admin/quanlikhuyenmai.php');
}
if(isset($_SESSION['admin']) && isset($_POST['khuyenmaisp-ma'])){
    $ma = $_POST['khuyenmaisp-ma'];
    $loai = $_POST['khuyenmaisp-loaikm'];
    $phantram = $_POST['khuyenmaisp-km'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "INSERT INTO `chi tiet khuyen mai`(`ma sp`, `ma khuyen mai`, `phan tram khuyen mai`) VALUES ('".$ma."','".$loai."','".$phantram ."')";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./admin/quanlysanpham.php');
}
if(isset($_SESSION['khachhang']) && isset($_POST['masp-danhgia'])){
    $ma = $_POST['masp-danhgia'];
    $star = $_POST['star'];
    $danhgia = $_POST['danhgia'];
    $mabl = date("mdHis");
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "SELECT * FROM `tai khoan` WHERE `use name`='".$_SESSION['User']."'";
    $datasql = mysqli_query($connect, $query);
    while ($row = mysqli_fetch_array($datasql, 1)) {
        $data[] = $row;
    }
    $query = "INSERT INTO `binh luan`(`ma bldg`, `ma sp`, `ma kh`, `nd binh luan`, `diem dg`) VALUES ('".$mabl."','".$ma."','".$data[0]['ma kh']."','".$danhgia."','".$star."')";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: ./sanpham.php?search='.$ma);
}
if((isset($_SESSION['khachhang']) || isset($_SESSION['admin']))&& isset($_GET['xoabldg'])){
    $ma = $_GET['xoabldg'];
    $connect = new mysqli("localhost", "root", "", "mobile");
    mysqli_set_charset($connect, "utf8");
    $query = "DELETE FROM `binh luan` WHERE `ma bldg`='".$ma."'";
    $datasql = mysqli_query($connect, $query);
    $connect->close();
    header('Location: '.$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['xoatimkiem'])){
    for($i=$_GET['xoatimkiem']; $i < $_SESSION['tmp']-1; $i++){
        $_SESSION['dasearch'.$i]=$_SESSION['dasearch'.i+1];
    }
    unset($_SESSION['dasearch'.$_SESSION['tmp']-1]);
    $_SESSION['tmp']--;
    // header('Location: '.$_SERVER['HTTP_REFERER']);
}
?>