<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupSchedulingVenueCourse */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Scheduling Venue Course',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Scheduling Venue Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-venue-course-create">


    <?= $this->render('_form', [
        'model' => $model,
        'row' => $row,
        'venues' => $venues,
    ]) ?>

</div>
