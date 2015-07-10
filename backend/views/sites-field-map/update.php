<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupSitesFieldMap */

$this->title = Yii::t('app', 'Update {modelClass}', [
    'modelClass' => Yii::t('app','Msup Sites Field Map'),
]) . ' : ' . $model->coreFieldName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Sites Field Maps'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-sites-field-map-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
