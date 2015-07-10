<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupDirectory */

$this->title = Yii::t('app', 'Create Msup Lecturer');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Lecturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-lecturer-create">
	    <?= $this->render('_form', [
	        'model' => $model,
	        'tags'  => $tags,
	        'title' => $this->title,
	    ]) ?>
</div>
