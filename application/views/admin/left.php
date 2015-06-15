            <div>
                <div class="row">
                    <div class="col-xs-2">
                        <ul class="nav nav-pills nav-stacked">
                            <li role="presentation"  <?php if($left==(0)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/index')?>">系统概况</a></li>
                            <li role="presentation" <?php if($left==(1)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                            <li role="presentation" <?php if($left==(2)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                            <li role="presentation" <?php if($left==(3)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
                            <li role="presentation" class="dropdown <?php if($left==4||$left==5) echo 'active';?>"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"<?php if($left==(4)) echo "class = 'active'";?>><a href="<?php echo site_url('/general/profile/admin')?>">个人信息</a></li>                
                                    <li role="presentation"<?php if($left==(5)) echo "class = 'active'";?>><a href="<?php echo site_url('/general/reset_pswd/admin')?>">修改密码</a></li>
                                </ul>
                            </li>
                            <li role="presentation"><a href="<?php echo site_url('/general/logout')?>">退出登陆</a></li>
                        </ul>
                    </div>