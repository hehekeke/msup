<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupSchedulingTickets */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-scheduling-tickets-form">

    <?php $form = ActiveForm::begin(); ?>
    <?= $form->field($ticketsModel, 'title')->textInput(['maxlength' => 300]) ?>

    <?= $form->field($ticketsModel, 'description')->textInput(['maxlength' => 300]) ?>
    <?= $form->field($ticketsModel, 'price')->textInput(['maxlength' => 10]) ?>

    <?= $form->field($model, 'uper')->textInput() ?>

    <?= $form->field($model, 'sold')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
