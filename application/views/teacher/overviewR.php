<div class="col-xs-10">
    <div class="row">
        <div class="col-xs-4">
            <h2>课程概况</h2>
            <p>未开启：共<?php echo($NCourseOff)?>节</p>
            <p>进行中：共<?php echo($NCourseOn)?>节</p>
            <p>已完成：共<?php echo($NCourseDone)?>节</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/teacher/course_manager')?>" role="button">查看详情 »</a></p>
        </div>
        <div class="col-xs-4">
            <h2>学生概况</h2>
            <p>学生总数：共<?php echo($NStudentAll);?>人</p>
            <p>选课人次：共<?php echo($NStudentSelected);?>人次</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/teacher/user_manager')?>" role="button">查看详情 »</a></p>
        </div>
    </div>                        
</div>