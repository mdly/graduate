<div class="col-xs-10">
	<table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>#</th>
                <th>课程名</th>
                <th>教师</th>                                   
                <th>课程介绍</th>                               
                <th>提交限制</th>                                 
                <th>操作</th>
            </tr>
        </thead>     
        <tbody>
            <?php
                for ($i=0;$i<count($data);$i++){
                    $index = $i + 1;
                    $state = ($data[$i]->State==0)?"关闭":(($data[$i]->State==1)?"开启":"完成");
                    //$operation = "/student/show_course_detail/".$data[$i]->CourseID;
                    $startCourse = '/student/start_course/'.$data[$i]->CourseID;
                    for($j=0;$j<count($courseType);$j++){
                        if($courseType[$j]->TypeID==$data[$i]->TypeID){$type=$courseType[$j]->TypeName;break;}
                    }
                    //echo "<tr><th scope='row'><div class='checkbox'><label><input type='checkbox' id='blankCheckbox' value='option1' aria-label='...'></label></div></th><td>".$data[$i]->UserNum."</td><td>".$data[$i]->UserName."</th><td>".$data[$i]->Gender."</td><td>".$data[$i]->Section."</th><td>".$data[$i]->Email."</th><td>".$Type."</th><td></tr>";
                    echo "
                        <tr style='cursor:pointer'>
                            <td>".$index."</td>
                            <td>".$data[$i]->CourseName."</td>
                            <td>".$data[$i]->TeacherID."</td>
                            <td><a href=".site_url('/general/download_file/'.$data[$i]->CourseID).">查看</a></td>
                            <td>".$data[$i]->SubmitLimit."次</td>
                            <td><a href=".site_url('/student/start_course/'.$data[$i]->CourseID).">开始课程</td>
                        </tr>";
                }
            ?>
        </tbody>
    </table>
</div> 