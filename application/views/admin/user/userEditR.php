<div class="col-xs-10">
    <div>
        <ul class="nav nav-tabs">
            <li role="presentation" name = "allUser" class="tag active"><a href="<?php echo site_url('/admin/show_user_list')?>">所有用户</a></li>
            <li role="presentation" name = "admin" class="tag"><a href="<?php echo site_url('/admin/show_admin_list')?>">管理员</a></li>
            <li role="presentation" name = "teacher" class="tag"><a href="<?php echo site_url('/admin/show_teacher_list')?>">教师</a></li>
            <li role="presentation" name = "student" class="tag"><a href="<?php echo site_url('/admin/show_student_list')?>">学生</a></li>
        </ul>
    </div>
    <div class="table-responsive">
        <div><br></div>
        <div>
            <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/search_user')?>"> 
                <div class="col-xs-3">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="关键字">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">查询</button>
                        </span>
                    </div><!-- /input-group -->
                </div>
                <div class="col-xs-8">
                    <a class="btn btn-default" href="<?php echo site_url('/admin/create_user')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建新用户</a>
                </div>
            </form>            
        </div>
        <div>
            <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/delete_user')?>">
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
                                    <tr style='cursor:pointer'>

                                        <td scope='row'>
                                            <div class='checkbox'>
                                                <label>
                                                    <input type='checkbox' name='deleteUser[]' value=".$data[$i]->UserNum." aria-label='...'>
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
                <div>
                    <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>删除用户</button>
                </div>
            </form>
        </div>
    </div>
</div>