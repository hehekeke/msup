<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\MsupLecturer;
use backend\widget\DateTimeAsset;
use backend\widget\TimelySearch;
DateTimeAsset::register($this);
?>
<h1>选择课程</h1>
<?php 
    $this->registerJs('

            $("body").on("click",".doChoseCourse",function(){
                var course = $(this).parent().parent();
                var id = course.find("td").eq(0).text();
                var hour = course.find("td").eq(4).text();
                var day = Math.round(hour/24);
                if (day < 1) day = 1;
                $(".venue-course-body tbody tr").remove();

                for(var i=0; i< day; i++) {
                    $(".venue-course-body tbody").append( "<tr class=\'venue-course-table-tr\'><td><input type=\'text\' name=\'MsupSchedulingVenueCourse[date][]\' class=\'form-control choseDate date\'/></td><td><input type=\'text\' name=\'MsupSchedulingVenueCourse[startTime][]\' class=\'form-control choseStartTime time\'/></td><td><input type=\'text\' name=\'MsupSchedulingVenueCourse[endTime][]\' class=\'form-control choseEndTime time\'/></td></tr>"
                    );
                }
                $(".courseid").val(id);
                $(".course-title").val(course.find("td").eq(1).text());
                $("#course-modal").modal(\'hide\');
                $("#venue-course-modal .date").datetimepicker( {
                    language:  "zh-CN",
                    format: "yyyy-mm-dd",
                    weekStart: 1,
                    todayBtn:  1,
                    autoclose: 1,
                    todayHighlight: 1,
                    startView: 2,
                    minView: 2,
                    // maxView: 2,
                    forceParse: 0
                }).on("hide", function(ev){
                        var input = $(this);

                    if ($("body .venues-course-body .venues-course-tables").length > 0) {
                        var hasMath = 0;
                        $("body .venues-course-body .venues-course-tables").each(function() {
                            if ($(this).find("h5.panel-heading").text() == input.val()) {

                                hasMath = 1;
                            }
                        })
                        if (hasMath == 0) {
                            alert("您选择的日期不在排课日期范围内,请重新选择");
                            input.val("");
                            return false;
                        }
                    }

                });
                $("#venue-course-modal .choseStartTime, #venue-course-modal .choseEndTime").datetimepicker({
                    language:  "zh-CN",
                    format: "hh:ii",
                    weekStart: 1,
                    autoclose: 1,
                    startView: 1,
                    minView: 0,
                    maxView: 1,
                    forceParse: 0
                }).on("hide", function(ev){

                    if ($(this).hasClass("choseEndTime") ) {
                        var endTime = $(this).val().split(":");
                        var endTimeToInt = parseInt(endTime[0])*60+parseInt(endTime[1]);
                        var startTime = $(this).parent().parent().find(".choseStartTime").val().split(":");
                        var startTimeToInt = parseInt(startTime[0])*60+parseInt(startTime[1])
                        if (endTimeToInt - startTimeToInt < 1) {
                            alert("结束时间不能小于开始时间，请重新选择时间");
                            $(this).val("");
                            return false;
                        }
                    }
                });

            })
            $("#searchCourse").blur(function(event){
                event.stopImmediatePropagation(); 
                $(".listValue").show();
                return false;
            })
        ');
?>
<div class="row">
    <div class="form-group col-xs-12">
        <div class="col-xs-12 np">
            <input type="text" class="form-control" id="searchCourse" placeholder="请输入关键词搜索您要找的课程">
            <!-- 后期提供教练名和标签种类进行搜索 -->
        </div>
    </div>
</div>
<!-- 即时搜索课程 -->
<?= TimelySearch::widget([
            'searchUrl'=>'course/search-by-title',
            'input'=>'#searchCourse',
            'message'=>'我们已搜到以下相关课程:',
            'key' => 'title'
            ]
        );
?>
<div class="msup-course-index">

    <?php
    // GridView::widget([
    //     'dataProvider' => $dataProvider,
    //     'columns' => [
    //         [
    //             'label' => '课程序号',
    //             'value' => function($data){
    //                 return $data->courseid;
    //             }
    //         ],
    //         [
    //             'label' => '课程标题',
    //             'value' => function($data) {
    //                 return $data->title;
    //             }
    //         ],
    //         [
    //             'label' => '主办方',
    //             'value' => function($data) {
    //                 return $data->sponsor;
    //             }
    //         ],
    //         [
    //             // 'attribute' => 'lecturer_id',
    //             'label' => '教练',
    //             'value' => function($data) {
    //                 $row = MsupLecturer::findOne(['id' => $data->lecturer_id]);
    //                 return $row->name;
    //             }
    //         ],
    //         [
    //             'label' => 'usedtimeid',
    //             'format' => 'html',
    //             'label' => '课程时长',
    //             'value' =>function($data){

    //                 return $data->courseUsedtime->hour; //数据库中存的是小时数
    //              }
    //         ],
    //         [
    //             'label' => '课程价格',
    //             'value' => function($data) {
    //                 return $data->price;
    //             }
    //         ],
    //         [
    //             // 'label' => '',
    //             'format' => 'html',
    //             'value' => function($data) {
    //                 return '<a  class="doChoseCourse btn btn-xs btn-primary" onclick="doChoseCourse(this)" >选择此课程</a>';
                  
    //             } 
    //         ]
    //     ],
    // ]); 
    ?>

</div>
