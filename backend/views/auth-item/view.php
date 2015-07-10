<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupAuthItem */

$this->title = $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Auth Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-auth-item-view">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title)?></h1>
            <p>
                <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->name], ['class' => 'btn btn-primary']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->name], [
                    'class' => 'btn btn-danger',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>
        </div>
    </div>
       
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">教练信息</div>
                <div class="panel-body">
                    <h1><?= Html::encode($this->title) ?></h1>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'name',
                            'type',
                            'description:ntext',
                            'rule_name',
                            // 'data:ntext',
                            [
                                'attribute'=>'created_at',
                                'format'=>'date',
                            ],
                            [
                                'attribute'=>'updated_at',
                                'format'=>'date'
                            ]
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
