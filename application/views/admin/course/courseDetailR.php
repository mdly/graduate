
<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">课程信息</h3>
		</div>
		<div class="panel-body">
			<form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url('/admin/update_course_action/'.$data->CourseID);?>">
				<div class="form-group">
					<label for="courseName" class="col-sm-4 control-label">课程名</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="courseName" name="courseName" value="<?php echo$data->CourseName;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="teacherID" class="col-sm-4 control-label">教师</label>
						<div class="col-sm-4">
						<select class="form-control" id="teacherID" name="teacherID">
							<?php
							for ($i=0;$i<count($teachers);$i++){
								if ($data->TeacherID==$teachers[$i]->UserNum) {
									echo "<option value=".$teachers[$i]->UserNum." selected='selected'>".$teachers[$i]->UserName."</option>";
								}
								else{
									echo "<option value=".$teachers[$i]->UserNum.">".$teachers[$i]->UserName."</option>";
								}
							}
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
							for ($i=0;$i<count($types);$i++){
								if ($data->TypeID==$types[$i]->TypeID) {
									echo "<option value=".$types[$i]->TypeID." selected='selected'>".$types[$i]->TypeName."</option>";
								}
								else{
									echo "<option value=".$types[$i]->TypeID.">".$types[$i]->TypeName."</option>";
								}
							}
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
						<input type="file" class="form-control" id="file" name="file" value="<?php echo $data->File;?>">
					</div>
					<label class="colfsm-4"></label>
				</div>

				<div class="form-group">
					<label for="duration" class="col-sm-4 control-label">时长</label>
					<div class="col-sm-4">
						<input type="time" class="form-control" id="duration" name="duration" value="<?php echo $data->Duration;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="submitLimit" class="col-sm-4 control-label">提交限制次数</label>
					<div class="col-sm-4">
						<input type="number" class="form-control" id="submitLimit" name="submitLimit" min="0" max="5" step="1"
						 value="<?php echo $data->SubmitLimit;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>

				<div class="form-group">
					<label for="courseDesc" class="col-sm-4 control-label">课程描述</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="courseDesc" name="courseDesc" value="<?php echo $data->CourseDesc;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="startTime" class="col-sm-4 control-label">开始时间</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="startTime" name="startTime" value="<?php echo $data->StartTime;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="stopTime" class="col-sm-4 control-label">结束时间</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="stopTime" name="stopTime" value="<?php echo $data->StopTime;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="location" class="col-sm-4 control-label">教室</label>
					<div class="col-sm-4">
						<input type="text" class="form-control" id="location" name="location" value="<?php echo $data->Location;?>">
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="imageIDAtk" class="col-sm-4 control-label">攻击机镜像</label>
					<div class="col-sm-4">
						<select class="form-control" id="imageIDAtk" name="imageIDAtk">
							<?php
							for ($i=0;$i<count($images);$i++){
								if ($data->ImageIDAtk==$images[$i]->ImageIDAtk){
									echo "<option value=".$images[$i]->ImageIDAtk." selected='selected'>".$images[$i]->ImageName."</option>";
								}else{
									echo "<option value=".$images[$i]->ImageIDAtk." >".$images[$i]->ImageName."</option>";
								}
							}
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="imageIDTgt" class="col-sm-4 control-label">靶机镜像</label>
					<div class="col-sm-4">
						<select class="form-control" id="imageIDTgt" name="imageIDTgt">
							<?php
							for ($i=0;$i<count($images);$i++){
								if ($data->ImageIDTgt==$images[$i]->ImageIDTgt){
									echo "<option value=".$images[$i]->ImageIDTgt." selected='selected'>".$images[$i]->ImageName."</option>";
								}else{
									echo "<option value=".$images[$i]->ImageIDTgt." >".$images[$i]->ImageName."</option>";
								}
							}
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<a href="<?php echo site_url('/admin/course_manager')?>">取消</a>
						<button type="submit" class="btn btn-defualt">提交修改</button>
					</div>
				</div> 
			</form>
		</div>
	</div>
</div>