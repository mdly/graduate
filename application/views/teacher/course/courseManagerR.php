<div class="col-xs-10">                        
    <div>                               
        <ul class="nav nav-tabs">
            <?php 
            $li = "<li role='presentation'";
            if($activeTop==-1) $li = $li."class='active'";                                
            $li = $li."><a href=".site_url('/teacher/course_manager').">所有课程</a></li>";
            echo $li;
            for ($i=0;$i<count($courseType);$i++){
                $li = "<li role='presentation'";
                if($activeTop==$courseType[$i]->TypeID) $li = $li."class='active'";
                $operation = "/teacher/course_manager/".$courseType[$i]->TypeID;
                $li = $li."><a href=".site_url($operation).">".$courseType[$i]->TypeName."</a></li>";
                echo $li;
            }
            ?>
        </ul>
    </div>
    <div class="table-responsive">
        <div><br></div>
        <div>
            <form class="form-inline" method="post" action="<?php $operation='/teacher/search_course/'.$activeTop; echo site_url($operation)?>"> 
                <div class="col-xs-8">
                    <div class="input-group">
                        <select class="form-control" name="selectColumn">
                            <option value="CourseName" <?php if($selectColumn=="CourseName" || $selectColumn=="0")echo "selected='selected'";?>>课程名</option>
                            <option value="TeacherID" <?php if($selectColumn=="TeacherID")echo "selected='selected'";?>>教师ID</option>
                            <option value="State" <?php if($selectColumn=="State")echo "selected='selected'";?>>状态</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="关键字" name="keyword">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">查询</button>
                        </span>
                    </div><!-- /input-group -->
                </div>
            </form>
        </div>
        <div>
            <form class="form-horizontal" method="post" action="<?php $operation='/admin/delete_course_action/'.$activeTop;echo site_url($operation);?>">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>课程名</th>                                  
                            <th>课程类型</th>                                    
                            <th>提交限制</th> 
                            <th>课程介绍</th>         
                            <th>操作</th>    
                            <th>选课人数</th>    
                            <th>状态</th>
                        </tr>
                    </thead>     
                    <tbody>
                        <?php
                            for ($i=0;$i<count($data);$i++){
                                $index = $i + 1;
                                $state = ($data[$i]->State==0)?"关闭":(($data[$i]->State==1)?"开启":"完成");
                                //$operation = "/teacher/";
                                switch ($data[$i]->State) {
                                    case '0':
                                        $operationName = "开启课程";
                                        $btnType = "class = 'btn btn-primary'";
                                        $operation = "/teacher/start_course/".$data[$i]->CourseID;
                                        break;
                                    case '1':
                                        $operationName = "关闭课程";
                                        $btnType = "class = 'btn btn-success'";
                                        $operation = "/teacher/stop_course/".$data[$i]->CourseID;
                                        break;
                                    default:
                                        $operationName = "查看课程";
                                        $btnType = "class = 'btn btn-success'";
                                        $operation = "/teacher/show_course_detail/".$data[$i]->CourseID;
                                        break;
                                }
                                echo "
                                    <tr style='cursor:pointer'>
                                        <td>".$index."</td>
                                        <td><a href=".site_url("/teacher/read_student_list/".$data[$i]->CourseID).">".$data[$i]->CourseName."</a></td>
                                        <td>".$typeName[$i]."</td>
                                        <td>".$data[$i]->SubmitLimit."次</td>
                                        <td><a href=".site_url('/general/download_file/'.$data[$i]->CourseID).">查看</a></td>
                                        <td><a ".$btnType." href=".site_url($operation)." role='button'>".$operationName."</a>
                                        <td>".$NStudent[$i]."</td>
                                        <td>".$state."</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
            </form>
        </div>
    </div>

</div>