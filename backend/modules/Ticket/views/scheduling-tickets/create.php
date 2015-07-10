<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupSchedulingTickets */

$this->title = Yii::t('app', '添加门票种类信息');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Scheduling Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-tickets-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'ticketsModel' => $ticketsModel,
    ]) ?>
</div>
