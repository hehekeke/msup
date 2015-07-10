<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupSitesModelMap */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','Sites Model Map'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Sites Model Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-sites-model-map-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'models' => $models,
    ]) ?>

</div>
