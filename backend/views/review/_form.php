<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupReview */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-review-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'model')->textInput() ?>

    <?= $form->field($model, 'status')->dropDownList($model->statusLabel) ?>

    <?= $form->field($model, 'data')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'created_admin')->textInput() ?>

    <?= $form->field($model, 'review_admin')->textInput() ?>

    <?= $form->field($model, 'created_at')->textInput() ?>

    <?= $form->field($model, 'reviewed_at')->textInput() ?>

    <?= $form->field($model, 'comment')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => 500]) ?>

    <?= $form->field($model, 'commit')->textInput(['maxlength' => 30]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
