<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupSchedulingVenueCourseSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Scheduling Venue Courses');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-venue-course-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Scheduling Venue Course',
]), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id',
            'sid',
            'snid',
            'courseid',
            'startTime:datetime',
            // 'endTime:datetime',
            // 'date',
            // 'hash',

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>

</div>
