<!DOCTYPE html>
<html>
    <head>
        <title>攻防培训平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css')?>">
        <link rel="stylesheet" href="<?php echo base_url('public/css/main.css')?>">
        <script src="<?php echo base_url('bootstrap/js/jquery.min.js')?>"></script>
        <script src="<?php echo base_url('bootstrap/js/bootstrap.min.js')?>"></script>
    </head>
    <body class="ad-login-container">
        <div class="container ad-login-panel">
            <div class="row ad-login-header"><h1 align="center" class="ad-login-header">攻防培训和演练平台</h1></div>
            <div class="row ad-login-form " align="center">
                    <form class="form-horizontal" method="post" action="<?php echo site_url('/login/check')?>">
                        <div class="input-group form-group">
                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-user" aria-hidden="true"></span></span>
                            <input type="text" class="form-control" placeholder="请输入学号或工号" name="uNumber">
                        </div>
                        <div class="input-group form-group">
                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-lock" aria-hidden="true"></span></span>
                            <input type="password" class="form-control" placeholder="请输入密码" name="uPassword">
                        </div>

                        <div class="input-group form-group">
                            <span class="input-group-addon" id="basic-addon1"><span class="glyphicon glyphicon-asterisk" aria-hidden="true"></span></span>
                            <input type="text" class="form-control" name="captcha" autocomplete="off" placeholder="验证码" maxlength="5">
                        </div>
                        <div class="form-group">
                            <img align="right" id="ad-captcha" src="<?php echo site_url('/login/captcha')?>" alt="加载失败" title="点击刷新验证码">
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn btn-defualt btn-block ">登录</button>
                        </div>
                    </form>
            </div>
        </div>
        <div><p id="ad-footer-copy">2015 &copy; SJTU INFOSEC</p></div>
<script type="text/javascript">
(function($){
    $(function() {
        $("#ad-captcha").click(function(){
            $(this).attr("src", "<?php echo site_url('/login/captcha?_=');?>" + Math.random());
        });
    });
})(jQuery);
    </script>

    </body>
</html>