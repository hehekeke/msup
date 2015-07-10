<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Auth Items');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-auth-item-index">

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
                        
                        <p>
                                    <?= Html::a(Yii::t('app', 'Create {modelClass}', [
                                        'modelClass' => Yii::t('app','Msup Auth Item'),
                                    ]), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                // ['class' => 'yii\grid\SerialColumn'],
                                [

                                    'attribute'=>'type',
                                    'value'=>function($data) {
                                        if ($data->type == 1) {
                                            return "角色";
                                        }else {
                                            return "权限";
                                        }
                                    },

                                ],
                                'description:ntext',
                                'rule_name',
                                // 'data:ntext',
                                // 'created_at',
                                // 'updated_at',
                                [   'header'=>'操作',

                                    'class' => 'yii\grid\ActionColumn'
                                ],
                                [
                                 'label'=>'更多操作',
                                 'format'=>'raw',
                                 'value'=>function($data) {

                                        return Html::a("修改权限",['assignment', 'name'=>$data->name], ['class'=>"btn btn-primary"]); 
                                 }
                                ]


                            ]
                        ]); ?>
                       
                    </div>
                </div>
            </div>
        </div>

    
</div>
