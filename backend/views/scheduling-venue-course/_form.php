<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupSchedulingVenueCourse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class='msup-scheduling-venue-course-form'>
    <?php $form = ActiveForm::begin(); ?>

<div class='panel panel-default'>
    <div class='panel-heading nm'>添加课程</div>
    <div class='panel-body'>

        <?=  empty($row) ? '<h5>分会场：无分会场</h5>' :$form->field($model, 'snid')->dropDownList($row);?>

        <div class='form-group'>
            <label for='' class='form-label'>选择课程</label>
            <div class='row nmr'>
                <div class='col-xs-8'>
                    <input type='text' readonly="readonly" class='form-control course-title' value='' />
                    <input type="hidden" class="courseid">
                </div>
                <a  data-toggle="modal"  id='venue-course-relation' class='col-xs-4 btn btn-info '>搜索课程</a>
            </div>
            <br>
            <div class="panel panel-default">
                <div class="panel-heading">时间调整（时间范围：<span class="time-scope"></span>）</div>
                <div class="panel-body venue-course-body">
                    <table class='table table-bordered table-striped'>
                        <thead>
                            <tr>
                                <th>日期</th>
                                <th>开始时间</th>
                                <th>结束时间</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<?php 
    $this->registerJs('
    if(scopeTime) {
                    $(".time-scope").text(scopeTime);
    }
            $("#venue-course-relation").click(function() {
                $("#course-modal").removeData();
                $("#course-modal").modal({remote:"'.Yii::$app->urlManager->createAbsoluteUrl(['scheduling-venue-course/chose-course', 'iframe' => 1]).'"});

            })
            // $(".dismiss-course-modal").click(function(){
            //     $("#course-modal").modal("hide");
            // })
        ');

?>
<?php ActiveForm::end(); ?>

</div>

