<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourseSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-course-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title') ?>

    <?= $form->field($model, 'courseid') ?>

    <?= $form->field($model, 'assignTo') ?>

    <?= $form->field($model, 'sponsor') ?>

    <?= $form->field($model, 'lecturer_id') ?>

    <?php // echo $form->field($model, 'usedtimeid') ?>

    <?php // echo $form->field($model, 'price') ?>

    <?php // echo $form->field($model, 'training') ?>

    <?php // echo $form->field($model, 'content') ?>

    <?php // echo $form->field($model, 'num') ?>

    <?php // echo $form->field($model, 'tag') ?>

    <?php // echo $form->field($model, 'desc') ?>

    <?php // echo $form->field($model, 'speech') ?>

    <?php // echo $form->field($model, 'character') ?>

    <?php // echo $form->field($model, 'profit') ?>

    <?php // echo $form->field($model, 'target') ?>

    <?php // echo $form->field($model, 'trainees') ?>

    <?php // echo $form->field($model, 'teacher') ?>

    <?php // echo $form->field($model, 'type') ?>

    <?php // echo $form->field($model, 'relation') ?>

    <?php // echo $form->field($model, 'appointment') ?>

    <?php // echo $form->field($model, 'priceDesc') ?>

    <?php // echo $form->field($model, 'file') ?>

    <?php // echo $form->field($model, 'media') ?>

    <?php // echo $form->field($model, 'thumbs') ?>

    <?php // echo $form->field($model, 'other') ?>

    <?php // echo $form->field($model, 'auditionvideo') ?>

    <?php // echo $form->field($model, 'auditiondesc') ?>

    <?php // echo $form->field($model, 'create_admin') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'update_admin') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'praises') ?>

    <?php // echo $form->field($model, 'appointmentTime') ?>

    <?php // echo $form->field($model, 'collects') ?>

    <?php // echo $form->field($model, 'comments') ?>

    <?php // echo $form->field($model, 'hits') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'lead_source') ?>

    <?php // echo $form->field($model, 'courseNumber') ?>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(Yii::t('app', 'Reset'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>