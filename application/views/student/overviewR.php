<div class="col-xs-10">
    <div class="row">
        <div class="col-xs-4">
            <h2>课程概况</h2>
            <p>总课程：共<?php echo($unselectedCourse)?>节</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/student/course_manager')?>" role="button">查看详情 »</a></p>
        </div>

        <div class="col-xs-4">
            <h2>课程概况</h2>
            <p>进行中：共<?php echo($selectedCourse)?>节</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/student/selected_course_manager')?>" role="button">查看详情 »</a></p>
        </div>

        <div class="col-xs-4">
            <h2>课程概况</h2>
            <p>已完成：共<?php echo($finishedCourse)?>节</p>
            <p><a class="btn btn-default" href="<?php echo site_url('/student/finished_course_manager')?>" role="button">查看详情 »</a></p>
        </div>
    </div>                        
</div>