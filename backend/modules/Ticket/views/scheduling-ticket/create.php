<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupSchedulingTicket */

$this->title = Yii::t('app', '添加票务信息');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Scheduling Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-ticket-create">

    

    <?= $this->render('_form', [
        'model' => $model,
        'userModel' => $userModel,
        'memberInfoModel' =>  $memberInfoModel,
        'ticketDownList' => $tickets,
    ]) ?>

</div>
