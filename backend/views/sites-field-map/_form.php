<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupSitesFieldMap */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-sites-field-map-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'siteField')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'siteFieldName')->textInput(['maxlength' => 30]) ?>

    <?= $form->field($model, 'coreField')->textInput(['maxlength' => 20]) ?>
    <?= $form->field($model, 'coreFieldName')->textInput(['maxlength' => 30]) ?>

    
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
