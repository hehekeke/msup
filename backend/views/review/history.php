<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MsupReviewSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Msup Reviews');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-review-index">

    <h1>
    <?= Html::encode($this->title) ?></h1>
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute'=>'id',
                'contentOptions'=>["style"=>'width:10px;'],
            ],
            'title',
            [
                'attribute'=>'model',
                'value' => function($data) {
                    $model = new \backend\models\MsupModel;
                    $row   = $model->findOne($data->model);
                    return $row->modelName;
                },
            ],
            [
                'attribute' => 'status',
                'value' => function($data) {
                    $model = new backend\models\MsupReview;

                    return $model->statusLabel($data->status);
                }

            ],
            // 'data:ntext',
            'created_admin',
            // 'review_admin',
            // 'created_at',
            // 'reviewed_at',
            // 'comment',
            // 'title',
            // 'commit',

            [   
                'class' => 'yii\grid\ActionColumn',
                'buttons' => [
                    'view' => function ($url,$data) {

                        return '<a class="showIframe btn btn-xs btn-info" href="'.$url.'&iframe=1" target="_view" title="查看" data-pjax="0" data-toggle="modal" data-target="#myModal" ><span class="glyphicon glyphicon-eye-open"></span></a>';
                    },
                    'update' => function ($url,$data) {
                            return '<a class="showIframe btn btn-xs btn-success"  href="'.$url.'&status=2&iframe=1" target="_view" title="审核通过" data-pjax="0" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-ok"></span></a>';
                    },
                    'delete' => function ($url,$data) {
                        return '<a class="showIframe btn btn-xs btn-danger" href="'.Yii::$app->urlManager->createAbsoluteUrl(['review/update','id'=>$data->id, 'status'=>2]).'&status=3&iframe=1" target="_view" title="审核不通过" data-pjax="0" data-toggle="modal" data-target="#myModal" ><span class="glyphicon glyphicon-remove"></span></a>';
                    }

                ],
            ],
        ],

    ]); ?>

</div>

<div class="modal fade" id="myModal"  tabindex="-1"  >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >


    </div>
  </div>
</div>
<?php 
    $this->registerJs(
            '$("#myModal").on("hidden.bs.modal",function(){
                $(this).removeData();
                window.location.reload();
            })'

        );
    
?>