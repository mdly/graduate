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
							<li role="presentation"><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
							<li role="presentation" class="active"><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
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
								<form class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url('/admin/create_course_action')?>">
									<div class="form-group">
										<label for="courseName" class="col-sm-4 control-label">课程名</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="courseName" name="courseName">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="teacherID" class="col-sm-4 control-label">教师</label>
											<div class="col-sm-4">
											<select class="form-control" id="teacherID" name="teacherID">
												<?php
												for ($i=0;$i<count($teachers);$i++)
													echo "<option value=".$teachers[$i]->UserNum.">".$teachers[$i]->UserName.$teachers[$i]->UserNum."</option>";
												?>
											</select>
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="typeID" class="col-sm-4 control-label">课程类型</label>
											<div class="col-sm-4">
											<select class="form-control" id="typeID" name="typeID">
												<?php
												for ($i=0;$i<count($types);$i++)
													echo "<option value=".$types[$i]->TypeID.">".$types[$i]->TypeName."</option>";
												?>
											</select>
										</div>
										<label class="col-sm-4"></label>
									</div>
									<!--
									state由后台设置，分为0:off,1:on,2:done刚开始创建的时候为0：off
								-->
									<div class="form-group">
										<label for="file" class="col-sm-4 control-label">课件</label>
										<div class="col-sm-4">
											<input type="file" class="form-control" id="file" name="file">
										</div>
										<label class="colfsm-4"></label>
									</div>

									<div class="form-group">
										<label for="duration" class="col-sm-4 control-label">时长</label>
										<div class="col-sm-4">
											<input type="time" class="form-control" id="duration" name="duration">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="submitLimit" class="col-sm-4 control-label">提交限制次数</label>
										<div class="col-sm-4">
											<input type="number" class="form-control" id="submitLimit" name="submitLimit" min="0" max="5" step="1" value="3">
										</div>
										<label class="col-sm-4"></label>
									</div>

									<div class="form-group">
										<label for="courseDesc" class="col-sm-4 control-label">课程描述</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="courseDesc" name="courseDesc">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="startTime" class="col-sm-4 control-label">开始时间</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="startTime" name="startTime">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="stopTime" class="col-sm-4 control-label">结束时间</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="stopTime" name="stopTime">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="location" class="col-sm-4 control-label">教室</label>
										<div class="col-sm-4">
											<input type="text" class="form-control" id="location" name="location">
										</div>
										<label class="col-sm-4"></label>
									</div>
									<div class="form-group">
										<label for="imageID" class="col-sm-4 control-label">镜像</label>
										<div class="col-sm-4">
											<select class="form-control" id="imageID" name="imageID">
												<?php
												for ($i=0;$i<count($images);$i++)
													echo "<option value=".$images[$i]->ImageID.">".$images[$i]->ImageName."</option>";
												?>
											</select>
										</div>
										<label class="col-sm-4"></label>
									</div>

									<!--created字段由系统设置-->
									<div class="form-group">
										<div class="col-sm-offset-2 col-sm-6" align="right">
											<a href="<?php echo site_url('/admin/show_course_list')?>">取消</button>
											<button type="submit" class="btn btn-defualt">创建新课程</button>
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