<div>
    <div class="row col-xs-8">
        <form class="form-horizontal" method="post" action="<?php echo site_url('/general/check_pswd/admin')?>">
            <div class="alert alert-warning alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
                </button><strong>警告！</strong><?php echo $message;?>
            </div>
            <div class="form-group">
                <label for="password1" class="col-sm-4 control-label">输入新密码</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password1" name="password1">
                </div>
            </div>
            <div class="form-group">
                <label for="password2" class="col-sm-4 control-label">再次输入新密码</label>
                <div class="col-sm-8">
                    <input type="password" class="form-control" id="password2" name="password2">
                </div>
            </div>
            <div class="form-group">
                <div class="col-sm-offset-2 col-sm-10" align="right">
                    <button type="submit" class="btn btn-defualt">确定</button>
                </div>
            </div>                              
        </form>                           
    </div>
</div>