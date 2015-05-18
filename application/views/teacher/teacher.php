<!DOCTYPE HTML>
<html>
    <head>
        <title>攻防培训平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <!--<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">-->
		<link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css')?>">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>攻防培训和演练平台<small>——教师</small></h1>
            </div>        
            <div>
                <div class="row">
                    <div class="col-xs-2">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="active"><a href="<?php echo site_url('/teacher/index')?>">系统概况</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/teacher/course_manager')?>">我的课程</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/teacher/image_manager')?>">我的学生</a></li>
                            <li role="presentation" class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="<?php echo site_url('/teacher/profile')?>">个人信息</a></li>
                                    <li role="presentation"><a href="<?php echo site_url('/teacher/reset_pswd')?>">修改密码</a></li>
                                </ul>
                            </li>
                            <li role="presentation"><a href="<?php echo site_url('/login/logout')?>">退出登陆</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-10">
                        <div class="row">
                            <div class="col-xs-4">
                                <h2>课程概况</h2>
                                <p>未开启：共<?php echo($NCourseOff)?>节</p>
                                <p>进行中：共<?php echo($NCourseOn)?>节</p>
                                <p>已完成：共<?php echo($NCourseDone)?>节</p>
                                <p><a class="btn btn-default" href="<?php echo site_url('/teacher/course_manager')?>" role="button">查看详情 »</a></p>
                            </div>
                            <div class="col-xs-4">
                                <h2>学生概况</h2>
                                <p>学生总数：共<?php echo($NStudentAll);?>人</p>
                                <p>选课人次：共<?php echo($NStudentSelected);?>人次</p>
                                <p><a class="btn btn-default" href="<?php echo site_url('/teacher/user_manager')?>" role="button">查看详情 »</a></p>
                            </div>
                        </div>                        
                    </div>                
            </div>            
        </div>
    </body>
</html>