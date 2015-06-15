<div>
    <div class="row">
        <div class="col-xs-2">
            <ul class="nav nav-pills nav-stacked">
                <li role="presentation"<?php if($left==(0)) echo "class = 'active'";?>><a href="<?php echo site_url('/student/index');?>">课程中心</a></li>
                
                <li role="presentation"<?php if($left==(1)) echo "class = 'active'";?>><a href="<?php echo site_url('/student/course_manager');?>">我的课程</a></li>
                <li role="presentation"<?php if($left==(2)) echo "class = 'active'";?>><a href="<?php echo site_url('/student/network_manager');?>">我的网络</a></li>
                <li role="presentation" class="dropdown <?php if($left==3||$left==4) echo 'active';?>"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                    <ul class="dropdown-menu" role="menu">
                        <li role="presentation"<?php if($left==(3)) echo "class = 'active'";?>><a href="<?php echo site_url('/general/profile/student');?>">个人信息</a></li>                
                        <li role="presentation"<?php if($left==(4)) echo "class = 'active'";?>><a href="<?php echo site_url('/general/reset_pswd/student');?>">修改密码</a></li>                
                    </ul>
                <li role="presentation"><a href="<?php echo site_url('/general/logout')?>">退出登陆</a></li>
                </li>
            </ul>
        </div>