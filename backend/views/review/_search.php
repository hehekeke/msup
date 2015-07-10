<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupReviewSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-review-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'model') ?>

    <?= $form->field($model, 'status') ?>

    <?= $form->field($model, 'data') ?>

    <?= $form->field($model, 'created_admin') ?>

    <?php // echo $form->field($model, 'review_admin') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'reviewed_at') ?>

    <?php // echo $form->field($model, 'comment') ?>

    <?php // echo $form->field($model, 'title') ?>

    <?php // echo $form->field($model, 'commit') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
