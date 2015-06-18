<div>
    <div>
        <ul class="nav nav-tabs">
            <li role="presentation" name = "allUser" <?php if ($activeTop=="-1") echo "class='active'";?>><a href="<?php $operation='/admin/user_manager/-1'; echo site_url($operation);?>">所有用户</a></li>
            <li role="presentation" name = "admin" <?php if ($activeTop=="0") echo "class='active'";?>><a href="<?php $operation='/admin/user_manager/0'; echo site_url($operation);?>">管理员</a></li>
            <li role="presentation" name = "teacher" <?php if ($activeTop=="1") echo "class='active'";?>><a href="<?php $operation='/admin/user_manager/1'; echo site_url($operation);?>">教师</a></li>
            <li role="presentation" name = "student" <?php if ($activeTop=="2") echo "class='active'";?>><a href="<?php $operation='/admin/user_manager/2'; echo site_url($operation);?>">学生</a></li>
        </ul>
    </div>
    <div class="table-responsive">
        <div><br></div>
        <div>
            <form class="form-inline" method="post" action="<?php $operation='/admin/search_user/'.$activeTop; echo site_url($operation);?>"> 
                <div class="col-xs-8">
                    <div class="input-group">
                        <select class="form-control" name="selectColumn">
                            <option value="UserNum" <?php if($selectColumn=="userNum")echo"selected='selected'";?>>学号/工号</option>
                            <option value="UserName"<?php if($selectColumn=="userName")echo"selected='selected'";?>>用户名</option>
                            <option value="Email"<?php if($selectColumn=="Email")echo"selected='selected'";?>>邮箱</option>
                        </select>
                    </div>
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder=<?php if ($keyword) echo $keyword;else echo"关键字";?> name="keyword">
                        <span class="input-group-btn">
                            <button class="btn btn-default" type="submit">查询</button>
                        </span>
                    </div><!-- /input-group -->
                </div>
                <div class="col-xs-4">
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
                            <th>os用户ID</th>                                     
                            <th>os租户ID</th>  
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
                                        <td><a href=".site_url('/admin/show_user_detail/'.$data[$i]->UserNum).">".$data[$i]->UserNum."</a></td>
                                        <td>".$data[$i]->UserName."</td>
                                        <td>".$data[$i]->Gender."</td>
                                        <td>".$data[$i]->Section."</td>
                                        <td>".$data[$i]->Email."</td>
                                        <td>".$Type."</td>
                                        <td>".$data[$i]->UserID."</td>
                                        <td>".$data[$i]->TenantID."</td>
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