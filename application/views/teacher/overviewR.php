<div>
    <div class="row">
        <div class="col-sm-4">
            <h2>
                课程概况
                <a class="btn" href="<?php echo site_url('/teacher/course_manager')?>" role="button">查看详情 »</a>
            </h2>

            <div id="charts-courses"></div>
        </div>
        <div class="col-sm-4">
            <h2>
                学生概况
                <a class="btn" href="<?php echo site_url('/teacher/user_manager')?>" role="button">查看详情 »</a>
            </h2>
            <p>学生总数：共<?php echo($NStudentAll);?>人</p>
            <p>选课人次：共<?php echo($NStudentSelected);?>人次</p>
        </div>
    </div>                        
</div>


<script type="text/javascript">
    var ad_data = ad_data || {};
    ad_data.courses = [
        {name: "未开启", value: <?php echo $NCourseOff; ?>},
        {name: "进行中", value: <?php echo $NCourseOn; ?>},
        {name: "已完成", value: <?php echo $NCourseDone; ?>}
    ];


    (function($, ec) {
        var $courses = $("#charts-courses"),
            _height = {
                users: 3/4,
                courses: 3/4,
                imgs: 3/4
            };


        $courses.height(_height.courses * $courses.width());
        var chartCourses = ec.init($courses.get(0), 'macarons');

        var drawCharts = function() {

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

            chartCourses.setOption(courseOption);               
        };


        var _t = null, resize = function() {
            clearTimeout(_t);
            setTimeout(function() {
                $courses.height(_height.courses * $courses.width());
                chartCourses.resize();
            }, 400);
        };

        drawCharts();
        window.onresize = resize;
    })(jQuery, echarts);
</script>