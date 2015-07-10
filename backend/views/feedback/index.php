<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupFeedbackSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '反馈列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-feed-back-index">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= Html::encode($this->title)?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= Html::encode($this->title)?></div>
                    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
                    <div class="panel-body">
                        <p><?= Html::a(Yii::t('app', '提交反馈'), ['create'], ['class' => 'btn btn-success floatBtn']) ?></p>
                        <?php $models = \backend\models\MsupModel::modelDrpDownList();?>
                        <?php $status = [ '1' => '是', '2' => '否'];?>
                        <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            ['class' => 'yii\grid\SerialColumn'],
                            [
                                'attribute' => 'modelId',
                                'filter' =>$models,
                                'value' => function($data) {return $data->model->modelName;},
                                'contentOptions' => ['style' => 'width:120px;'],

                            ],
                            // 'id',
                            'title',
                            // 'description',
                            // 'updated_at',
                            'isAdopt' => [
                                'attribute' => 'isAdopt',
                                'contentOptions' => ['style' => 'width:120px;'],
                                'filter' => $status,
                            ],
                            'isSolve' => [
                                'attribute' => 'isSolve',
                                'contentOptions' => ['style' => 'width:120px;'],
                                'filter' => $status,
                            ],
                            'praise' => [
                                'attribute' => 'praise',
                                'contentOptions' => ['style' => 'width:80px;']
                            ],
                            [
                                'attribute' => 'create_admin',
                                'value' => function($data){return $data->user->username;},
                                'contentOptions' => ['style' => 'width:80px;']
                            ],
                            [
                                'class' => 'backend\widget\ActionColumns',
                                'buttons' => [
                                    'upldate' => function() {} 

                                ],
                            ],
                        ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
</div>
