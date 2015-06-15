<div class="col-xs-10">                        
    <div>                               
        <ul class="nav nav-tabs">
            <?php 
            $li = "<li role='presentation'";
            if($activeTop==-1) $li = $li."class='active'";                                
            $li = $li."><a href=".site_url('/student/course_manager').">进行中</a></li>";
            echo $li;
            for ($i=0;$i<count($courseType);$i++){
                $li = "<li role='presentation'";
                if($activeTop==$courseType[$i]->TypeID) $li = $li."class='active'";
                $operation = "/student/course_manager/".$courseType[$i]->TypeID;
                $li = $li."><a href=".site_url($operation).">".$courseType[$i]->TypeName."</a></li>";
                echo $li;
            }
            ?>
        </ul>
    </div>
    <div class="table-responsive">
        <div>
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>课程名</th>
                        <th>教师ID</th>
                        <th>课程类型</th>
                        <th>提交次数</th>
                        <th>操作</th>
                    </tr>
                </thead>     
                <tbody>
                    <?php
                        for ($i=0;$i<count($data);$i++){
                            $index = $i + 1;
                            $state = ($data[$i]->State==0)?"关闭":(($data[$i]->State==1)?"开启":"完成");
                            $operation = "/student/show_course_detail/".$data[$i]->CourseID;
                            //($data[$i]->Created?"是":"否")

                            switch ($data[$i]->Created) {
                                case '0':
                                    $operationName = "发布课程";
                                    $btnType = "class = 'btn btn-primary'";
                                    $action = "/student/course_push/".$data[$i]->CourseID;
                                    break;
                                case '1':
                                    $operationName = "撤回课程";
                                    $btnType = "class = 'btn btn-success'";
                                    $action = "/student/course_pull/".$data[$i]->CourseID;
                                    break;
                                default:break;
                            }
                            for($j=0;$j<count($courseType);$j++){
                                if($courseType[$j]->TypeID==$data[$i]->TypeID){$type=$courseType[$j]->TypeName;break;}
                            }
                            //echo "<tr><th scope='row'><div class='checkbox'><label><input type='checkbox' id='blankCheckbox' value='option1' aria-label='...'></label></div></th><td>".$data[$i]->UserNum."</td><td>".$data[$i]->UserName."</th><td>".$data[$i]->Gender."</td><td>".$data[$i]->Section."</th><td>".$data[$i]->Email."</th><td>".$Type."</th><td></tr>";
                            echo "
                                <tr style='cursor:pointer'>
                                    <td>".$index."
                                    <td><a href=".site_url($operation).">".$data[$i]->CourseName."</a></td>
                                    <td>".$data[$i]->TeacherID."</td>
                                    <td>".$data[$i]->CourseDesc."</td>
                                    <td>".$type."</td>
                                    <td>".$data[$i]->SubmitLimit."次</td>
                                    <td>".$state."</td>
                                    <td><a ".$btnType." href=".site_url($action)." role='button'>".$operationName."</a>                                    </tr>";
                        }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

</div>