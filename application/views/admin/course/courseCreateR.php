<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">创建新课程类型</h3>
		</div>
		<div class="panel-body">
			<form enctype="multipart/form-data" class="form-horizontal" method="post" action="<?php echo site_url('/admin/create_course_action')?>">
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
					<label for="attackerImage" class="col-sm-4 control-label">攻击机镜像</label>
					<div class="col-sm-4">
						<select class="form-control" id="attackerImage" name="attackerImage">
							<option value="">暂不指定</option>
							<?php
							for ($i=0;$i<count($images);$i++)
								echo "<option value=".$images[$i]->ImageID.">".$images[$i]->ImageName."</option>";
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>
				<div class="form-group">
					<label for="targetImage" class="col-sm-4 control-label">靶机镜像</label>
					<div class="col-sm-4">
						<select class="form-control" id="targetImage" name="targetImage">
							<option value="">暂不指定</option>
							<?php
							for ($i=0;$i<count($images);$i++)
								echo "<option value=".$images[$i]->ImageID.">".$images[$i]->ImageName."</option>";
							?>
						</select>
					</div>
					<label class="col-sm-4"></label>
				</div>				

				<!--created字段由系统设置-->
				<!--镜像的绑定这边还要考虑一下，或者是动态实现？-->
				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-6" align="right">
						<a href="<?php echo site_url('/admin/course_manager')?>">取消</a>
						<button type="submit" class="btn btn-defualt">创建新课程</button>
					</div>
				</div>
			</form>  
		</div>
	</div>
</div>