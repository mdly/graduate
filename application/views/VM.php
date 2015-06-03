<div class="col-xs-10">
    <div class="row">
        <div class="col-xs-8">
            <h2>虚拟机概况</h2>
            <p>名称：<?php echo($data['name'])?></p>
            <p>状态：<?php echo($data['status'])?></p>
            <p>创建于：<?php echo($data['created'])?></p>
            <p>镜像ID：<?php echo($data['hostId'])?></p>
            <p>IP地址：<?php echo($data['addresses']['public'][0]['addr'])?></p>
            <p>IP版本：<?php echo($data['addresses']['public'][0]['version'])?></p>
            <p><a class="btn btn-default" href="<?php echo($VMURL);?>" role="button">进入控制台 »</a></p>
        </div>
    </div>                        
</div>
