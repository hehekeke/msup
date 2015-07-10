<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupTodolist */
/* @var $form yii\widgets\ActiveForm */
?>
<h5 class="panel-heading nm"><?= Html::encode($this->title) ?></h5>
<div class="msup-todolist-form panel-body">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'listName')->textInput(['maxlength' => 50]) ?>

    <?= $form->field($model, 'listClass')->textInput(['maxlength' => 100]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
