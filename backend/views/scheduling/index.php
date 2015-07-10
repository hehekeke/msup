<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\widget\DateTimeControl;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupSchedulingSearch */
/* @var $data aovider yii\data\ActiveDataProvider */

$this->title = '排课列表';
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
                    <div class="panel-heading"><?= Html::encode($this->title)?></div>
                    <div class="panel-body">
                        <div class="searchView">
                        <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                        </div>
                        <p>
                            <a href="javascript:void(0)" class="btn btn-info floatBtn showSearchView">
                            <i class="glyphicon glyphicon-search"></i>
                            搜索</a>

                            <?= Html::a('添加排课', ['create'], ['class' => 'btn btn-success floatBtn ']) ?>
                        </p>

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
                                [
                                    'attribute' => 'title',
                                    'format' => 'html',
                                    'value' => function($model){
                                        return Html::a($model->title, Yii::$app->urlManager->createAbsoluteUrl(['scheduling/courses', 'id' => $model->id]));
                                    }
                                ],
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
                                    'contentOptions' => [ 'width' => '100'],
                                ],
                                // 'video',
                                // 'address',
                                // 'catid',

                                [
                                    'class' => 'backend\widget\ActionColumns',
                                    'buttons' => [
                                        'view' => function($url, $data) {
                                            return '<a title="门票种类管理" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-tickets/index', 'schedulingId' => $data->id]).'" class="btn btn-xs btn-primary"><i class="glyphicon glyphicon-th"></i></a>  <a title="门票信息" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/scheduling-all-ticket', 'schedulingId' => $data->id]).'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-th-list"></i></a><a title="门票信息" href="'.Yii::$app->urlManager->createAbsoluteUrl(['scheduling/feedback', 'id' => $data->id]).'" class="btn btn-xs btn-warning"><i class="glyphicon glyphicon-tag"></i></a>';
                                        },

                                    ],
                                    'contentOptions' => [
                                            'style' => 'width:123px;'
                                    ],
                                ], 
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