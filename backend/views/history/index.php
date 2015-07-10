<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupHistorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Histories');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='msup-history-index panel panel-default'>

    <div class='panel-heading'><?= Html::encode($this->title) ?></div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <div class="panel-body">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        // 'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute'=> 'title',
                'value' => function($data){
                    return $data->review['title'];
                }
            ],
            'lastCommit',
            'commit',
            [
                'attribute' => 'comment',
                'value' => function($data){
                    return $data->review['comment'];
                }
            ],
            // 'fieldName',
            // 'fieldValue',
            // [
            //     'attribute'=> 'title',
            //     'value' => function($data){
            //         return $data->review['title'];
            //     }
            // ],

            ['class' => 'yii\grid\ActionColumn'],
        ],
    ]); ?>
    </div>
</div>
