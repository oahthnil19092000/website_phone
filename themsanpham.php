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
    ?>
</head>

<body>
    <form action="./server.php" method="POST" enctype="multipart/form-data">
        <div class="content">
            <div class="wrapper">
                <div class="register--content">
                    <h1>Thêm sản phẩm mới</h1>
                    <div class="container">
                        <div class="item1">
                            <input type="text" value="<?php echo date('mdHis')?>" name="themsp-masp" hidden>
                            <div class="namesp">
                                <input type="text" name="themsp-name" class="inputText"  placeholder="Vui lòng nhập tên sản phẩm"
                                    required />

                            </div>
                            <div class="gia">
                                <input type="text" name="themsp-gia" class="inputText" placeholder="Vui lòng nhập giá sản phẩm"
                                    required />

                            </div>
                            <div class="hinhanh">
                                <input type="file" name="themsp-anh[]" accept="image/*" placeholder="Vui lòng chọn ảnh sản phẩm" required />
                            </div>
                            <div class="loaisp">
                                <select name="themsp-maloai" class="inputText" required>
                                    <option>Vui lòng chọn thương hiệu</option>
                                    <?php 
                                    $connect = new mysqli("localhost", "root", "", "mobile");
                                    mysqli_set_charset($connect, "utf8");
                                    $query = "SELECT * FROM `loai san pham`";
                                    $datasql = mysqli_query($connect, $query);
                                    $connect->close();
                                    while ($row = mysqli_fetch_array($datasql, 1)) {
                                        $data[] = $row;
                                    }
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
                                <input type="number" name="themsp-hbh" class="inputText" style="width:60%;" min="0" placeholder="Thời gian bảo hành"
                                    required />
                                <select name="themsp-loaihbh" class="inputText" style="width:40%;">
                                    <option value="365">Năm</option>
                                    <option value="30">Tháng</option>
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
                                <textarea name="themsp-thongso" id="thongsochitiet" cols="30" rows="10"
                                    placeholder="Vui lòng chọn thông số sản phẩm ở bên trên" required></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="motasp">
                        <textarea name="themsp-mota" id="mota" cols="30" rows="10"
                            placeholder="Vui lòng nhập mô tả sản phẩm" required></textarea>
                    </div>
                    <input type="submit" class="register-buttton" value="Thêm sản phẩm" name="register">
                    <button type="button" class="register-buttton" onclick="window.history.back()"> Trở lại</button>
                </div>
            </div>
        </div>
    </form>
</body>

</html>