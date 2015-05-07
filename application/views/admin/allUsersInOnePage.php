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
                            <li role="presentation" class="active"><a href="<?php echo site_url('/admin/user_manager')?>">用户管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/course_manager')?>">课程管理</a></li>
                            <li role="presentation"><a href="<?php echo site_url('/admin/image_manager')?>">镜像管理</a></li>
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
                        <div class="panel panel-default">
                            <!-- Default panel contents -->
                            <div class="panel-heading">用户信息</div>
                            <div class="panel-body">
                                <div>
                                    
                                    <div class="col-xs-3">

                                        <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/user_list')?>"> 
                                            <div class="input-group">                                                                                              
                                                <select class="form-control" id="type" name = "userType">
                                                    <option value="3">所有用户</option>
                                                    <option value="0">仅管理员</option>
                                                    <option value="1">仅教师</option>
                                                    <option value="2">仅学生</option>
                                                </select>
                                                <span class="input-group-btn">
                                                    <button class="btn btn-default" type="submit" id="select">查看</button>
                                                </span>
                                            </div>
                                        </form>
                                    </div>
                                    <div class="col-xs-8">
                                        <a class="btn btn-default" href="<?php echo site_url('/admin/create_user')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建新用户</a>
                                        <a class="btn btn-default" id="deleteButton" href="<?php echo site_url('/admin/delete_user')?>" role="button"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>删除用户</a>
                                    </div>
                                    
                                </div>
                                <div>
                                    
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>工号</th>
                                                <th>用户名</th>                                        
                                                <th>性别</th>
                                                <th>部门</th>                                     
                                                <th>邮箱</th>
                                                <th>类型</th>
                                            </tr>
                                        </thead>                                
                                        <tbody>
                                            <?php
                                                for ($i=0;$i<count($data);$i++){
                                                    $index = $i + 1;
                                                    $Type=($data[$i]->Type==0)?"管理员":(($data[$i]->Type==1)?"教师":"学生");
                                                    //echo "<tr><th scope='row'><div class='checkbox'><label><input type='checkbox' id='blankCheckbox' value='option1' aria-label='...'></label></div></th><td>".$data[$i]->UserNum."</td><td>".$data[$i]->UserName."</th><td>".$data[$i]->Gender."</td><td>".$data[$i]->Section."</th><td>".$data[$i]->Email."</th><td>".$Type."</th><td></tr>";
                                                    echo "
                                                        <tr>
                                                            <td scope='row'>
                                                                <div class='checkbox'>
                                                                    <label>
                                                                        <input type='checkbox' value=".$data[$i]->UserNum." aria-label='...'>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td><a href=".site_url('/admin/view_user').">".$data[$i]->UserNum."</a></td>
                                                            <td>".$data[$i]->UserName."</td>
                                                            <td>".$data[$i]->Gender."</td>
                                                            <td>".$data[$i]->Section."</td>
                                                            <td>".$data[$i]->Email."</td>
                                                            <td>".$Type."</td>
                                                        </tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>                            
                        </div>
                    </div>               
                </div>
            </div>
		</div>
    </body>
