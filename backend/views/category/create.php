<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupCategorys */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','Categorys'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Categorys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-categorys-create">
	    <?= $this->render('_form', [
	        'model' => $model,
	        'title' => $this->title
	    ]) ?>
</div>
