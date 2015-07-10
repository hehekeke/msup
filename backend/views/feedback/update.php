<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupFeedback */

$this->title = '更新反馈信息：'. $model->title;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Feed Backs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-feed-back-update">

		    <?= $this->render('_form', [
		        'model' => $model,
		        'title' => '更新反馈信息：'. Html::tag('small', $model->title),
		    ]) ?>	
</div>
