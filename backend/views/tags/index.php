<?php

use yii\helpers\Html;
use yii\grid\GridView;
use backend\models\MsupCategorys;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupTagsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Tags');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-tags-index">
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
                            <?= Html::a(Yii::t('app', '添加标签'), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                // ['class' => 'yii\grid\SerialColumn'],

                                'id',
                                'tagName',
                                // 'level',
                                // [
                                //     'attribute' => 'catid',
                                //     'value' => function($data){
                                //         return $tagCates[$data->catid];
                                //     }
                                // ],
                                // 'hits',

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
