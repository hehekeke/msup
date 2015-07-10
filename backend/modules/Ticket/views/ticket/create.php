<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\modules\Ticket\models\MsupTickets */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => '门票种类',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Tickets'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-tickets-create">
    	<?= $this->render('_form', [
        'model' => $model,
        'title' => $this->title
    	]) ?>
</div>
