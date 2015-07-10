<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\Ueditor;
/* @var $this yii\web\View */
/* @var $model backend\models\MsupFeedback */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-feed-back-form">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= $title?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">基本信息</div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'title')->textInput(['maxlength' => 200]) ?>
                        <div class="form-group">
                            <label class="form-label"> 详细信息 </label>
                            <?= Ueditor::widget(['fieldName'=> 'MsupFeedback[description]','id'=>'Ueditor', 'content'=>$model->description])?>
                        </div>

                        <?= $form->field($model, 'modelId')->dropDownList($model->modelDropDownList()) ?>
                        <?php if(!$model->isNewRecord) :?>
                        
                        <?= $form->field($model, 'isSolve')->dropDownList(['1' => '是', '2'=>'否'])?>
                        <?= $form->field($model, 'isAdopt')->dropDownList(['1' => '是', '2'=>'否'])?>
                        <?php endif;?>
                        <div class="form-group">
                            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    <?php ActiveForm::end(); ?>

</div>
