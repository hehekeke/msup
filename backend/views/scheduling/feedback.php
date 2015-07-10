<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '《 '.$schedulingTitle.'》的课程列表';
if (!$title) $title = $this->title;
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
                    <p class="float-btn">
                        <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['scheduling/feedback-count', 'id' => Yii::$app->request->get('id')])?>" class="btn btn-info">查看反馈统计</a>
                    </p>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                [
                                    'label' => '课程编号',
                                    'value' => function($data) {

                                        return $data->course->courseNumber;
                                    },
                                    'contentOptions' => [ 
                                        'style' => 'width:100px'
                                    ]

                                ],

                                // 'courseid',
                                [
                                    'label' => '标题',
                                    'value' => function($data){
                                        return $data->course->title;
                                    }
                                ],
                                [
                                    'label' => '教练',
                                    'value' => function($data) {
                                        return $data->course->lecturer_id;
                                    }
                                ],
                                // 'sponsor',
                                // 'lecturer_id',
                                // [
                                //     'attribute' => 'usedtimeid',
                                //     'filter' => $courseUsedtimeFilter,
                                //     'value' => function($data) {
                                //         return $data->courseUsedtime->times[$data->courseUsedtime->hour];
                                //     }
                                // ],
                                [
                                    'header'=>'反馈人数',
                                    'value'=>function ($data){
                                        return count($data->feedback);
                                    },
                                    'contentOptions' => [ 
                                        'style' => 'width:100px'
                                    ]
                                ],
                                // 'num',
                                // 'desc',
                                // 'character',
                                // 'file:ntext',
                                // 'media:ntext',
                                // 'thumbs:ntext',
                                // 'content:ntext',

                                // [ 
                                //     'class' => 'backend\widget\ActionColumns',
                                //     'buttons' => [      
                                //         'view' => function($data){
                                //             return '';
                                //         }
                                //     ],

                                // ],
                            ],
                        ]); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
