<div>
    <div class="nav nav-tabs">
        	<div align="center">
				<a id="ad-basic-page" href="<?php echo site_url('/student/show_my_course_detail/'.$courseID)?>">基本信息</a>
			</div>

        	<div align="center">
				<a id="ad-active-page" href="<?php echo site_url('/student/start_course/'.$courseID)?>">演练实践</a>
			</div>

        	<div align="center">
				<a id="ad-basic-page" href="<?php echo site_url('/student/upload_report/'.$courseID)?>">提交报告</a>
			</div>
    </div>


	<div>
		<br>
		<br>
		<div>
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
								<a class='btn btn-default btn-block' href=".site_url("/student/get_VM_detail/".$attackerVM[$i]->VMID)." role='button'>".$attackerVM[$i]->VMName."</a>

							</div>
							<div class='col-sm-4'>
								<a class='btn btn-default' href=".site_url('/student/delete_VM_action/'.$courseID."/".$attackerVM[$i]->VMID)."><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>
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
						// echo "<a class='btn btn-default' href='#' role='button'>未添加实例</a>"
						echo "
						<div class='col-sm-4'>
							<input type='text' class='form-control' value='未添加实例' disabled>
						</div>
						";
					}else{
						for ($i=0; $i < count($targetVM); $i++) {
							echo "
							<div class='col-sm-4'>
								<a class='btn btn-default btn-block' href=".site_url("/student/get_vm_detail/".$targetVM[$i]->VMID)." role='button'>".$targetVM[$i]->VMName."</a>
							</div>
							<div class='col-sm-4'>
								<a class='btn btn-default' href=".site_url('/student/delete_VM_action/'.$courseID."/".$targetVM[$i]->VMID)."><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a>
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
						<a href="<?php echo site_url('/student/course_manager')?>">返回我的课程</a>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>