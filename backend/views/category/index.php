<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupCategorysSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Categorys');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class='msup-categorys-index'>

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
                        'modelClass' => Yii::t('app','Categorys'),
                    ]), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                // ['class' => 'yii\grid\SerialColumn'],
                                [
                                    'attribute' => 'listOrder',
                                ],

                                [
                                    'attribute' => 'id',
                                    'contentOptions' => [
                                        'style' => 'width:80px;'
                                    ]
                                ],
                                'catName',
                                [
                                    'attribute' => 'isRequired',
                                    'value' => function($model) {
                                        return $model->isRequiredLabels[$model->isRequired];
                                    }
                                ],
                                [   
                                    'class' => 'yii\grid\ActionColumn',
                                    'buttons' => [
                                        'view' => function(){return '';},
                                        'delete' => function($url, $model, $key) {
                                            // return '';
                                            return '<a class="btn btn-xs btn-danger" href="'.$url.'" title="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-trash"></span></a>'.' <a class="btn btn-xs btn-success" href="'.Yii::$app->urlManager->createAbsoluteUrl(['tags/create','pid' =>$key ]).'" title="添加标签" data-method="post" data-pjax="0"><span class="glyphicon glyphicon-plus"></span>添加标签</a>';
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

    </div>
    
</div>
