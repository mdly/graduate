<div class="col-xs-10">                        
    <div>                               
        <ul class="nav nav-tabs">
            <?php 
            $li = "<li role='presentation'";
            if($activeTop==-1) $li = $li."class='active'";                                
            $li = $li."><a href=".site_url('/admin/course_manager').">所有课程</a></li>";
            echo $li;
            for ($i=0;$i<count($courseType);$i++){
                $li = "<li role='presentation'";
                if($activeTop==$courseType[$i]->TypeID) $li = $li."class='active'";
                $operation = "/admin/course_manager/".$courseType[$i]->TypeID;
                $li = $li."><a href=".site_url($operation).">".$courseType[$i]->TypeName."</a></li>";
                echo $li;
            }
            $li = "<li role='presentation'><a href=".site_url('/admin/show_courseType_list').">查看所有类型</a></li>";
            echo $li;
            ?>
        </ul>
    </div>
    <div class="table-responsive">
        <div><br></div>
        <div>
            <form class="form-inline" method="post" action="<?php $operation='/admin/search_course/'.$activeTop; echo site_url($operation)?>"> 
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
                <div class="col-xs-4">
                    <a class="btn btn-default" href="<?php echo site_url('/admin/create_course')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建新课程</a>
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
                            <th>教师ID</th>                                   
                            <th>课程描述</th>                                   
                            <th>课程类型</th>                                   
                            <th>提交限制</th>                  
                            <th>状态</th>
                            <th>已创建完成</th>
                        </tr>
                    </thead>     
                    <tbody>
                        <?php
                            for ($i=0;$i<count($data);$i++){
                                $index = $i + 1;
                                $state = ($data[$i]->State==0)?"关闭":(($data[$i]->State==1)?"开启":"完成");
                                $operation = "/admin/show_course_detail/".$data[$i]->CourseID;
                                for($j=0;$j<count($courseType);$j++){
                                    if($courseType[$j]->TypeID==$data[$i]->TypeID){$type=$courseType[$j]->TypeName;break;}
                                }
                                //echo "<tr><th scope='row'><div class='checkbox'><label><input type='checkbox' id='blankCheckbox' value='option1' aria-label='...'></label></div></th><td>".$data[$i]->UserNum."</td><td>".$data[$i]->UserName."</th><td>".$data[$i]->Gender."</td><td>".$data[$i]->Section."</th><td>".$data[$i]->Email."</th><td>".$Type."</th><td></tr>";
                                echo "
                                    <tr style='cursor:pointer'>

                                        <td scope='row'>
                                            <div class='checkbox'>
                                                <label>
                                                    <input type='checkbox' name='deleteCourse[]' value=".$data[$i]->CourseID." aria-label='...'>
                                                </label>
                                            </div>
                                        </td>
                                        <td><a href=".site_url($operation).">".$data[$i]->CourseName."</a></td>
                                        <td>".$data[$i]->TeacherID."</td>
                                        <td>".$data[$i]->CourseDesc."</td>
                                        <td>".$type."</td>
                                        <td>".$data[$i]->SubmitLimit."次</td>
                                        <td>".$state."</td>
                                        <td>".($data[$i]->Created?"是":"否")."</td>
                                    </tr>";
                            }
                        ?>
                    </tbody>
                </table>
                <div>
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>删除课程</button>
                </div>
            </form>
        </div>
    </div>

</div>