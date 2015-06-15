<?php $allCourse = $unselectedCourse + $selectedCourse + $finishedCourse;?>
<div class="col-xs-10">
    <div class="row">
        <div class="col-xs-4">
            <h2>课程概况</h2>
            <p>未选择：<?php echo($unselectedCourse."节/共".$allCourse."节")?></p>
            <p>进行中：<?php echo($selectedCourse."节/共".$allCourse."节")?></p>
            <p>已完成：<?php echo($finishedCourse."节/共".$allCourse."节")?></p>
            <p><a class="btn btn-default" href="<?php echo site_url('/student/course_manager')?>" role="button">查看详情 »</a></p>
        </div>

        <div class="col-xs-4">
            <h2>资源概况</h2>
            <p>已用虚拟机：共<?php echo($allVM)?>台</p>
        </div>        
    </div>                        
</div>