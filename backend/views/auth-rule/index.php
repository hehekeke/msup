<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app','Msup Auth Rules');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-auth-rule-index panel panel-default">

        <div class="panel-heading"><?= Html::encode($this->title) ?></div>
        <div class="panel-body">
            
        <p>
            <?= Html::a(Yii::t('app','Create Msup Auth Rule'), ['create'], ['class' => 'btn btn-success']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                'name',
                [
                    'attribute'=>'created_at',
                    'format'=>'date'
                ],
                [
                    'attribute'=>'updated_at',
                    'format'=>'date',
                ],

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
    </div>
    
</div>
