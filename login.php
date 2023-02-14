<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link rel="icon" href="img/logo_n.png" />
        <title>Moblie Thảo Linh | Đăng nhập</title>
        <link rel="stylesheet" type="text/css" href="css/login.css">
        <script type="text/javascript" async="" src="./js/login.js"></script>
        <?php ?>
    </head>
    <body>
        <div class="background"></div>
        <div class="container"> 
         <div class="modal fade login" id="loginModal">
              <div class="modal-dialog login animated">
                  <div class="modal-content">
                     <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true" onclick="window.history.back()">&times;</button>
                            <div class="modal-title">
                                <h1 >Đăng nhập</h1>
                                <?php if (session_id() === '')
                                    session_start(); 
                                    if(isset($_SESSION['error-login'])){
                                ?>
                                <div class="error">Vui lòng kiểm tra lại email hoặc mật khẩu</div>
                                <?php
                                }?>
                            </div>
                            
                        </div>
                        <div class="modal-body">  
                            <div class="box">
                                 <div class="content">
                                    <div class="social">
                                        <a class="circle github" href="/auth/github">
                                            <i class="fa fa-github fa-fw"></i>
                                        </a>
                                        <a id="google_login" class="circle google" href="/auth/google_oauth2">
                                            <i class="fa fa-google-plus fa-fw"></i>
                                        </a>
                                        <a id="facebook_login" class="circle facebook" href="/auth/facebook">
                                            <i class="fa fa-facebook fa-fw"></i>
                                        </a>
                                    </div>
                                    <div class="division">
                                        <div class="line l"></div>
                                          <span>hoặc</span>
                                        <div class="line r"></div>
                                    </div>
                                    <div class="error"></div>
                                    <div class="form loginBox">
                                        <form method="post" action="./server.php" accept-charset="UTF-8">
                                        <input id="email" class="form-control" type="text" placeholder="Vui lòng điền email" name="email">
                                        <input id="password" class="form-control" type="password" placeholder="Vui lòng điền mật khẩu" name="password">
                                        <input class="btn btn-default btn-login" type="submit" value="Đăng nhập" >
                                        </form>
                                    </div>
                                 </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <div class="forgot login-footer">
                                <span>Chưa có tài khoản
                                     <a href="signup.html">Đăng kí</a>
                                ?</span>
                            </div>
                            <div class="forgot register-footer">
                                <a href="./forgotpws.php">Quên mật khẩu?</a>
                            </div>
                        </div>        
                  </div>
              </div>
          </div>
        </div>
    </body>

</html>