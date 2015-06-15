<div class="col-xs-10">                        
    <div>                               
        <ul class="nav nav-tabs">
            <?php 
            $li = "<li role='presentation'";
            if($activeTop==-1) $li = $li."class='active'";                                
            $li = $li."><a href=".site_url('/student/index').">所有课程</a></li>";
            echo $li;
            for ($i=0;$i<count($courseType);$i++){
                $li = "<li role='presentation'";
                if($activeTop==$courseType[$i]->TypeID) $li = $li."class='active'";
                $operation = "/student/index/".$courseType[$i]->TypeID;
                $li = $li."><a href=".site_url($operation).">".$courseType[$i]->TypeName."</a></li>";
                echo $li;
            }
            ?>
        </ul>
    </div>
    <div class="table-responsive">
        <div><br></div>
        <div>
            <form class="form-inline" method="post" action="<?php $operation='/student/search_course/'.$activeTop; echo site_url($operation)?>"> 
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
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>课程名</th>
                            <th>教师</th>                                   
                            <th>课程描述</th>                                   
                            <th>课程类型</th>           
                            <th>状态</th>
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
                                if ($selected[$i]<0) {
                                    // this course is not selected, then show the select button
                                    // $operationName
                                    $action = "<a class='btn btn-primary'href=".
                                        site_url("/student/select_course_action/".$data[$i]->CourseID).
                                        " role='button'>选择课程</a>";
                                }else{
                                    // this course is selected, then disable the button
                                    $action = "<a class='btn btn-default selected' href='#' role='button'>选择课程</a>";
                                }
                                echo "
                                    <tr style='cursor:pointer'>
                                        <td>".$index."</td>
                                        <td><a href=".site_url($operation).">".$data[$i]->CourseName."</a></td>
                                        <td>".$teacher[$i]."</td>
                                        <td>".$data[$i]->CourseDesc."</td>
                                        <td>".$typeName[$i]."</td>
                                        <td>".$state."</td>
                                        <td>".$action."</tr>";
                            }
                        ?>
                    </tbody>
                </table>
        </div>
    </div>

</div>
<script type="text/javascript">
(function($){
    $(function() {
        $(".selected").click(function(){
            alert("您已经选择过该课程，请到“我的课程”中查看！");
        });
    });
})(jQuery);
    </script>

    </body>
</html>
