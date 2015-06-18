<div>
    <form class="form-horizontal" method="post" action="<?php echo site_url('/student/delete_network')?>">
		<table class="table table-striped table-hover">
			<!-- <caption>网络信息</caption> -->
	        <div class="col-xs-4">
	            <a class="btn btn-default" href="<?php echo site_url('/student/create_network')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建网络</a>
	            <a class="btn btn-default" href="<?php echo site_url('/student/create_router')?>" role="button"><span class="glyphicon glyphicon-plus" aria-hidden="true"></span>创建路由</a>
	        </div>
	        <thead>
	            <tr>
	                <th>#</th>
	                <th>网络名称</th>
	                <th>网络ID</th>                                   
	                <th>子网名称</th>                               
	                <th>子网ID</th>                                
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
                                            <input type='checkbox' name='deleteNetwork[]' value=".$data[$i]['id']." aria-label='...'>
                                        </label>
                                    </div>
                                </td>
                                <td>".$data[$i]['name']."</a></td>
                                <td>".$data[$i]['id']."</td>
                                <td>".$subnet[$i]."</td>
                                <td>".$data[$i]['subnets'][0]."</td>
                            </tr>";
                    }
                ?>
	        </tbody>
	    </table>
        <div>
            <button class="btn btn-default" type="submit"><span class="glyphicon glyphicon-minus" aria-hidden="true"></span>删除网络</button>
        </div>
	</form>
</div> 