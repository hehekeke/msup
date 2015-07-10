<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupSchedulingTicket */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Msup Scheduling Ticket',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Scheduling Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-scheduling-ticket-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
