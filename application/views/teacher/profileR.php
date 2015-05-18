<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">用户个人信息</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" action="<?php echo site_url('/general/edit_profile/admin')?>">
				<div class="form-group">
					<label for="userNum" class="col-sm-4 control-label">工号</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="userNum" name="userNum" value="<?php echo $data[0]->UserNum?>" disabled>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="userName" class="col-sm-4 control-label">用户名</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="userName" name="userName" value="<?php echo $data[0]->UserName?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Email" class="col-sm-4 control-label">Email</label>
					<div class="col-sm-4">
						<input type="email" class="form-control" id="Email"  name="Email" value="<?php echo $data[0]->Email?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Section" class="col-sm-4 control-label">部门</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Section" name="Section" value="<?php echo $data[0]->Section?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Gender" class="col-sm-4 control-label">性别</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Gender" name="Gender" value="<?php echo $data[0]->Gender?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="Type" class="col-sm-4 control-label">类型</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="Type" name="Type" value="<?php echo ($data[0]->Type==0)?'管理员':(($data[0]->Type==1)?'教师':'学生')?>" disabled>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<button type="submit" class="btn btn-defualt">提交修改</button>
					</div>
				</div>                              
			</form> 
		</div>
	</div>
</div>