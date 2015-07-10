<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupHistory */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-history-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'lastCommit')->textInput() ?>

    <?= $form->field($model, 'commit')->textInput() ?>

    <?= $form->field($model, 'fieldName')->textInput(['maxlength' => 100]) ?>

    <?= $form->field($model, 'fieldValue')->textInput(['maxlength' => 300]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
