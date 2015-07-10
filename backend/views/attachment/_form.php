<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupAttachment */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-attachment-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'modelId')->textInput() ?>

    <?= $form->field($model, 'modelPk')->textInput(['maxlength' => 11]) ?>

    <?= $form->field($model, 'attachment')->textInput(['maxlength' => 300]) ?>

    <?= $form->field($model, 'status')->textInput() ?>

    <?= $form->field($model, 'hash')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
    
    <?php ActiveForm::end(); ?>

</div>
