<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupContactNotes */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-contact-notes-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'toId')->textInput() ?>

    <?= $form->field($model, 'userid')->textInput() ?>

    <?= $form->field($model, 'toModel')->textInput() ?>

    <?= $form->field($model, 'notes')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'remarks')->textInput(['maxlength' => 255]) ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
