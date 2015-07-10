<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupSchedulingVenueSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '分会场列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-venue-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Scheduling Venue',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sid',
            'venueName',
            'hash',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
