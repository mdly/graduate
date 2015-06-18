<div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">创建新网络</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" action="<?php echo site_url('/student/create_network_action');?>">
				<div class="form-group">
					<label for="networkName" class="col-sm-4 control-label">网络名称</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="networkName" name="networkName">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="subnetName" class="col-sm-4 control-label">子网名称</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="subnetName" name="subnetName">						
					</div>
					<label class="col-sm-3"></label>
				</div>
				<div class="form-group">
					<label for="subnetCIDR" class="col-sm-4 control-label">子网CIDR</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="subnetCIDR" name="subnetCIDR">						
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<a href="<?php echo site_url('/student/network_manager')?>">取消</a>
						<button type="submit" class="btn btn-defualt">启动实例</button>
					</div>
				</div>
			</form>  
		</div>
	</div>
</div>