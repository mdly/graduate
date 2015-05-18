<div class="col-xs-10">
    <div class="row">
        <div class="col-xs-4">
            <h2>用户概况</h2>
            <p>管理员：共<?php echo($NAdmin)?>人</p>
            <p>教师：共<?php echo($NTeacher)?>人</p>
            <p>学生：共<?php echo($NStudent)?>人</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/admin/user_manager')?>" role="button">查看详情 »</a></p>
        </div>
        <div class="col-xs-4">
            <h2>课程概况</h2>
            <p>未开启：共<?php echo($NCourseOff)?>节</p>
            <p>进行中：共<?php echo($NCourseOn)?>节</p>
            <p>已完成：共<?php echo($NCourseDone)?>节</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/admin/course_manager')?>" role="button">查看详情 »</a></p>
        </div>
        <div class="col-xs-4">
            <h2>镜像概况</h2>
            <p>镜像：共<?php echo($NImage)?>个</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/admin/image_manager')?>" role="button">查看详情 »</a></p>
        </div>
    </div>                        
</div>