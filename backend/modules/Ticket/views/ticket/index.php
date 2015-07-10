<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\Ticket\models\MsupTicketsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Tickets');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-tickets-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title)?></h1>
        </div>
    </div>
        
        <!-- 资料维护信息统计 -->
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    
                    <div class="panel-heading">
                        门票种类列表
                    </div>
                    <div class="panel-body">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

                        <p>
                            <?= Html::a(Yii::t('app', '添加门票种类'), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>

                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],

                            'id',
                            'title',
                            'description',
                            'price',
                            'prefix',
                            // 'isUsed',
                            // 'create_admin',
                            // 'createdat',
                            // 'update_admin',
                            // 'updatedat',
                            // 'isCanChanged',
                            ['class' => 'yii\grid\ActionColumn'],
                        ],
                    ]); ?>

</div>
