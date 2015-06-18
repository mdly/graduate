<div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">创建新实例</h3>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" method="post" action="<?php echo site_url('/student/create_VM_action/'.$isTarget.'/'.$courseID)?>">
				<div class="form-group">
					<label for="vmName" class="col-sm-4 control-label">名称</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="vmName" name="vmName">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="image" class="col-sm-4 control-label">镜像</label>
					<div class="col-sm-4">
						<select class="form-control" id="image" name="image">
							<?php
							for ($i=0;$i<count($images);$i++)
								echo "<option value=".$images[$i]->ImageID.">".$images[$i]->ImageName."</option>";
							?>
						</select>
					</div>
					<label class="col-sm-3"></label>
				</div>
				<div class="form-group">
					<label for="network" class="col-sm-4 control-label">网络</label>
					<div class="col-sm-4">	
						<select class="form-control" id="network" name="network">
							<?php
							for ($i=0;$i<count($networks);$i++)
								echo "<option value=".$networks[$i]['id'].">".$networks[$i]['name']."</option>";
								//echo "<option value=".$networks[$i]['id'].">".count($networks)."</option>";
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>

				<div class="form-group">
					<label for="flavor" class="col-sm-4 control-label">主机类型</label>
					<div class="col-sm-4">
						<select class="form-control" id="flavor" name="flavor">
							<?php
							for ($i=0;$i<count($flavors);$i++)
								echo "<option value=".$flavors[$i]['links'][0]['href'].">".$flavors[$i]['name']."</option>";
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>



				<div class="form-group">
					<label for="keypair" class="col-sm-4 control-label">密钥对</label>
					<div class="col-sm-4">
						<select class="form-control" id="keypair" name="keypair">
							<?php
							for ($i=0;$i<count($keypairs);$i++)
								echo "<option value=".$keypairs[$i]['keypair']['name'].">".$keypairs[$i]['keypair']['name']."</option>";
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<!--created字段由系统设置-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<a href="<?php echo site_url('/student/start_course/'.$courseID)?>">取消</a>
						<button type="submit" class="btn btn-defualt">启动实例</button>
					</div>
				</div>
			</form>  
		</div>
	</div>
</div>