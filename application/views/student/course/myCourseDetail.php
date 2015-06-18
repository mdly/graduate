<div>

    <div class="nav nav-tabs">
        	<div align="center">
				<a id="ad-active-page" href="<?php echo site_url('/student/course_manager')?>">基本信息</a>
			</div>

        	<div align="center">
				<a id="ad-basic-page" href="<?php echo site_url('/student/start_course/'.$data['courseID'])?>">进入演练</a>
			</div>

        	<div align="center">
				<a id="ad-basic-page" href="<?php echo site_url('/student/upload_report/'.$data['courseID'])?>">提交报告</a>
			</div>
    </div>	
	<div>
		<br>
		<br>
		<div>
			<div class = "col-sm-12">
				<label for="courseName" class="col-sm-2 col-sm-offset-2 control-label">课程名</label>
				<div class="col-sm-4">
					<p class = "thumbnail"><?php echo $data['courseName'];?></p>
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="teacherID" class="col-sm-2 col-sm-offset-2 control-label">教师</label>
				<div class="col-sm-4">
					<p class = "thumbnail"><?php echo $data['teacherName'];?></p>
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="typeID" class="col-sm-2 col-sm-offset-2 control-label">课程类型</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['typeName'];?></p>
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="fileName" class="col-sm-2 col-sm-offset-2 control-label">课件</label>
				<div class="col-sm-4">
					<a class="thumbnail" href="<?php echo site_url('/general/download_file/'.$data['courseID']);?>">下载指导书</a>
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="duration" class="col-sm-2 col-sm-offset-2 control-label">时长</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['duration'];?></p>
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="submitLimit" class="col-sm-2 col-sm-offset-2 control-label">提交限制次数</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['submitLimit'];?></p>
				</div>
				<label class="col-sm-4"></label>
			</div>

			<div class = "col-sm-12">
				<label for="courseDesc" class="col-sm-2 col-sm-offset-2 control-label">课程描述</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['courseDesc'];?></p>
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="startTime" class="col-sm-2 col-sm-offset-2 control-label">开始时间</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['startTime'];?></p>						
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="stopTime" class="col-sm-2 col-sm-offset-2 control-label">结束时间</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['stopTime'];?></p>						
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="location" class="col-sm-2 col-sm-offset-2 control-label">教室</label>
				<div class="col-sm-4">
					<p class="thumbnail"><?php echo $data['location'];?></p>						
				</div>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<label for="imageIDAtk" class="col-sm-2 col-sm-offset-2 control-label">攻击机镜像</label>
				<?php 
				if(!count($data['attackerImage'])){
					echo "
					<div class='col-sm-4'>
						<p class='thumbnail'>未指定镜像</p>
					</div>
					";
				}else{
					for ($i=0; $i < count($data['attackerImage']); $i++) {
						echo "
						<div class='col-sm-4'>
							<p class='thumbnail'>".$data['attackerImage'][$i]->ImageName."</p>
						</div>
						<label class='col-sm-4'></label>
						";
					}						
				}
				?>
				<label class="col-sm-4"></label>
			</div>

			<div class = "col-sm-12">
				<label for="imageIDTgt" class="col-sm-2 col-sm-offset-2 control-label">靶机镜像</label>
				<?php 
				if(!count($data['targetImage'])){
					echo "
					<div class='col-sm-4'>
						<p class='thumbnail'>未指定镜像</p>
					</div>
					";
				}else{
					for ($i=0; $i < count($data['targetImage']); $i++) {
						echo "
						<div class='col-sm-4'>
							<p class='thumbnail'>".$data['targetImage'][$i]->ImageName."</p>							
						</div>
						<label class='col-sm-4'></label>
						";
					}						
				}
				?>
				<label class="col-sm-4"></label>
			</div>
			<div class = "col-sm-12">
				<div class="col-sm-offset-2 col-sm-6" align="right">
					<a href="<?php echo site_url('/student/course_manager');?>">返回我的课程</a>
				</div>
			</div> 
	</div>
</div>