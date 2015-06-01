<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">创建新新用户</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" action="<?php echo site_url('/admin/create_user_action')?>">								
				<div class="form-group">
					<label for="userNum" class="col-sm-4 control-label">工号/学号</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="userNum" name="userNum">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="userName" class="col-sm-4 control-label">用户名</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="userName" name="userName">
					</div>										
					<label class="col-sm-4"></label>
				</div>									
				<div class="form-group">
					<label for="password" class="col-sm-4 control-label">密码</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="password" name="password">
					</div>										
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Email" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-4">
						<input type="email" class="form-control" id="Email" name="Email">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Section" class="col-sm-4 control-label">部门</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Section" name="Section">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Gender" class="col-sm-4 control-label">性别</label>
					<div class="col-sm-4">
						<select class="form-control" id="Gender" name="Gender">
							<option value='男'>男</option>
							<option value='女'>女</option>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Type" class="col-sm-4 control-label">类型</label>
					<div class="col-sm-4">
					<select class="form-control" id="Type" name="Type">
						<option value='0'>管理员</option>
						<option value='1'>教师</option>
						<option value='2'>学生</option>
					</select>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<a href="<?php echo site_url('/admin/user_manager')?>">取消</a>
						<button type="submit" class="btn btn-defualt">创建新用户</button>
					</div>
				</div>                              
			</form>  
		</div>
	</div>
</div>