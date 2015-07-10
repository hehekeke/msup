<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupSchedulingTicket */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title)?>
        <small>带<span class="required">*</span>的为必填项</small></h1>
    </div>
</div>

<div class="row">
    <div class="col-xs-12">
        <div class="msup-scheduling-ticket-form">
            <div class="row">
            <div class="col-xs-12">
                <div class="panel panel-default">
                    <div class="panel-heading">出票信息</div>
                    <div class="panel-body">
                    <h5 class="alert alert-danger">请注意，确认添加后将自动生成票号并通过短信和邮箱发送给您填入的手机号和邮箱</h5>
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'stid')->dropDownList($ticketDownList)?>
                        <?= $form->field($userModel, 'phone')->textInput()?>
                        <?= $form->field($userModel, 'email')->textInput()?>
                        <?= $form->field($memberInfoModel, 'name')->textInput()?>
                        <?= $form->field($memberInfoModel, 'company')->textInput()?>
                        <?= $form->field($memberInfoModel, 'position')->textInput()?>
                        <div class="col-xs-12 np form-group">
                            <label class="form-label">邮件打开链接 <span class="required">(此处显示的是默认链接，可以修改)</span></label>
                            <div class="input-group">
                                <?= Html::input('text', $model->formName().'[linkUrl]', $model->linkUrl,['class' => 'form-control', 'id'=>$model->formName().'-linkUrl']) 
                                ?>
                               <span class="input-group-addon " title="立即预览" style="background: #00a2e6;color:#fff;">

                                    <a href="<?= $model->linkUrl ?>" target="_blank">
                                        <i class="glyphicon glyphicon-eye-open" style="color:#fff;">
                                        </i>
                                    </a>
                                </span>
                            </div>
                        </div>
                        <div class="col-xs-12 np"> 
                            <div class="form-group" >
                                <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary', 'id' => 'btn-submit']) ?>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
    
    <?php ActiveForm::end(); ?>
<style type="text/css"></style>
</div>
<?= 
    $this->registerJs(
    '
        var hasClickSubmit = 0;
        $("#btn-submit").click(function(){
            if(!hasClickSubmit) {
                hasClickSubmit = 1;
                if (confirm("确定出票吗？")) {
                    return true;
                } else {
                    return false;
                }
            }
        })
        $("input").focus(function(){
            hasClickSubmit = 0;
        })
        $("#msupusermember-phone").focus(function(){
            $("#msupusermember-email").val("");
            $("#msupmemberinfo-company").val("");
            $("#msupmemberinfo-position").val("");
            $("#msupmemberinfo-name").val("");
        })
        function fillInput(data){
            $("#msupmemberinfo-company").val("");
            $("#msupmemberinfo-position").val("");
            $("#msupmemberinfo-name").val("");
            $("#msupmemberinfo-phone").val("");
            if ( data != null) {
                if (data.email){
                    $("#msupusermember-email").val(data.email)
                }
                if (data.phone) $("#msupusermember-phone").val(data.phone)
                if (data.memberInfo.name)  $("#msupmemberinfo-name").val(data.memberInfo.name)
                if (data.memberInfo.company) $("#msupmemberinfo-company").val(data.memberInfo.company)
                  if (data.memberInfo.position) $("#msupmemberinfo-position").val(data.memberInfo.position)
            }
         }
        $("#msupusermember-phone").blur(function(){
            var phone = $(this).val()
            var email = $("#msupusermember-email").val();
            $("#msupusermember-email").val("");
            if (phone) {
                $.get(
                    "'.Yii::$app->urlManager->createAbsoluteUrl(['user-member/get-member-full-info-by-phone-with-ajax']).'?phone="+phone,
                    function(data){
                        fillInput(data); 
                    },"json")
             }
        })
        $("#msupusermember-email").blur(function(){
            var phone =  $("#msupusermember-phone").val();
            if (phone) return false;
            var email = $(this).val()
            if (email) {
                $.get(
                    "'.Yii::$app->urlManager->createAbsoluteUrl(['user-member/get-member-full-info-by-email-with-ajax']).'?email="+email,
                    function(data){                
                        fillInput(data); 
                    },"json")
            }
        })
    '
        );
?>
