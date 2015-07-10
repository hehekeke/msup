<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel backend\modules\Ticket\models\MsupSchedulingTicketSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', $title);
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-ticket-index">
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header"><?= Html::encode($this->title)?></h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">出票信息列表</div>
                <div class="panel-body">   
                <p><?= Html::a(Yii::t('app', '添加出票信息'), ['create', 'schedulingId' => $_GET['schedulingId']], ['class' => 'btn btn-success floatBtn']) ?></p>
                <?php $model = new backend\modules\Ticket\models\MsupSchedulingTicket;
                      $isSelledFilter = $model->getSelledLabel();
                      $isActivationFilter =  $model->getActiviedLabel();
                      $create_admin = '';
                ?>
                    <?= GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => [
                            // ['class' => 'yii\grid\SerialColumn'],
                            // 'id',
                            // 'stid',
                            [
                                'attribute' => 'bank',
                                'contentOptions' => ['width' => 80]
                            ],
                            [
                                'attribute' => 'purchase',
                                'value' => function($data){return $data->userMemberInfo['name'];},
                                'contentOptions' => ['width' => 80]

                            ],
                            [
                                'label' => '公司名',
                                'value' => function($data) {return $data->userMemberInfo['company'];},
                                // 'contentOptions' => ['style' => 'width:20px;'],
                            ],
                            [
                                'attribute' => 'stid',
                                'value' => function($data) {return $data->schedulingTickets->tickets['title'];},
                                'contentOptions' => ['width' => 200]

                            ],
                            [
                                'attribute' => 'created_at',
                                'value' => function($data){return date('Y-m-d H:i', $data->created_at);},
                                'contentOptions' => ['width' => 150]

                            ],
                            [
                                'attribute' => 'create_admin',
                                'value' => function($data){return $data->user->username;},
                                'contentOptions' => ['width' => 100],
                                'filter' => $create_admin,

                            ],
                            [
                                'attribute' => 'isActivation',
                                'filter' => $isActivationFilter,
                                'value' => function($model) use ($isActivationFilter) {
                                    return $isActivationFilter[$model->isActivation];
                                },
                                'contentOptions' => ['width' => 80]

                            ],
                            [
                                'label' => '转移门票',
                                'format' => 'html',
                                'value' => function($model){

                                    return Html::a('转移',['move-ticket', 'id' => $model->id],['class' =>'btn btn-danger moverTicket', 'onclick'=>'alert("转移门票将删除此门票")']);
                                }
                            ],
                            // 'purchase',
                            // 'owner',

                            [
                                'class' => 'backend\widget\ActionColumns',
                                // 'buttons' => [
                                //     'update' => function($url,$data) {
                                //         // return $url.'&schedulingId='.$data->sid,
                                //     }
                                // ],
                            ],
                        ],
                    ]); ?>
                </div>
            </div>
        </div>
<?=
    $this->registerJs('
    $(function(){
        // $(".moverTicket").click(function(){
        //     if (!confirm("转移门票将删除此门票,确定要转移吗")){
        //         return false;
        //     }
        // })
    })
        ');
?>
    </div>

</div>
 