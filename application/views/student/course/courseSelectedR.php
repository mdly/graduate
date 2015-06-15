<div class="col-xs-10">
    <div>
        <ul class="nav nav-tabs">
            <li role="presentation" class="active"><a href="<?php echo site_url('/student/course_manager')?>">进行中的课程</a></li>
            <li role="presentation"><a href="<?php echo site_url('/student/course_manager/1')?>">已完成的课程</a></li>
        </ul>
    </div>
    <div><br></div>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>课程名</th>
                <th>课程类型</th>
                <th>教师</th>                            
                <th>提交限制</th>                                
                <th>已提交次数</th>                              
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            <?php
                for ($i=0;$i<count($data);$i++){
                    $index = $i + 1;
                    //$operation = "/student/show_course_detail/".$data[$i]->CourseID;
                    $startCourse = '/student/start_course/'.$data[$i]['courseID'];
                    //echo "<tr><th scope='row'><div class='checkbox'><label><input type='checkbox' id='blankCheckbox' value='option1' aria-label='...'></label></div></th><td>".$data[$i]->UserNum."</td><td>".$data[$i]->UserName."</th><td>".$data[$i]->Gender."</td><td>".$data[$i]->Section."</th><td>".$data[$i]->Email."</th><td>".$Type."</th><td></tr>";
                    echo "
                        <tr style='cursor:pointer'>
                            <td>".$index."</td>
                            <td>".$data[$i]['courseName']."</td>
                            <td>".$data[$i]['typeName']."</td>
                            <td>".$data[$i]['teacherName']."</td>
                            <td>".$data[$i]['submitLimit']."次</td>
                            <td>".$data[$i]['submitTimes']."次</td>
                            <td><a href=".site_url('/student/show_my_course_detail/'.$data[$i]['courseID']).">进入课程</td>                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div> 