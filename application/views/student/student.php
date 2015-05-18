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
                <h1>攻防培训和演练平台<small>——学生</small></h1>
            </div>        
            <div>
                <div class="row">
                    <div class="col-xs-2">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation" class="active dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="<?php echo site_url('/student/course_manager');?>" role="button" aria-expanded="true">我的课程<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="<?php echo site_url('/student/course_unselected');?>">未选择的课程</a></li>
                                    <li role="presentation"><a href="<?php echo site_url('/student/course_selected');?>">已选择的课程</a></li>
                                    <li role="presentation"><a href="<?php echo site_url('/student/course_finished');?>">已完成的课程</a></li>        
                                </ul>
                            </li>
                            <li role="presentation" class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="true">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="<?php echo site_url('/student/profile')?>">个人信息</a></li>                
                                    <li role="presentation"><a href="<?php echo site_url('/student/reset_pswd')?>">修改密码</a></li>
                                </ul>
                            </li>
                            <li role="presentation"><a href="<?php echo site_url('/login/logout')?>">退出登陆</a></li>
                        </ul>
                    </div>
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
            </div>            
        </div>
    </body>
</html>