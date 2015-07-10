<?php

use yii\helpers\Html;
/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourse */

$this->title = Yii::t('app', 'Create Msup Course');
$this->params['breadcrumbs'][] = ['label' => 'Msup Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-create">
	    <?= $this->render('_form', [
	        'model' => $model,
	        'courseusedtime' => $courseusedtime,
	        'coursetag' => $coursetag,
	        'title' => $this->title
	    ]) ?>
</div>
