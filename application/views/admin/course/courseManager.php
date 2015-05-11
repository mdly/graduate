<!DOCTYPE HTML>
<html>
    <head>
        <title>攻防培训平台</title>
        <meta name="viewport" content="width=device-width, initial-scale=1" charset="UTF-8">
        <!-- 新 Bootstrap 核心 CSS 文件 -->
        <!--<link rel="stylesheet" href="../bootstrap/css/bootstrap.min.css">-->
        <link rel="stylesheet" href="<?php echo base_url('bootstrap/css/bootstrap.min.css')?>">
        <!-- jQuery文件。务必在bootstrap.min.js 之前引入 -->
        <script src="http://cdn.bootcss.com/jquery/1.11.2/jquery.min.js"></script>
        <!-- 最新的 Bootstrap 核心 JavaScript 文件 -->
        <script src="http://cdn.bootcss.com/bootstrap/3.3.4/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="page-header">
                <h1>攻防培训和演练平台<small>——管理员</small></h1>
            </div>
            
            
            <div>
                <div class="row">
                    <div class="col-xs-2">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" <?php if($activeLeft==0) echo "class='active'"?>><a href="<?php echo site_url('/admin/index')?>">系统概况</a></li>
                            <li role="presentation" <?php if($activeLeft==1) echo "class='active'"?>><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                            <li role="presentation" <?php if($activeLeft==2) echo "class='active'"?>><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                            <li role="presentation" <?php if($activeLeft==3) echo "class='active'"?>><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
                            <li role="presentation" class="dropdown" <?php if($activeLeft==4||$activeLeft ==5) echo "class='active'"?>><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation" <?php if($activeLeft==4) echo "class='active'"?>><a href="<?php echo site_url('/admin/profile')?>">个人信息</a></li>                
                                    <li role="presentation" <?php if($activeLeft==5) echo "class='active'"?>><a href="<?php echo site_url('/admin/reset_pswd')?>">修改密码</a></li>                
                                </ul>
                            <li role="presentation"><a href="<?php echo site_url('/login/logout')?>">退出登陆</a></li>
                            </li>
                        </ul>
                    </div>
                    
                    <div class="col-xs-10">                        
                        <div>
                            <form>                                
                            <ul class="nav nav-tabs">
                                <?php 
                                $li = "<li role='presentation'";
                                if($activeTop==0) $li = $li."class='active'";                                
                                $li = $li."><a href=".site_url('/admin/show_course_list').">所有课程</a></li>";
                                echo $li;
                                for ($i=0;$i<count($courseType);$i++){
                                    $li = "<li role='presentation'";
                                    if($activeTop==$courseType[$i]->TypeID) $li = $li."class='active'";
                                    $operation = "/admin/show_course_list/".$courseType[$i]->TypeID;
                                    $li = $li."><a href=".site_url($operation).">".$courseType[$i]->TypeName."</a></li>";
                                    echo $li;
                                }
                                $li = "<li role='presentation'><a href=".site_url('/admin/show_courseType_list').">查看所有类型</a></li>";
                                echo $li;
                                ?>
                            </ul>
                            </form>
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
                                <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/delete_course_action')?>">
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
                </div>
            </div>            
        </div>
    </body>
</html>