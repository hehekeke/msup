<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourse */

$this->title = Yii::t('app', 'Update Msup Course') . ':  ' . $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Msup Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->courseid, 'url' => ['view', 'id' => $model->courseid]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="msup-course-update">

	    <?= $this->render('_form', [
	        'model' => $model,
	        'courseusedtime' => $courseusedtime,
	        'coursetag' => $coursetag,
	        'title' => Yii::t('app', 'Update Msup Course') . ':  ' . Html::tag('small',$model->title)
	    ]) ?>
</div>
