<div>
    <div class="nav nav-tabs">
        	<div align="center">
				<a id="ad-basic-page" href="<?php echo site_url('/student/show_my_course_detail/'.$courseID)?>">基本信息</a>
			</div>

        	<div align="center">
				<a id="ad-basic-page" href="<?php echo site_url('/student/start_course/'.$courseID)?>">进入演练</a>
			</div>

        	<div align="center">
				<a id="ad-active-page" href="<?php echo site_url('/student/upload_report/'.$courseID)?>">提交报告</a>
			</div>
    </div>

	<div>
		<br>
		<br>

		<div class = "col-sm-12">
			<label for="courseName" class="col-sm-2 col-sm-offset-2 control-label">提交上限</label>
			<div class="col-sm-4">
				<p class = "thumbnail"><?php echo $submitLimit;?></p>
			</div>
			<label class="col-sm-4"></label>
		</div>

		<div class = "col-sm-12">
			<label for="courseName" class="col-sm-2 col-sm-offset-2 control-label">已经提交</label>
			<div class="col-sm-4">
				<p class = "thumbnail"><?php echo $submitTimes;?></p>
			</div>
			<label class="col-sm-4"></label>
		</div>
		<?php
		if ($submitTimes<$submitLimit){
			echo "
			<div class='col-sm-12'>
				<form enctype='multipart/form-data' method='post' action=".site_url('/student/upload_report_action/'.$courseID).">
					<div>
						<label for='file' class='col-sm-2 col-sm-offset-2 control-label'>上传报告</label>
						<div class='col-sm-4'>
							<input type='file' class='form-control' id='file' name='file'>
						</div>
						<label class='col-sm-4'></label>
					</div>
					<div>
						<div class='col-sm-2 col-sm-offset-6' align='right'>
						<br>
							<button type='submit' class='btn btn-defualt'>提交</button>
						</div>
					</div>
				</form>
			</div>
			";
		}
		?>
	</div>
</div>