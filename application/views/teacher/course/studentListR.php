
<div class="col-xs-10">
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">选课情况</h3>
		</div>
		<div class="panel-body">
			<table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>学号</th>                                  
                        <th>姓名</th>                                    
                        <th>演练情况</th>   
                        <th>提交次数</th> 
                        <th>报告</th>
                    </tr>
                </thead>     
                <tbody>
                    <?php
                        for ($i=0;$i<count($data);$i++){
                        	$index = $i+1;
                            echo "
                                <tr style='cursor:pointer'>
                                    <td>".$index."</td>
                                    <td>".$data[$i]->UserNum."</td>
                                    <td>".$data[$i]->UserName."</td>

                                    <td><a href=".site_url("/teacher/show_drill_detail/".$data[$i]->CourseID."/".$data[$i]->StudentID).">".进入课程."</a></td>
                                    <td>".$data[$i]->SubmitTimes."次</td>
                                    <td><a href=".site_url('/general/download_report/'.$data[$i]->SelectionID).">查看</a></td>
                                </tr>";
                        }
                    ?>
                </tbody>
            </table>
		</div>
	</div>
</div>