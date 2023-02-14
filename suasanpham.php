<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="icon" href="img/logo_n.png" />
    <title>Moblie Thảo Linh | Đăng kí</title>
    <link rel="stylesheet" type="text/css" href="css/themsanpham.css">
    <!-- <script type="text/javascript" async="" src="./js/login.js"></script> -->
    <?php if (session_id() === '')
        session_start(); 
        date_default_timezone_set("Asia/Ho_Chi_Minh");
        $connect = new mysqli("localhost", "root", "", "mobile");
        mysqli_set_charset($connect, "utf8");
        $query = "SELECT * FROM `san pham` WHERE `ma sp`='".$_GET['ma']."'";
        $datasql = mysqli_query($connect, $query);
        while ($row = mysqli_fetch_array($datasql, 1)) {
            $data1[] = $row;
        }
        $connect->close();
    ?>
</head>

<body>
    <?php if(!empty($_GET)){ ?>
    <form action="./server.php" method="POST" enctype="multipart/form-data">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Sửa thông tin sản phẩm</h1>
                    <div class="container">
                        <div class="item1">
                            <input type="text" value="<?php echo $_GET['ma']?>" name="suasp-masp" hidden>
                            <div class="namesp">
                                <input type="text" name="suasp-name" value="<?php echo $_GET['ten'] ?>" class="inputText"  placeholder="Vui lòng nhập tên sản phẩm"
                                    required />

                            </div>
                            <div class="gia">
                                <input type="text" name="suasp-gia" value="<?php echo $_GET['gia'] ?>" class="inputText" placeholder="Vui lòng nhập giá sản phẩm"
                                    required />

                            </div>
                            <div class="loaisp">
                                <select name="suasp-maloai" class="inputText" required>
                                    <option value="<?php echo $_GET['maloai'] ?>"><?php echo $_GET['loai'] ?></option>
                                    <?php 
                                    $connect = new mysqli("localhost", "root", "", "mobile");
                                    mysqli_set_charset($connect, "utf8");
                                    $query = "SELECT * FROM `loai san pham`";
                                    $datasql = mysqli_query($connect, $query);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data[] = $row;
                                    }
                                    $connect->close();
                                    if(!empty($data)){
                                        for($tmp=0;$tmp<count($data);$tmp++){
                                            ?>
                                            <option value="<?php echo $data[$tmp]['ma loai sp'] ?>"><?php echo $data[$tmp]['ten loai sp'] ?></option>
                                            <?php
                                        }
                                    }
                                    ?>
                                </select>
                            </div>
                            
                            <div class="hanbaohanh" style="display:flex">
                                <input type="number" name="suasp-hbh" class="inputText" style="width:60%;" min="0" placeholder="Thời gian bảo hành" value="<?php if($data1[0]['han bao hanh']/365 >= 1) echo $data1[0]['han bao hanh']/365; else if($data1[0]['han bao hanh']/365 < 1 && $data1[0]['han bao hanh']/365 >= 0) echo $data1[0]['han bao hanh']/30; else echo "0";?>" required />
                                <select name="suasp-loaihbh" class="inputText" style="width:40%;">
                                    <option value="365" <?php if(round($data1[0]['han bao hanh']/365,0) >= 1) echo "selected"; ?>>Năm</option>
                                    <option value="30" <?php if(round($data1[0]['han bao hanh']/365,0)  < 1) echo "selected"; ?>>Tháng</option>
                                </select>
                            </div>
                        </div>
                        <div class="item2">
                            <div class="themthongso">
                                <div class="thongso">
                                    <select id="thongso" class="inputText" >
                                        <option>Thông số sản phẩm</option>
                                        <?php 
                                            $connect = new mysqli("localhost", "root", "", "mobile");
                                            mysqli_set_charset($connect, "utf8");
                                            $query = "SELECT * FROM `thong so ky thuat`";
                                            $datasql = mysqli_query($connect, $query);
                                            $connect->close();
                                            unset($data);
                                            while ($row = mysqli_fetch_array($datasql, 1)) {
                                                $data[] = $row;
                                            }
                                            if(!empty($data)){
                                                for($tmp=0;$tmp<count($data);$tmp++){
                                                    ?>
                                                    <option value="<?php echo $data[$tmp]['tom tat'] ?>"><?php echo $data[$tmp]['tom tat'] ?></option>
                                                    <?php
                                                }
                                            }
                                        ?>
                                    </select>
                                </div>
                                <span>:</span>
                                <div class="giatrithongso">
                                    <input type="text" class="inputText" id="giatrithongso"
                                        placeholder="Giá trị thông số" />
                                </div>
                            </div>
                            <input type="button"  class="register-buttton" value="Thêm thông số"
                                onclick="thongsochitiet.value = thongsochitiet.value+thongso.value+': '+giatrithongso.value+'\n'">
                            <div class="thongsochitiet">
                                <textarea name="suasp-thongso" id="thongsochitiet" cols="30" rows="10"
                                    placeholder="Vui lòng chọn thông số sản phẩm ở bên trên" required><?php 
                                    
                                    $connect = new mysqli("localhost", "root", "", "mobile");
                                    mysqli_set_charset($connect, "utf8");
                                    $query = "SELECT * FROM `chi tiet thong so` a JOIN `thong so ky thuat` b ON (a.`ma ts`=b.`ma ts`) WHERE `ma sp`='".$_GET['ma']."'";
                                    $datasql = mysqli_query($connect, $query);
                                    unset($data1);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data1[] = $row;
                                    }
                                    $connect->close();
                                    if(!empty($data1))
                                    for($i = 0 ; $i < count($data1) ; $i++){
                                        echo $data1[$i]['tom tat'].": ".$data1[$i]['gia tri thong so']."\n";
                                    }
                                ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="motasp">
                        <textarea name="suasp-mota" id="mota" cols="30" rows="10"
                            placeholder="Vui lòng nhập mô tả sản phẩm" required><?php 
                                    
                                    $connect = new mysqli("localhost", "root", "", "mobile");
                                    mysqli_set_charset($connect, "utf8");
                                    $query = "SELECT * FROM `san pham`  WHERE `ma sp`='".$_GET['ma']."'";
                                    $datasql = mysqli_query($connect, $query);
                                    unset($data1);
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data1[] = $row;
                                    }
                                    $connect->close();
                                    echo $data1[0]['mo ta san pham'];
                                ?></textarea>
                    </div>
                    <input type="submit" class="register-buttton" value="Cập nhật sản phẩm" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>
    <?php }?>
</body>

</html>