<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\widget\DateTimeControl;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupSchedulingSearch */
/* @var $data aovider yii\data\ActiveDataProvider */

$this->title = '我的出票';
$this->params['breadcrumbs'][] = $this->title;
?>

<style type="text/css">
    .searchView{display: none}
    .showSearchView{margin-left: 15px;}
</style>
<div class="msup-scheduling-index">

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title)?></h1>
        </div>
    </div>
       
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Html::encode($this->title)?>列表</div>
                    <div class="panel-body">
                        <div class="searchView">
                        </div>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'attribute' => 'id',
                                    'contentOptions' => [
                                        'style' => 'width:20px;'
                                    ]
                                ],
                                'title',
                                [
                                    'attribute' => 'startTime',
                                    'format' => 'date',
                                    'contentOptions' => [ 'width' => '120'],
                                    'filter' => '',
                                ],
                                [
                                    'attribute' => 'endTime',
                                    'format'=>'date',
                                    'contentOptions' => [ 'width' => '120'],
                                    'filter' => '',

                                ],
                                [
                                    'attribute' => 'applicans',
                                    'value' => function($data) {

                                        return $data->applicans;
                                    },
                                    'contentOptions' => [ 'width' => '100'],
                                ],
                                // 'video',
                                // 'address',
                                // 'catid',
                                [
                                    'label' => '操作',
                                    'format' => 'html',
                                    'value' => function($url, $data){
                                         return ' <a title="添加一张门票" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/create', 'schedulingId' => $data]).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i></a> '.'<a title="我的门票" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $data]).'" class="btn btn-xs btn-info">我的门票</a> ';
                                    }
                                ],
                                    // 'class' => 'backend\widget\ActionColumns',
                                    // 'template' => ' {delete} {update}',
                                    // 'buttons' => [
                                    //     'update' => function($url, $data){
                                    //         return '<a title="我的门票" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $data->id]).'" class="btn btn-xs btn-info">我的门票</a>';
                                    //     },
                                    //     'delete' => function($url, $data){
                                    //         return '<a title="添加一张门票" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/create', 'schedulingId' => $data->id]).'" class="btn btn-xs btn-success"><i class="glyphicon glyphicon-plus"></i></a>';
                                    //     },


                                    // ],
                                // ], 
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
</div>
<?php 
$this->registerJs(
    '$(".showSearchView").click(function(){ $(".searchView").slideToggle()})'

    );
?>