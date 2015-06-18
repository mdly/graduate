<?php
    $allUsers = $NAdmin+$NTeacher+$NStudent;
    $allCourse = $NCourseOff+$NCourseOn+$NCourseDone;
 ?>
<div>
    <div class="row ground-page">
        <div class="col-sm-4">
            <h3>
                用户概况
                <a class="btn" href="<?php echo site_url('/admin/user_manager')?>" role="button">查看详情 »</a>
            </h3>
            

            <div id="charts-users"></div>
        </div>
        <div class="col-sm-4">
            <h3>
                课程概况
                <a class="btn" href="<?php echo site_url('/admin/course_manager')?>" role="button">查看详情 »</a>
            </h3>

            <div id="charts-courses"></div>
        </div>
        <div class="col-sm-4">
            <h3>
                镜像概况
                <a class="btn" href="<?php echo site_url('/admin/image_manager')?>" role="button">查看详情 »</a>
            </h3>

            <div id="charts-imgs"></div>
        </div>
    </div>                        
</div>

<script type="text/javascript">
    var ad_data = ad_data || {};
    ad_data.users = [
        {name: "管理员", value: <?php echo $NAdmin; ?>},
        {name: "老师", value: <?php echo $NTeacher; ?>},
        {name: "学生", value: <?php echo $NStudent; ?>}
    ];
    ad_data.courses = [
        {name: "未开启", value: <?php echo $NCourseOff; ?>},
        {name: "进行中", value: <?php echo $NCourseOn; ?>},
        {name: "已完成", value: <?php echo $NCourseDone; ?>}
    ];
    ad_data.imgs = [
        {name: "镜像", value: <?php echo $NImage; ?>}
    ];


    (function($, ec) {
        var $users = $("#charts-users"),
            $courses = $("#charts-courses"),
            $imgs = $("#charts-imgs"),
            _height = {
                users: 3/4,
                courses: 3/4,
                imgs: 3/4
            };


        $users.height(_height.users * $users.width());
        $courses.height(_height.courses * $courses.width());
        $imgs.height(_height.imgs * $imgs.width());
        var chartUsers = ec.init($users.get(0), 'macarons'),
            chartCourses = ec.init($courses.get(0), 'macarons'),
            chartImgs = ec.init($imgs.get(0), 'macarons');

        var drawCharts = function() {


            var userOption = {
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c}"
                },
                calculable : true,
                series : [
                    {
                        name:'用户',
                        type:'pie',
                        radius : ['50%', '70%'],
                        itemStyle : {
                            normal : {
                                label : {
                                    formatter: "{b}\n{c}",
                                    textStyle: {
                                        align: "center"
                                    }
                                    // show : false
                                },
                                labelLine : {
                                    // show : false
                                }
                            }
                        },
                        data:ad_data.users
                    }
                ]
            };

            var courseOption = {
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c}"
                },
                calculable : true,
                series : [
                    {
                        name:'课程',
                        type:'pie',
                        radius : ['50%', '70%'],
                        itemStyle : {
                            normal : {
                                label : {
                                    formatter: "{b}\n{c}",
                                    textStyle: {
                                        align: "center"
                                    }
                                    // show : false
                                },
                                labelLine : {
                                    // show : false
                                }
                            }
                        },
                        data:ad_data.courses
                    }
                ]
            };

            var imgOption = {
                tooltip : {
                    trigger: 'item',
                    formatter: "{a} <br/>{b} : {c}"
                },
                calculable : true,
                series : [
                    {
                        name:'镜像',
                        type:'pie',
                        radius : ['50%', '70%'],
                        itemStyle : {
                            normal : {
                                label : {
                                    formatter: "{b}\n{c}",
                                    textStyle: {
                                        align: "center"
                                    }
                                    // show : false
                                },
                                labelLine : {
                                    // show : false
                                }
                            }
                        },
                        data:ad_data.imgs
                    }
                ]
            };
            
            chartUsers.setOption(userOption); 
            chartCourses.setOption(courseOption);               
            chartImgs.setOption(imgOption);               
        };


        var _t = null, resize = function() {
            clearTimeout(_t);
            setTimeout(function() {
                $users.height(_height.users * $users.width());
                $courses.height(_height.courses * $courses.width());
                $imgs.height(_height.imgs * $imgs.width());
                chartUsers.resize();
                chartCourses.resize();
                chartImgs.resize();
            }, 400);
        };

        drawCharts();
        window.onresize = resize;
    })(jQuery, echarts);
</script>