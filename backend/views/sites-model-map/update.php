<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupSitesModelMap */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Msup Sites Model Map',
]) . ' ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Sites Model Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-sites-model-map-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $models
        
    ]) ?>

</div>
