<!-- <div>
    <div class="row">
        <div class="col-xs-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"<?php if($left==(0)) echo "class = 'active'";?>><a href="<?php echo site_url('/teacher/index');?>">系统概况</a></li>
                
                <li role="presentation"<?php if($left==(1)) echo "class = 'active'";?>><a href="<?php echo site_url('/teacher/course_manager');?>">我的课程</a></li>
                <li role="presentation"<?php if($left==(2)) echo "class = 'active'";?>><a href="<?php echo site_url('/teacher/student_manager');?>">我的学生</a></li>
                <li role="presentation" class="dropdown <?php if($left==3||$left==4) echo 'active';?>"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"<?php if($left==(3)) echo "class = 'active'";?>><a href="<?php echo site_url('/general/profile/teacher');?>">个人信息</a></li>                
                        <li role="presentation"<?php if($left==(4)) echo "class = 'active'";?>><a href="<?php echo site_url('/general/reset_pswd/teacher');?>">修改密码</a></li>                
                    </ul>
                <li role="presentation"><a href="<?php echo site_url('/general/logout')?>">退出登陆</a></li>
                </li>
            </ul>
        </div>
 -->
            <div id="ad-nav-left">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"<?php if($left==(0)) echo "class = 'active'";?>><a href="<?php echo site_url('/teacher/index');?>">系统概况</a></li>
                
                        <li role="presentation"<?php if($left==(1)) echo "class = 'active'";?>><a href="<?php echo site_url('/teacher/course_manager');?>">我的课程</a></li>
                        <!-- <li role="presentation"<?php if($left==(2)) echo "class = 'active'";?>><a href="<?php echo site_url('/teacher/student_manager');?>">我的学生</a></li> -->
                    </ul>
            </div>
            <div id="ad-main-container">
                <div class="container-fluid">