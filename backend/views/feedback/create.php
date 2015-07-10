<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupFeedback */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','Msup Feed Back'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Feed Backs'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-feed-back-create">
		
		    <?= $this->render('_form', [
		        'model' => $model,
		        'title' => $this->title
		    ]) ?>
</div>
