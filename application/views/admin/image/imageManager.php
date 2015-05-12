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
                            <li role="presentation"><a href="<?php echo site_url('/admin/index')?>">系统概况</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                            <li role="presentation" class="active"><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
                            <li role="presentation" class="dropdown"><a  class="dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-expanded="false">个人设定<span class="caret"></span></a>
                                <ul class="dropdown-menu" role="menu">
                                    <li role="presentation"><a href="<?php echo site_url('/admin/profile')?>">个人信息</a></li>                
                                    <li role="presentation"><a href="<?php echo site_url('/admin/reset_pswd')?>">修改密码</a></li>                
                                </ul>
                            <li role="presentation"><a href="<?php echo site_url('/login/logout')?>">退出登陆</a></li>
                            </li>
                        </ul>
                    </div>
                    <div class="col-xs-10">

                        <div class="table-responsive">
                            <div><br></div>
                            <div>
                                <a class="btn btn-default" href="<?php echo site_url('/admin/image_create')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建新镜像</a>
                            </div>
                            <div>
                                <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/delete_image_action')?>">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>镜像号</th>
                                                <th>镜像名称</th>
                                                <th>镜像描述</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                                for ($i=0;$i<count($data);$i++){
                                                    $index = $i + 1;
                                                    echo "
                                                        <tr style='cursor:pointer'>

                                                            <td scope='row'>
                                                                <div class='checkbox'>
                                                                    <label>
                                                                        <input type='checkbox' name='deleteImage' value=".$data[$i]->ImageIndex.">
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>".$data[$i]->ImageIndex."</td>
                                                            <td>".$data[$i]->ImageName."</td>
                                                            <td>".$data[$i]->ImageDesc."</td>
                                                        </tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div>
                                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>删除镜像</button>
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