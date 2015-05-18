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
                                                    <input type='checkbox' name='deleteImage' value=".$data[$i]->ImageID.">
                                                </label>
                                            </div>
                                        </td>
                                        <td>".$data[$i]->ImageID."</td>
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