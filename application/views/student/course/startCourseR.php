<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">开始演练</h3>
		</div>
		<div class="panel-body">
			<form enctype="multipart/form-data" class="form-horizontal" method="post">
				<div class="form-group">
					<label for="imageIDAtk" class="col-sm-4 control-label">攻击机实例</label>
					<?php 
					if(!count($attackerVM)){
						echo "
						<div class='col-sm-4'>
							<input type='text' class='form-control' value='未添加实例' disabled>
						</div>
						";
					}else{
						for ($i=0; $i < count($attackerVM); $i++) {
							echo "
							<div class='col-sm-4'>
								<input type='text' class='form-control' value=".$attackerVM[$i]->VMName." disabled>
							</div>
							<div class='col-sm-4'>
								<a class='btn btn-default' href=".site_url('/student/delete_attacker_VM/'.$courseID."/".$attackerVM[$i]->VMID)."><span class='glyphicon glyphicon-minus' aria-hidden='true'></span></a>
							</div>
							<label class='col-sm-4'></label>
							";
						}						
					}
					?>
					<label class="col-sm-4"></label>
				</div>


				<div class="form-group">
					<label class="col-sm-4"></label>
					<div class=" col-sm-4">
						<a class="btn btn-default" href="<?php $operation = '/student/add_VM/0/'.$courseID;echo site_url($operation);?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建实例</a>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="imageIDTgt" class="col-sm-4 control-label">靶机实例</label>
					<?php 
					if(!count($targetVM)){
						echo "
						<div class='col-sm-4'>
							<input type='text' class='form-control' value='未添加实例' disabled>
						</div>
						";
					}else{
						for ($i=0; $i < count($targetVM); $i++) {
							echo "
							<div class='col-sm-4'>
								<input type='text' class='form-control' value=".$targetVM[$i]->VMName." disabled>
							</div>
							<div class='col-sm-4'>
								<a class='btn btn-default' href=".site_url('/student/delete_target_VM/'.$courseID."/".$targetVM[$i]->VMID)."><span class='glyphicon glyphicon-minus' aria-hidden='true'></span></a>
							</div>
							<label class='col-sm-4'></label>
							";
						}						
					}
					?>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label class="col-sm-4"></label>
					<div class=" col-sm-4">
						<a class="btn btn-default" href="<?php $operation = '/student/add_VM/1/'.$courseID;echo site_url($operation);?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建实例</a>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<!--created字段由系统设置-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<a href="<?php echo site_url('/student/course_manager')?>">返回课程列表</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>