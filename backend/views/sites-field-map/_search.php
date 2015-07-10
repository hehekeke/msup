<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupSitesFieldMapSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-sites-field-map-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'siteField') ?>

    <?= $form->field($model, 'coreField') ?>

    <?= $form->field($model, 'mapId') ?>

    <?= $form->field($model, 'siteFieldName') ?>

    <?php // echo $form->field($model, 'coreFieldName') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
