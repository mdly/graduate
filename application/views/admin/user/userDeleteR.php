<div>
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
                    <a class="btn btn-default" href="<?php echo site_url('/admin/user_list')?>" role="button">取消删除</a>
                    <a class="btn btn-default" href="<?php echo site_url('/admin/delete_user_action')?>" role="button">确认删除</a>
                </div>
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