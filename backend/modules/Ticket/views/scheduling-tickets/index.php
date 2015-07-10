<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\Ticket\models\MsupSchedulingTicketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '门票种类信息');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-tickets-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title)?></h1>
        </div>
    </div>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        门票种类列表
                    </div>
                     <div class="panel-body">
                        <p>
                            <?= Html::a(Yii::t('app', '添加门票种类信息'), ['create', 'schedulingId' => Yii::$app->request->get('schedulingId')], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                'id',
                                [
                                    'attribute' => 'tid',
                                    'value' => function ($schedulingTicket) {
                                        return  $schedulingTicket->tickets->title;
                                    }
                                ],
                                'uper',
                                'create_admin',
                                // 'sold',

                                ['class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function($url, $data){
                                            return '<a class="btn btn-xs btn-success" href="'.$url.'" title="查看" data-pjax="0"><span class="glyphicon glyphicon-eye-open"></span></a> <a class="btn btn-xs btn-warning" href="'.Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $data->sid, 'schedulingIdTicketsId' => $data->tid]).'" title="门票列表" data-pjax="0"><span class="glyphicon glyphicon-th-list"></span></a>';
                                        }
                                    ]
                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

</div>
 