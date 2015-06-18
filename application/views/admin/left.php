            <div id="ad-nav-left">
                    <ul class="nav nav-pills nav-stacked">
                        <li role="presentation"  <?php if($left==(0)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/index')?>">系统概况</a></li>
                        <li role="presentation" <?php if($left==(1)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                        <li role="presentation" <?php if($left==(2)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                        <li role="presentation" <?php if($left==(3)) echo "class = 'active'";?>><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
                    </ul>
            </div>
            <div id="ad-main-container">
                <div class="container-fluid">