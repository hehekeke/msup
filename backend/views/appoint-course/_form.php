<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupAppointCourse */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-appoint-course-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'appId')->textInput() ?>

    <?= $form->field($model, 'time')->textInput(['maxlength' => 20]) ?>

    <?= $form->field($model, 'address')->textInput(['maxlength' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
