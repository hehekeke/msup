<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupSitesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Sites');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-sites-index">

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
                        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <p>
                            <?= Html::a(Yii::t('app', 'Create {modelClass}', [
                                        'modelClass' => Yii::t('app','Msup Sites'),
                                ]), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn'],
                                'siteName',
                                'siteUrl:url',
                                [   
                                    'header' => '基本操作',
                                    'class' => 'yii\grid\ActionColumn'],
                                [
                                    'header' => '更多操作',
                                    'format' => 'raw',
                                    'value'  => function($data) {
                                            
                                        return "<a class='btn btn-primary' href='".Yii::$app->urlManager->createAbsoluteUrl( ['sites-model-map/index','siteId'=>$data->id] )."'>数据映射</a>";
                                       
                                    }
                                ]
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

</div>
