<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupScheduling */

$this->title = '编辑课程排期: '.$model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Schedulings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-scheduling-update">
	
    <?= $this->render('_form', [
        'model' => $model,
        'venues' => $venues,
        'venueCourses' => $venueCourses,
        'title' => '编课程排期: '.Html::tag('small',$model->title),
    ]) ?>

</div>
