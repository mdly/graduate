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
                                    <!--
                                    读取了以下数据：
                                    $admin = $this->crud->select(array('UserNum,UserName,Gender,Email,Section,Type','users','Type','0'));
                                    -->
                                    
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