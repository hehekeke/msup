<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupTickets */
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
        <div class="msup-tickets-form">
            <div class="panel panel-default">
                <div class="panel-heading">门票种类信息</div>
                <div class="panel-body">
                    <?php $form = ActiveForm::begin(); ?>

                    <?= $form->field($model, 'title')->textInput(['maxlength' => 300]) ?>

                    <?= $form->field($model, 'description')->textInput(['maxlength' => 300]) ?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => 10]) ?>

                    <?= $form->field($model, 'prefix')->textInput(['maxlength' => 5]) ?>

                    <?= $form->field($model, 'isUsed')->textInput() ?>

                    <?= $form->field($model, 'isCanChanged')->textInput() ?>

                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>

                    <?php ActiveForm::end(); ?>
                </div>
            </div>
        </div>
    </div>
</div>
