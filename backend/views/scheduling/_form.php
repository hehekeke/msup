<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\Attachment;
use backend\widget\DateTimeControl;
/* @var $this yii\web\View */
/* @var $model backend\models\MsupScheduling */
/* @var $form yii\widgets\ActiveForm */
?>

<?php $id = $model->isNewRecord ? Yii::$app->security->generateRandomString(8) : $model->id;
    $keyName = $model->isNewRecord? 'hash' : 'sid';
?>
<style type="text/css">
.datalist{position: absolute;z-index: 9999;background: #fff;width: 275px;border:solid 1px #66afe9;}
.datalist p{padding:2px 10px;cursor: pointer;}
.datalist p:hover{
    background: #66afe9;
    color:#fff;
}
</style>
    <div class='msup-scheduling-form'>
        
        <?php $form = ActiveForm::begin(["id" => "scheduling"]); ?>
        <input type="hidden" name="hash" value="<?= $id ?>" /> 
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= $title;?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">课程排期基本信息</div>
                    <div class="panel-body">
                        <div class='col-lg-6 col-ms-12'>
                                <?= $form->field($model, 'title')->textInput(['maxlength' => 200]) ?>
                                
                                <div class='row  nml nmr form-group'>

                                    <div class="col-xs-6  npl">

                                     <?= $form->field($model, 'startTime')->widget(DateTimeControl::className(), [
                                            'fieldName' => '  MsupScheduling[startTime]',
                                            'value' => $model->startTime ? date("Y-m-d H:i",$model->startTime) : '',
                                            'renderInput' => 1,
                                            'format' => 'yyyy-mm-dd hh:ii',
                                            'contentOptions' => [
                                                'class' => 'form-control time startTime',
                                                // 'maxlength' => 12,
                                        // 'data-provide' =>'datepicker-inline'
                                    ],]) ?>
                                    </div>

                                    <div class="col-xs-6  np">

                                     <?= $form->field($model, 'endTime')->widget(DateTimeControl::className(), [
                                            'fieldName' => '  MsupScheduling[endTime]',
                                            'value' => $model->endTime ? date("Y-m-d H:i",$model->endTime) : '',
                                            'renderInput' => 1,
                                            'format' => 'yyyy-mm-dd hh:ii',
                                            'contentOptions' => [
                                                'class' => 'form-control time endTime',
                                                'maxlength' => 12,

                                        // 'data-provide' =>'datepicker-inline'
                                    ],]) ?>
                                    </div>
                                </div>
                                    <?= $form->field($model, 'type')->dropDownList($model->types) ?>
                                <div class="form-group">
                                    <label for="msupscheduling-video" class="control-label">
                                        课程视频（请将优酷等第三方网站的代码粘贴此处）
                                    </label>
                                    <?= Html::textarea('MsupScheduling[video]', $model->video, ['maxlength' => 300, 'class'=>'form-control', 'placeholder' => ''])?>
                                </div>
                                    <?= $form->field($model, 'recommendToBuzz')->checkbox()?>
                                <div class="form-group">
                                <?= $form->field($model, 'address')->textInput([
                                    'id' => 'msupscheduling-address',
                                    'readonly',
                                    'class' => 'form-control ng-pristine ng-valid',
                                    'maxlength' => '200',
                                    'p'=>'p','c'=>'c','a'=>'a','d' => 'd', 'ng-model' => 'xxx', 'select-address' =>'', 'placeholder' => $model->address, 'value' => $model->address
                                    ]);
                                    ?>
                                </div>
                                <?= $form->field($model, 'content')->textarea(['rows'=>5])?>
                        </div>
                        
                        <div class='col-lg-6 col-ms-12'>
                            <div class='panel panel-default'>
                                <h5 class='panel-heading nmt'>附件</h5>
                                <div class="panel-body">
                                    <?= Attachment::widget( [ 
                                                'url'=>'attachment/upload',
                                                'model' => $model,
                                                'field' => 'MsupScheduling[attachment]',
                                                'number' => 10,
                                            ] ) ;?>
                                </div>
                            </div>
                            <div class='panel panel-default'>
                                <h5 class='panel-heading nmt'>海报</h5>
                                <div class="panel-body">
                                    <?= Attachment::widget( [ 
                                                'url'=>'attachment/upload',
                                                'model' => $model,
                                                'field' => 'MsupScheduling[poster]',
                                                'number' => 10,
                                                'container' => 'upload2'
                                            ] ) ;?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            
    
                <div class="panel panel-default scheduling-venue">
                    <h4 class="panel-heading nmt">分会场及课程时间安排</h4>
                    <div class="panel-body">    
                        <div class="panel panel-default col-lg-6  col-xs-12 np">
                            <h5 class="panel-heading nmt">分会场</h5>
                            <div class="form-group venueName-form row nmr nml">
                                    <label for="" class="control-label col-xs-12">
                                        添加会场
                                    </label>
                                    <div class="panel-body">
                                        <table class="table table text-left table-striped table-bordered dataTable">
                                            <thead>
                                                <tr>
                                                    <th>分会场名称</th>
                                                    <th>删除</th>
                                                </tr>
                                            </thead>
                                            <tbody class="venues">
                                                
                                        <?php 
                                            if ( $venues && !empty($venues) ) {
                                                foreach ($venues as $v) {
                                        ?>
                                                <tr>
                                                    <td><?= $v['venueName'] ?></td>
                                                    <td>
                                                        <i class="btn btn-xs btn-danger glyphicon glyphicon-remove remove-venues"></i>
                                                        <input type='hidden' value='<?= $v["id"] ?>'>
                                                    </td>
                                                </tr>
                                        <?php } } else { ?>

                                        <tr>
                                            <td colspan="2" class="no-venue">请添加分会场</td>
                                        </tr>   

                                        <?php  } ?>

                                            </tbody>

                                        </table>
                                        
                                    </div>
                                    <div class="col-xs-8">
                                        <input type="text" name="scheduling-venueName" class="scheduling form-control" placeholder="分会场名称"/>
                                        <div class="datalist" style="display:none;"id="default-venue-list">
                                            <p class="nmb"value="开发管理">开发管理</p>
                                            <p class="nmb"value="产品创新">产品创新</p>
                                            <p class="nmb"value="架构设计">架构设计</p>
                                            <p class="nmb"value="测试管理">测试管理</p>
                                            <p class="nmb"value="团队管理">团队管理</p>
                                            <p class="nmb"value="程序员">程序员</p>
                                        </div>
                                    </div>
                                    <div class="col-xs-4">
                                        <a href="javascript:void(0)" class=" submitVenue btn btn-primary form-control">提交</a>
                                    </div>
                            </div>
                        </div>
                        <div id="venues-course" class="panel panel-default col-xs-12 np row nm ">
                            <h5 class="panel-heading nm row"> 
                                <span class="col-xs-7 npl">关联课程排期</span> 
                                <!-- <a href="javascript:void(0)" class="col-xs-5 text-right glyphicon glyphicon-chevron-down venues-course-show" title="展开"></a> -->
                                <a href='javascript:void(0)' class='btn btn-danger text-right col-xs-2 clearCourses npl npr pull-right' style="margin-left:10px;">清空课程</a>
                                <a href='javascript:void(0)' class='btn addCourseModal btn-success text-right col-xs-2 venues-course-show  npl npr pull-right'>搜索课程</a>

                            </h5>
                            <div class="panel-body venues-course-body">
                                <?php 

                                    if ($venueCourses && !empty($venueCourses)) {

                                        foreach ($venueCourses as $key => $row) :
                                ?>
                                <div class='panel panel-default np nml nmr row venues-course-tables'>
                                    <h5 class='panel-heading nm' date="<?= $key ?>"><?= date('Y-m-d', $key) ?></h5>
                                    <div class='panel-body'>
                                        <table class='table table-bordered table-striped'>
                                            <thead>
                                                <tr>
                                                    <th>分会场名称</th>
                                                    <th>课程标题</th>
                                                    <th>开始时间</th>
                                                    <th>结束时间</th>
                                                    <th>删除</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php foreach( $row as $k => $v):?>
                                                <tr>
                                                    <td><?= $v['venueName'] ?></td>
                                                    <td><?= $v['title']?></td>
                                                    <td><?= $v['startTime']?></td>
                                                    <td><?= $v['endTime'] ?></td>
                                                    <td>
                                                        <span class=' btn btn-xs  btn-danger glyphicon glyphicon-remove remove-venue-course'> </span>
                                                        <input type='hidden' value="<?= $v["id"] ?>" />
                                                    </td>
                                                </tr>
                                                <?php endforeach;?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <?php endforeach;?>
                                <?php } ?>
                            </div>      
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class='form-group'>
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-lg btn-success submit-this-form' : 'btn btn-lg btn-primary submit-this-form']) ?>
        </div>
    
        <?php ActiveForm::end(); ?>

    </div>
</div>

<!-- 添加课程Modal -->
<div class="modal fade" id="venue-course-modal"  tabindex="-1"  >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
        <div class="modal-header row nml nmr">
            <div class="pull-left"><h5>关联课程排期</h5></div>
            <div class="pull-right">
                <button type="button" data-dismiss="modal" class="btn btn-default dismiss-venue-course-modal">取消</button>
                <button type="button"  class="btn btn-primary submit-venue-course-modal">添加</button>
            </div>
        </div>
        <div class="modal-body"></div>

    </div>
  </div>
</div>

<!-- 关联课程Modal -->
<div class='modal fade' id='course-modal'  tabindex='1'  >
  <div class='modal-dialog modal-lg'>
    <div class='modal-content' >
        <div class="modal-header">
            <button type="button" class="close dismiss-course-modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
            <h4 class="modal-title">选择课程</h4>
        </div>
        <div class="modal-body course-modal-body"></div>

    </div>
  </div>
</div>
<?php 

    $this->registerJs('
      $("input[name=\'scheduling-venueName\']").focus(function(){
         $("div.datalist").show();
      })
    $("div.datalist").width($("input[name=\'scheduling-venueName\']").outerWidth())
        // 自动提示输入JS
        $("div.datalist").hover(function(event){
            $(this).show();
            event.stopImmediatePropagation();
        },function(){
            $("div.datalist").hide();
        })
        $("div.datalist p").click(function(event){
            $("input[name=\'scheduling-venueName\']").val($(this).attr("value") );
            $("div.datalist").hide();
        return false;

        })
        $(document).keydown(function(){
                $("div.datalist").hide();
        })
        ');
    $this->registerJs(
        ' 
            hash = "'.$id.'"
            _crsf = $("input[name=\'_csrf\']").val();
            scopeTime = "";//时间范围
            // 添加分会场
            $(".submitVenue").click(function() {
                var venueName  = $("input[name=\'scheduling-venueName\']").val();
                $.post(
                    "'.Yii::$app->urlManager->createAbsoluteUrl(['scheduling-venue/create', 'ajax' => 1]).'",
                    {"MsupSchedulingVenue[venueName]" : venueName, "MsupSchedulingVenue[hash]" : hash, _crsf : _crsf},
                    function ( data ) {
                            if ( data.error_code == "1") {
                                $(".no-venue").hide();
                                $(".venues").append("<tr><td>"+venueName+"</td><td><i class=\'btn btn-xs btn-danger glyphicon glyphicon-remove remove-venues\'></i><input type=\'hidden\' value=\'"+data.id+"\'></td></tr>");
                            } else { 
                                return  false;
                                // console.log(data);
                            }
                    }, "json");
            })
            // 删除分会场
            $(".venues").on("click", ".remove-venues",function() {
                
                if (!confirm("确定删除该会场吗？")) return false;
                var venusId = $(this).next("input").val();
                var th = $(this);
                $.post(
                    "'.Yii::$app->urlManager->createAbsoluteUrl(["scheduling-venue/delete", "ajax" => 1]).'&id="+venusId,
                    {id:venusId},
                    function (data) {
                        if (data.error_code == "1") {
                            th.parent().parent().remove();
                        } else {
                            alert(data.message)
                        }
                    }, "json")
            })
    
            $(".clearCourses").click(function(){
                    if ( !($(".clearCourses").prop("disabled")) &&  confirm("您是否要清空排课") ) {
                            $(".venues-course-tables").each(function(){
                                $(this).find(".remove-venue-course").each(function(){
                                    removeVenueCourse($(this));
                                })
                            })
                            $(".venues-course-show").prop("disabled", false);
                    } else{
                        return false;
                    }
            })
            // 计算日期并显示日程
            $(".venues-course-show").click(function(){

                $(this).parent().next(".panel-body").show();
                var startTime = getTimeStamp( $(".startTime").val() );
                var endTime  = getTimeStamp( $(".endTime").val() );
                var timeDiff = dateDiff(startTime, endTime);
                if (!startTime) {alert("请选择开始时间");return false;}
                if (!endTime) {alert("请选择结束时间");return false;}
                // 如果修改了时间则重新生成表格
                if (timeDiff<0) {
                    alert("请输入正确的开始时间和结束时间");
                    return false;
                }
                if ( timeDiff>=0 && !$(this).attr("disabled")) {
                    //日期差
                    // if (timeDiff == 0) timeDiff = 1;
                    for(var i = 0; i <= timeDiff; i++) {
                        var titleDate = date("Y-m-d", startTime+(i*24*3600));

                        // 查看是否有此表格存在
                        if ( $("h5[date=\'"+titleDate+"\']").text() )
                        {
                            continue;
                        } 

                        var html = "<div class=\'panel panel-default np nml nmr row venues-course-tables emptyCourse\'>";
                        
                            html += "<h5 class=\'panel-heading nm\' date=\'"+titleDate+"\'>" + titleDate + "</h5>";

                            html += "<div class=\'panel-body  \'><table class=\'table table-bordered table-striped\'><thead><tr><th>分会场名称</th><th>课程标题</th><th>开始时间</th><th>结束时间</th> <th>删除</th></tr></thead><tbody></tbody>";

                            html += "</table></div></div>";

                        $("#venues-course .venues-course-body").append(html);
                    }

                    $(this).prop("disabled", true);
                }

            })

            
            $(".addCourseModal").click(function(){
                var startTime = getTimeStamp( $(".startTime").val() );
                var endTime  = getTimeStamp( $(".endTime").val() );
                var timeDiff = dateDiff(startTime, endTime);
                if (startTime && endTime && timeDiff >= 0) {
                    scopeTime = date("m月d日", startTime) + "-" + date("m月d日", endTime);
                    $("#venue-course-modal .modal-body").load("'.Yii::$app->urlManager->createAbsoluteUrl(['scheduling-venue-course/create','iframe' => 1, 's' => $id, 'k' => $keyName]).'");
                    $("#venue-course-modal").modal("show");
                }

            })

            // 添加分会场课程
            $(".submit-venue-course-modal").click(function(){
                len = $("#venue-course-modal table tbody tr").length;
                var id = "'.$id.'";
                var snid = $("#msupschedulingvenuecourse-snid").val();
                var courseid = $(".courseid").val();
                var title = $(".course-title").val();
                var venueName = $("#msupschedulingvenuecourse-snid").find("option:selected").text();
                var i = 1;
                $(".venue-course-table-tr").each(function(){
                  i++;
                  var date = $(this).find(".date").val();
                  var startTime = $(this).find(".choseStartTime").val();
                  var endTime   = $(this).find(".choseEndTime").val(); 
                  if (!startTime) { alert("请选择开始时间");return false;}
                  if (!endTime) { alert("请选择结束时间");return false;}
                 
                 if (!date) { alert("请选择正确的开始时间和结束时间");return false;}
                  var endTime   = $(this).find(".choseEndTime").val();
                    $.post(
                        "'.Yii::$app->urlManager->createAbsoluteUrl(['scheduling-venue-course/create', 'ajax' => 1]).'",
                        {   "MsupSchedulingVenueCourse['.$keyName.']" : id, "MsupSchedulingVenueCourse[snid]" : snid, "MsupSchedulingVenueCourse[date]" : date, "MsupSchedulingVenueCourse[startTime]" : startTime, "MsupSchedulingVenueCourse[endTime]": endTime, "MsupSchedulingVenueCourse[courseid]" : courseid },
                        function (data) {

                            $("#venues-course .venues-course-tables").each(function () {
                                
                                if ( $(this).find(".panel-heading").text() == date ) {

                                    $(this).removeClass("emptyCourse");
                                    var html  = "<tr>";
                                        html += "<td>"+venueName+"</td>";
                                        html += "<td>"+title+"</td>";
                                        html += "<td>"+startTime+"</td>";
                                        html += "<td>"+endTime+"</td>";
                                        html += "<td><span class=\' btn btn-xs  btn-danger glyphicon glyphicon-remove remove-venue-course\' venue-course-id=\'"+data.id+"\'</span><input type=\'hidden\' value=\'" +  data.id + "\'></td>";
                                        
                                    html += "</tr>";
                                    $(this).find("tbody").append(html);
                                }
                            })
                        }, "json")
                    $("#venue-course-modal").modal(\'hide\');
                })
            })
            
            //保存会场地址信息 
            $("form#scheduling").submit(function(){
                if ($("#msupscheduling-address").val() == "") {
                    $("#msupscheduling-address").val($("#msupscheduling-address").attr("placeholder"));
                }

            })
            $(".submit-this-form").click(function(event){
                if($(".remove-venue-course").length < 1){
                    alert("排课不能为空");
                    event.preventDefault();
                    return false;
                }
            })
            // 删除分会场课程
            $("#venues-course").on("click", ".remove-venue-course",function() {
                if (!confirm("确定删除该课程吗？")) return false;
                removeVenueCourse($(this));
            })
            function removeVenueCourse(ele) {
                        
                        var venusId = ele.next("input").val();
                        var th = ele;
                        $.post(
                            "'.Yii::$app->urlManager->createAbsoluteUrl(["scheduling-venue-course/delete", "ajax" => 1]).'&id="+venusId,
                            {id:venusId},
                            function (data) {
                                if (data.error_code == "1") {
                                    th.parent().parent().remove();
                                } else {
                                    alert(data.message)
                                }
                            }, "json")
            }
        ');
    
    $this->registerJsFile('@web/Public/plugin/select_address/js/plugins/angular/angular.min.js');
    $this->registerJsFile('@web/Public/plugin/select_address/js/selectAddress2.js');
    $this->registerJsFile('@web/Public/plugin/select_address/js/index.js');

?>