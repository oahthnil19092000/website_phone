<!DOCTYPE html>
<html>

<head>
    <link rel="icon" href="../img/icon.png">
    <title>Thanh Toán</title>
</head>

<body>
<style>
    @import url(https://fonts.googleapis.com/css?family=Lato:400,300,700);
    body,html {
        
    height:100%;
    margin:0;
    font-family: 'Montserrat', sans-serif;
    }
  
    #bank_code{
        border-radius:10px;
        border: 1px solid black;
        background-color: whitesmoke;
        width:350px;
        height:50px;
        font-size: 18px;
    }
    #order_desc{
        border-radius:10px;
        border: 1px solid black;
        background-color: whitesmoke;
        font-size: 18px;
    }
    b{
        width:350px;
        height:50px;
        font-size: 18px;
    }
    h2 {
        margin-bottom:0px;
        margin-top:25px;
        text-align:center;
        font-weight:200;
        font-size:19px;
        font-size:1.2rem;
    }
    .container {
        height:100%;
        -webkit-box-pack:center;
        -webkit-justify-content:center;
            -ms-flex-pack:center;
                justify-content:center;
        -webkit-box-align:center;
        -webkit-align-items:center;
            -ms-flex-align:center;
                align-items:center;
        display:-webkit-box;
        display:-webkit-flex;
        display:-ms-flexbox;
        display:flex;
        background:-webkit-linear-gradient(#c5e5e5, #ccddf9);
        background:linear-gradient(#c9e5e9,#ccddf9);
    }
    .dropdown-select.visible {
        display:block;
    }
    .dropdown {
        position:relative;
    }
    ul {
        margin:0;
        padding:0;
    }
    ul li {
        list-style:none;
        padding-left:10px;
        cursor:pointer;
    }
    ul li:hover {
        background:rgba(255,255,255,0.1);
    }
    .dropdown-select {
        position:absolute;
        background:#77aaee;
        text-align:left;
        box-shadow:0px 3px 5px 0px rgba(0,0,0,0.1);
        border-bottom-right-radius:5px;
        border-bottom-left-radius:5px;
        width:90%;
        left:2px;
        line-height:2em;
        margin-top:2px;
        box-sizing:border-box;
    }
    .thin {
        font-weight:400;
    }
    .small {
        font-size:12px;
        font-size:.8rem;
    }
    .half-input-table {
        border-collapse:collapse;
        width:100%;
    }
    .half-input-table td:first-of-type {
        border-right:10px solid #4488dd;
        width:50%;
    }
    .window {
        height:540px;
        width:800px;
        background:#fff;
        display:-webkit-box;
        display:-webkit-flex;
        display:-ms-flexbox;
        display:flex;
        box-shadow: 0px 15px 50px 10px rgba(0, 0, 0, 0.2);
        border-radius:30px;
        z-index:10;
    }
    .order-info {
        background:#ffcbe3;
        height:100%;
        width:50%;
        padding-left:25px;
        padding-right:25px;
        box-sizing:border-box;
        display:-webkit-box;
        display:-webkit-flex;
        display:-ms-flexbox;
        display:flex;
        -webkit-box-pack:center;
        -webkit-justify-content:center;
        -ms-flex-pack:center;
        justify-content:center;
        position:relative;
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
    }
    .price {
    bottom:0px;
    position:absolute;
    right:0px;
    color:#4488dd;
    }
    .order-table td:first-of-type {
    width:25%;
    }
    .order-table {
        position:relative;
    }
    .line {
        height: 2px;
        width: 100%;
        margin-top: 10px;
        margin-bottom: 10px;
        background: #ffffff;
    }
    .order-table td:last-of-type {
    vertical-align:top;
    padding-left:25px;
    }
    .order-info-content {
    table-layout:fixed;

    }

    .full-width {
    width:100%;
    }
    .pay-btn {
    border:none;
    background:#f22a98;
    line-height:2em;
    border-radius:10px;
    font-size:19px;
    font-size:1.2rem;
    color:#fff;
    cursor:pointer;
    position:absolute;
    bottom:25px;
    width:calc(100% - 50px);
    -webkit-transition:all .2s ease;
            transition:all .2s ease;
    }
    .pay-btn:hover {
    background:#22a877;
        color:#eee;
    -webkit-transition:all .2s ease;
            transition:all .2s ease;
    }

    .total {
    margin-top:25px;
    font-size:20px;
    font-size:1.3rem;
    position:absolute;
    bottom:30px;
    right:27px;
    left:35px;
    }
    .dense {
    line-height:1.2em;
    font-size:16px;
    font-size:1rem;
    }
    .input-field {
    background:rgba(255,255,255,0.1);
    margin-bottom:10px;
    margin-top:3px;
    line-height:1.5em;
    font-size:20px;
    font-size:1.3rem;
    border:none;
    padding:5px 10px 5px 10px;
    color:#fff;
    box-sizing:border-box;
    width:100%;
    margin-left:auto;
    margin-right:auto;
    }
    .credit-info {
        background:#ffcbe3;
        height:100%;
        width:50%;
        color: #000;
        -webkit-box-pack:center;
        -webkit-justify-content:center;
            -ms-flex-pack:center;
                justify-content:center;
        font-size:14px;
        font-size:.9rem;
        display:-webkit-box;
        display:-webkit-flex;
        display:-ms-flexbox;
        display:flex;
        box-sizing:border-box;
        padding-left:25px;
        padding-right:25px;
        border-top-right-radius:30px;
        border-bottom-right-radius:30px;
        position:relative;
    }
    .dropdown-btn {
    background:rgba(255,255,255,0.1);
    width:100%;
    color:white;
    border-radius:5px;
    text-align:center;
    line-height:1.5em;
    cursor:pointer;
    position:relative;
    -webkit-transition:background .2s ease;
            transition:background .2s ease;
    }
    .dropdown-btn *{
        background:rgba(87,148,224);
    }
    .dropdown-btn:after {
    content: '\25BE';
    right:8px;
    position:absolute;
    }
    .dropdown-btn:hover {
    background:rgba(255,255,255,0.2);
    -webkit-transition:background .2s ease;
            transition:background .2s ease;
    }
    .dropdown-select {
    display:none;
    }
    .credit-card-image {
    display:block;
    height:160px;
    margin-left:auto;
    margin-right:auto;
    margin-top:0px;
    margin-bottom:0px;
    }
    .credit-info-content {
    margin-top:25px;
    -webkit-flex-flow:column;
        -ms-flex-flow:column;
            flex-flow:column;
    display:-webkit-box;
    display:-webkit-flex;
    display:-ms-flexbox;
    display:flex;
    width:100%;
    }
    @media (max-width: 600px) {
    .window {
        width: 100%;
        height: 100%;
        display:block;
        border-radius:0px;
    }
    .order-info {
        width:100%;
        height:auto;
        padding-bottom:100px;
        border-radius:0px;
    }
    .credit-info {
        width:100%;
        height:auto;
        padding-bottom:100px;
        border-radius:0px;
    }
    .pay-btn {
        border-radius:0px;
    }
    
    }
</style>
<div class='container'>
    <div class='window'>
        <div class='order-info'>
            <div class='order-info-content'>
            <h2>Danh sách sản phẩm</h2>
            <div class='line'></div>

            <div class="dssp" style="overflow: auto;height: 370px;width:380px">
                <?php 
                    function insertAt($a,$x){
                        return substr($a,0,$x).",".substr($a,$x,strlen($a));
                    }
                    $mahd = $_GET['thanhtoan'];
                    unset($data2);
                    $tongtien=0;
                    $tongsoluong=0;
                    $connect = new mysqli("localhost","root","","mobile");
                    mysqli_set_charset($connect,"utf8");
                    $query = "SELECT `ten sp`, `gia sp`, `hinh anh`,b.* FROM `san pham` a JOIN (SELECT `ma sp`, `so luong`,b.* FROM `chi tiet gio hang` a JOIN (SELECT `tinh trang`,b.* FROM `gio hang` a JOIN (SELECT `so hd`,`ma gh`,`ma ad`,`ngay lap`,b.* FROM `hoa don` a JOIN `khach hang` b ON (a.`ma kh`=b.`ma kh`) WHERE a.`ma kh`!='00000' AND a.`so hd`='".$mahd."') b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma gh`=b.`ma gh`)) b ON (a.`ma sp`=b.`ma sp`) ";
                    $datasql = mysqli_query($connect,$query);
                    while($row = mysqli_fetch_array($datasql,1)){
                        $data[]= $row;
                    }
                    for($i = 0 ; $i < count($data) ; $i++ ){
                        
                            ?>
                            
                            <div class="sp">
                                <div class="thông tin" style="float:right;width:230px">
                                    <?php echo $data[$i]['ten sp'];
                                    if(strlen($data[$i]['ten sp'])<=80)
                                        echo ".<br><br><br>";
                                    else if(strlen($data[$i]['ten sp'])>80&&strlen($data3[0]['ten sp'])<=120)
                                        echo ".<br><br>";
                                    else if(strlen($data[$i]['ten sp'])>120&&strlen($data3[0]['ten sp'])<=160)
                                        echo ".<br>";
                                    $tongsoluong += $data[$i]["so luong"];
                                    echo "Số lượng: ".$data[$i]["so luong"]."  Giá: ";
                                    $gia = $data[$i]['gia sp'];
                                    $tongtien += $gia * $data[$i]["so luong"];
                                    echo number_format($gia,0,",",".");
                                    ?>
                                    
                                </div>
                                <img class="anhtronggiohang" style="width:100px;height:100px;margin:0 10px;float:left" src="<?php echo ".".$data[$i]['hinh anh'];?>"/>
                                <div style="clear:both"></div>    
                                <div class='line'></div>
                            </div>
                                                       
                            <?php
                        }      
                    $connect->close();
                ?>
            </div>

            <div class='total'>
            <span style='float:left;'>
                <div class='thin dense'>Số sản phẩm</div>
                <div class='thin dense'>VAT</div>
                Thành tiền
            </span>
            <span style='float:right; text-align:right;'>
                <div class='thin dense'><?php echo $tongsoluong?></div>
                <div class='thin dense'>Đã bao gồm VAT</div>
                <?php 
                    echo number_format($tongtien,0,",",".");
                ?>
            </span>
            </div>
        </div>
    </div>

        <div class='credit-info'>
          <div class='credit-info-content'>
          <div class="table-responsive">
                <form action="/webbanhang/thanhtoanvnpay/vnpay_create_payment.php" id="create_form" method="post">       

                    <div class="form-group">                    
                        <select name="order_type" id="order_type" class="form-control" hidden>
                            <option value="billpayment">Thanh toán hóa đơn</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="order_id" name="order_id" type="text" value="<?php echo $_GET['thanhtoan']; ?>" hidden/>
                    </div>
                    <div class="form-group">
                        <input class="form-control" id="amount" name="amount" type="number" value="<?php echo $tongtien;?>" hidden/>
                    </div>
                                        <div class="form-group">
                        <b>Ngân hàng:</b>
                        <select name="bank_code" id="bank_code" class="form-control">
                            <option value="">Chọn ngân hàng</option>
                            <option value="NCB"> Ngân hàng NCB</option>
                            <option value="AGRIBANK"> Ngân hàng Agribank</option>
                            <option value="SCB"> Ngân hàng SCB</option>
                            <option value="SACOMBANK">Ngân hàng SacomBank</option>
                            <option value="EXIMBANK"> Ngân hàng EximBank</option>
                            <option value="MSBANK"> Ngân hàng MSBANK</option>
                            <option value="NAMABANK"> Ngân hàng NamABank</option>
                            <option value="VNMART"> Vi dien tu VnMart</option>
                            <option value="VIETINBANK">Ngân hàng Vietinbank</option>
                            <option value="VIETCOMBANK"> Ngân hàng VCB</option>
                            <option value="HDBANK">Ngân hàng HDBank</option>
                            <option value="DONGABANK"> Ngân hàng Dong A</option>
                            <option value="TPBANK"> Ngân hàng TPBank</option>
                            <option value="OJB"> Ngân hàng OceanBank</option>
                            <option value="BIDV"> Ngân hàng BIDV</option>
                            <option value="TECHCOMBANK"> Ngân hàng Techcombank</option>
                            <option value="VPBANK"> Ngân hàng VPBank</option>
                            <option value="MBBANK"> Ngân hàng MBBank</option>
                            <option value="ACB"> Ngân hàng ACB</option>
                            <option value="OCB"> Ngân hàng OCB</option>
                            <option value="IVB"> Ngân hàng IVB</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <b>Ghi chú:</b>
                        <textarea class="form-control" cols="33" id="order_desc" name="order_desc" rows="10">Ghi chú</textarea>
                    </div>
                    <div class="form-group">
                    <select name="language" id="language" class="form-control" hidden>
                            <option value="vn">Tiếng Việt</option>
                        </select>
                    </div>

                    <button type="submit" class="btn pay-btn">Thanh toán</button>

                </form>
            </div>

        </div>
      </div>
    </div>

</body>
<script>
    
</script>

</html>