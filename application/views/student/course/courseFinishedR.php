<div>
    <div>
        <ul class="nav nav-tabs">
            <li role="presentation"><a href="<?php echo site_url('/student/course_manager')?>">进行中的课程</a></li>
            <li role="presentation" class="active"><a href="<?php echo site_url('/student/course_manager/1')?>">已完成的课程</a></li>
        </ul>
    </div>
    <div><br></div>
	<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>课程名</th>
                <th>教师</th>
                <th>课程类型</th>
                <th>成绩</th>
            </tr>
        </thead>     
        <tbody>
            <?php
                for ($i=0;$i<count($data);$i++){
                    $index = $i + 1;
                    //$operation = "/student/show_course_detail/".$data[$i]->CourseID;
                    // $startCourse = '/student/start_course/'.$data[$i]->CourseID;
                    // for($j=0;$j<count($courseType);$j++){
                    //     if($courseType[$j]->TypeID==$data[$i]->TypeID){$type=$courseType[$j]->TypeName;break;}
                    // }
                    //echo "<tr><th scope='row'><div class='checkbox'><label><input type='checkbox' id='blankCheckbox' value='option1' aria-label='...'></label></div></th><td>".$data[$i]->UserNum."</td><td>".$data[$i]->UserName."</th><td>".$data[$i]->Gender."</td><td>".$data[$i]->Section."</th><td>".$data[$i]->Email."</th><td>".$Type."</th><td></tr>";
                    echo "
                        <tr style='cursor:pointer'>
                            <td>".$index."</td>
                            <td>".$data[$i]['courseName']."</td>
                            <td>".$data[$i]['teacherName']."</td>
                            <td>".$data[$i]['typeName']."</td>
                            <td>".$data[$i]['Score']."</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div> 