<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">创建新课程类型</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" action="<?php echo site_url('/admin/create_courseType_action')?>">
				<div class="form-group">
					<label for="typeName" class="col-sm-4 control-label">课程类型名</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="typeName" name="typeName">
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
						<a href="<?php echo site_url('/admin/show_course_list')?>">取消</button>
						<button type="submit" class="btn btn-defualt">创建新课程类型</button>
					</div>
				</div>
			</form>  
		</div>
	</div>
</div>