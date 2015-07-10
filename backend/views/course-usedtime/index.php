<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '课程时长管理');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-usedtime-index">


    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title)?></h1>
        </div>
    </div>
       
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">课程时长列表</div>
                    <div class="panel-body">
                    

                        <p>
                            <?= Html::a(Yii::t('app', 'Create Msup Course Usedtime'), ['create'], ['class' => 'btn btn-success']) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                'title',
                                'desc',
                                'created_at'=>[
                                    'header'=>'创建时间',
                                    'value'=>function($data){
                                        return date("Y-m-d", $data->updated_at); 
                                    }   
                                ],

                                ['class' => 'yii\grid\ActionColumn'],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>

</div>
