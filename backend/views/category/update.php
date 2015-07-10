<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCategorys */

$this->title = '更新栏目: '. $model->catName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Categorys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-categorys-update">

	    <?= $this->render('_form', [
	        'model' => $model,
	        'title' => '更新栏目: '. Html::tag('small',$model->catName),
	    ]) ?>

</div>
