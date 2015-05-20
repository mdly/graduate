                    <div class="col-xs-10">
                        <div class="table-responsive">
                            <div><br></div>
                            <div>
                                <a class="btn btn-default" href="<?php echo site_url('/admin/create_courseType')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建新课程类型</a>
                                <a href="<?php echo site_url('/admin/course_manager')?>">返回课程列表</a>
                            </div>
                            <div>
                                <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/delete_courseType_action')?>">
                                    <table class="table table-striped table-hover">
                                        <thead>
                                            <tr>
                                                <th>类型ID</th>
                                                <th>类型名称</th>
                                                <th>类型描述</th>
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
                                                                        <input type='checkbox' name='deleteCourseType[]' value=".$data[$i]->TypeID." aria-label='...'>
                                                                    </label>
                                                                </div>
                                                            </td>
                                                            <td>".$data[$i]->TypeName."</td>
                                                            <td>".$data[$i]->TypeDesc."</td>
                                                        </tr>";
                                                }
                                            ?>
                                        </tbody>
                                    </table>
                                    <div>
                                        <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>删除课程类型</button>
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