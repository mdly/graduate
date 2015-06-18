<div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <h3 class="panel-title">创建新镜像</h3>
        </div>
        <div class="panel-body">
            <form class="form-horizontal" method="post" action="<?php echo site_url('/admin/image_create_action')?>">
                <div class="form-group">
                    <label for="imageName" class="col-sm-4 control-label">镜像名</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="imageName" name="imageName">
                    </div>                                      
                    <label class="col-sm-4"></label>
                </div>
                <div class="form-group">
                    <label for="imageDesc" class="col-sm-4 control-label">镜像描述</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="Description" name="imageDesc">
                    </div>
                    <label class="col-sm-4"></label>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6" align="right">
                        <a href="<?php echo site_url('/admin/show_course_list')?>">取消</a>
                        <button type="submit" class="btn btn-defualt">创建新课程类型</button>
                    </div>
                </div>
            </form>
            <form  class="form-horizontal" enctype="multipart/form-data" method="post" action="<?php echo site_url('/admin/upload_image')?>">
                <div>
                    <label for="imageFile" class="col-sm-4 control-label">镜像文件</label>
                    <div class="col-sm-4">
                        <input type="file" class="form-control" id="imageFile" name="imageFile">
                    </div>
                </div>
                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-6" align="right">
                        <a href="<?php echo site_url('/admin/show_course_list')?>">取消</a>
                        <button type="submit" class="btn btn-defualt">上传镜像</button>
                    </div>
                </div>                              
            </form>  
        </div>
    </div>
</div>