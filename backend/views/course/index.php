<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '课程列表';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-index">

        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= $title?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading"><?= $title ?></div>
                    <div class="panel-body">
                        
                        <p>
                            <?= Html::a(Yii::t('app', 'Create Msup Course'), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
                        </p>

                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                'courseNumber',
                                'title',
                                // 'sponsor',
                                'lecturer_id',
                                [
                                    'attribute' => 'usedtimeid',
                                    'filter' => $courseUsedtimeFilter,
                                    'value' => function($data) {
                                        return $data->courseUsedtime->times[$data->courseUsedtime->hour];
                                    }
                                ],
                                'price',
                                // 'num',
                                // 'desc',
                                // 'character',
                                // 'file:ntext',
                                // 'media:ntext',
                                // 'thumbs:ntext',
                                // 'content:ntext',

                                [ 
                                    'class' => 'backend\widget\ActionColumns',
                                    'buttons' => [      
                                        'view' => function($data){
                                            return '';
                                        }
                                    ],

                                ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
