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
                            <li role="presentation"><a href="<?php echo site_url('/admin/index')?>">系统概况</a></li>
                            <li role="presentation" class="active"><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
                            <li role="presentation" class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="<?php echo site_url('/admin/profile')?>">个人信息</a></li>                
                                    <li role="presentation"><a href="<?php echo site_url('/admin/reset_pswd')?>">修改密码</a></li>                
                                </ul>
                            <li role="presentation"><a href="<?php echo site_url('/login/logout')?>">退出登陆</a></li>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-10">
						<div class="panel panel-default">
							<div class="panel-heading">
								<h3 class="panel-title">创建新课程类型</h3>
							</div>
							<div class="panel-body">
								<form class="form-horizontal" method="post" action="<?php echo site_url('/admin/create_courseType_action')?>">
									<div class="form-group">
                                        <label for="CourseID" class="col-sm-4 control-label">课程ID</label>
                                        <div class="col-sm-4">
                                            <input type="text" class="form-control" id="CourseID" name="CourseID">
                                        </div>                                      
                                        <label class="col-sm-4"></label>
                                    </div>
                                    <div class="form-group">
										<label for="CourseName" class="col-sm-4 control-label">课程名</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="CourseName" name="CourseName">
										</div>										
										<label class="col-sm-4"></label>
									</div>

                                    <div class="form-group">
                                        <label for="TeacherID" class="col-sm-4 control-label">教师</label>
                                        <div class="col-sm-4">
                                        <select class="form-control" id="TeacherID" name="TeacherID">
                                            <?php
                                                echo "<option value=".;
                                            ?>
                                        </select>
                                        </div>
                                        <label class="col-sm-4"></label>
                                    </div>
									<div class="form-group">
										<label for="Description" class="col-sm-4 control-label">类型描述</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="Description" name="Description">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-6" align="right">
											<a href="<?php echo site_url('/admin/show_courseType')?>">取消</button>
											<button type="submit" class="btn btn-defualt">创建新课程类型</button>
										</div>
									</div>                              
								</form>  
							</div>
						</div>
                    </div>
                
            </div>
            
        </div>
		</div>
    </body>
</html>