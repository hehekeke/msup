<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\widget\DateTimeControl;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupSchedulingSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-scheduling-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <!-- <?= $form->field($model, 'id') ?> -->

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'startTime')->widget(DateTimeControl::className(), [                        'fieldName' => 'MsupSchedulingSearch[startTime]',
                                'value' => $model->startTime,
                                'renderInput' => 1,
                                'contentOptions' => [
                                    'class' => 'form-control time startTime',
                                    'maxlength' => 12,

                                    // 'data-provide' =>'datepicker-inline'
                        ],]) ?>
    <?= $form->field($model, 'endTime')->widget(DateTimeControl::className(), [                        'fieldName' => 'MsupSchedulingSearch[endTime]',
                                'value' => $model->endTime,
                                'renderInput' => 1,
                                'contentOptions' => [
                                    'class' => 'form-control time endTime',
                                    'maxlength' => 12,
                                    // 'data-provide' =>'datepicker-inline'
                        ],]) ?>
    
    <!-- <?= $form->field($model, 'price') ?> -->

    <?php // echo $form->field($model, 'video') ?>

    <?php // echo $form->field($model, 'address') ?>

    <?php // echo $form->field($model, 'catid') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
