<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourseUsedtime */

$this->title = Yii::t('app', 'Update Msup Course Usedtime').': ' . ' ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Msup Course Usedtimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->usedtimeid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="msup-course-usedtime-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
