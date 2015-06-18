<div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">重置密码</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" action="<?php echo site_url('/general/check_pswd/admin')?>">
				<div class="form-group">
					<label for="password1" class="col-sm-4 control-label">输入新密码</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="password1" name="password1">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="password2" class="col-sm-4 control-label">再次输入新密码</label>
					<div class="col-sm-4">
						<input type="password" class="form-control" id="password2" name="password2">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<button type="submit" class="btn btn-defualt">确定</button>
					</div>
				</div>                              
			</form>
		</div>
	</div>
</div>  