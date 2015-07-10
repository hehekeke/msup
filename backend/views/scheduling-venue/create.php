<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupSchedulingVenue */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Scheduling Venue',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Scheduling Venues'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-venue-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
