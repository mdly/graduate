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
                <h1>攻防培训和演练平台<small>——管理员</small></h1>
            </div>        
            <div>
                <div class="row">
                    <div class="col-xs-2">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="active"><a href="<?php echo site_url('/admin/index')?>">系统概况</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
                            <li role="presentation" class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="<?php echo site_url('/admin/profile')?>">个人信息</a></li>                
                                    <li role="presentation"><a href="<?php echo site_url('/admin/reset_pswd')?>">修改密码</a></li>
                                </ul>
                            </li>
                            <li role="presentation"><a href="<?php echo site_url('/login/logout')?>">退出登陆</a></li>
                        </ul>
                    </div>
                    <div class="col-xs-10">
                        <div class="row">
                            <div class="col-xs-4">
                                <h2>用户概况</h2>
                                <p>管理员：共<?php echo($NAdmin)?>人</p>
                                <p>教师：共<?php echo($NTeacher)?>人</p>
                                <p>学生：共<?php echo($NStudent)?>人</p>
                                <p><a class="btn btn-default" href="<?php echo site_url('/admin/user_manager')?>" role="button">查看详情 »</a></p>
                            </div>
                            <div class="col-xs-4">
                                <h2>课程概况</h2>
                                <p>未开启：共<?php echo($NCourseOff)?>节</p>
                                <p>进行中：共<?php echo($NCourseOn)?>节</p>
                                <p>已完成：共<?php echo($NCourseDone)?>节</p>
                                <p><a class="btn btn-default" href="<?php echo site_url('/admin/course_manager')?>" role="button">查看详情 »</a></p>
                            </div>
                            <div class="col-xs-4">
                                <h2>镜像概况</h2>
                                <p>镜像：共<?php echo($NImage)?>个</p>
                                <p><a class="btn btn-default" href="<?php echo site_url('/admin/image_manager')?>" role="button">查看详情 »</a></p>
                            </div>
                        </div>                        
                    </div>                
            </div>            
        </div>
    </body>
</html>