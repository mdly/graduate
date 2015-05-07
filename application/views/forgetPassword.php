<!DOCTYPE html>
<html>
    <head>
        <title>攻防培训平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css')?>">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row"><h1 align="center">攻防培训和演练平台<br><br></h1></div>
            <div class="row"><h3 align="center">密码重置<br><br></h3></div>
            <!--可以添加class="head_login"
                对于其他界面，可以添加class="head"
            -->
            
            <div class="row" align="center">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form class="form-horizontal" method="post" action="<?php echo site_url('/login/get_CAPTCHA')?>">
                        <div class="form-group">
                            <label for="login-id" name="login-id" class="col-sm-2 control-label">学号/工号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="请输入学号或工号" name="uNumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="email" class="col-sm-2 control-label">邮箱</label>
                            <div class="col-sm-10">
                                <input type="email" class="form-control" placeholder="请输入注册时的邮箱" name="uEmail">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10" align="right">
                                <a href="<?php echo site_url('/login/index')?>">取消</button>
                                <button type="submit" class="btn btn-defualt">发送验证码</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>