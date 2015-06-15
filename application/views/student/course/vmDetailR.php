<div class="col-xs-10">
<?php
    if (array_key_exists("public", $data['addresses'])) {
        $addr = $data['addresses']['public'][0]['addr'];
        $version = $data['addresses']['public'][0]['version'];
    }elseif (array_key_exists("private", $data['addresses'])) {
        $addr = $data['addresses']['private'][0]['addr'];
        $version = $data['addresses']['private'][0]['version'];        
    }
?>
    <div class="row">
        <div class="col-xs-8">
            <h2>虚拟机概况</h2>
            <p>名称：<?php echo($data['name'])?></p>
            <p>状态：<?php echo($data['status'])?></p>
            <p>创建于：<?php echo($data['created'])?></p>
            <p>镜像ID：<?php echo($data['hostId'])?></p>
            <!-- if the network is not public ,then there should change -->
            <p>IP地址：<?php echo($addr)?></p>
            <p>IP版本：<?php echo($version)?></p>
            <p><a class="btn btn-default" href="<?php echo($VMURL);?>" role="button">进入控制台 »</a></p>
        </div>
    </div>

    <div class = "col-sm-12">
        <div class="col-sm-offset-2 col-sm-6" align="right">
            <a href="<?php echo site_url('/student/start_course/'.$courseID);?>">返回我的课程</a>
        </div>
    </div>                    
</div>
