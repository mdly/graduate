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
            <!--可以添加class="head_login"
                对于其他界面，可以添加class="head"
            -->
            
            <div class="row" align="center">
                <div class="col-md-3"></div>
                <div class="col-md-6">
                    <form class="form-horizontal" method="post" action="<?php echo site_url('/login/check')?>">
                        <div class="form-group">
                            <label for="login-id" name="login-id" class="col-sm-2 control-label">学号/工号</label>
                            <div class="col-sm-10">
                                <input type="text" class="form-control" placeholder="请输入学号或工号" name="uNumber">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="login-pass" class="col-sm-2 control-label">密码</label>
                            <div class="col-sm-10">
                                <input type="password" class="form-control" placeholder="请输入密码" name="uPassword">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10" align="right">
                                <a class="login-link" href="<?php echo site_url('/login/load_set_password_page')?>">忘记密码？</a>
                                <button type="submit" class="btn btn-defualt">登录</button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-md-3"></div>
            </div>
        </div>
    </body>
</html>