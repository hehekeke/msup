<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupSchedulingTicketsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-scheduling-tickets-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'tid') ?>

    <?= $form->field($model, 'sid') ?>

    <?= $form->field($model, 'uper') ?>

    <?= $form->field($model, 'create_admin') ?>

    <?php // echo $form->field($model, 'sold') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
