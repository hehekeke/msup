<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupSitesModelMapSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Sites Model Maps');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-sites-model-map-index">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','Sites Model Map'),
]), [ 'create', 'siteId'=>Yii::$app->request->get("sitesId") ], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            // ['class' => 'yii\grid\CheckBoxColumn'],
            [
                'attribute'=>'id',
                'options'=>['style'=>'color:#f00'],
                
            ],
            'name',
            [
                'attribute'=>'model',
                'value' => function($data) {
                    $model = new \backend\models\MsupModel;
                    $row   = $model->findOne($data->model);
                    return $row->modelName;
                },


            ],
            'table',
            ['class' => 'yii\grid\ActionColumn'],
            [
                'header' => '更多操作',
                'format' => 'raw',
                'value' => function($data) {
                      return "<a class='btn btn-primary' href='".Yii::$app->urlManager->createAbsoluteUrl( ['sites-field-map/index','map'=>$data->id] )."'>字段映射</a><a class='btn btn-primary' href='".Yii::$app->urlManager->createAbsoluteUrl( ['sync/index','map'=>$data->id] )."'>数据导入</a>";
                },
            ]
        ],
    ]); ?>

</div>
