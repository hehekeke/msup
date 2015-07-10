<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use backend\widget\TimelySearch;
use backend\components\Integrity;
use backend\widget\DateTimeControl;
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = $title;
$this->params['breadcrumbs'][] = $title;
$integrity = new Integrity;
?>

<style type="text/css">

    .pagination{float:right;}
    .eventAlll{float: left;margin-top: 25px;}
    table.table.table-striped.table-bordered{margin-bottom: 0;}
</style>
<div class="msup-lecturer-index">
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
                        教练列表
                    </div>
                    <div class="panel-body">
                        <p><?= Html::a(Yii::t('app', 'Create Msup Lecturer'), ['create'], ['class' => 'btn btn-success floatBtn']) ?></p>
                        <?= GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'columns' => [
                                ['class' => 'yii\grid\CheckboxColumn'],

                                // 'id',
                                [
                                    'attribute' => 'name',
                                    'contentOptions' => [
                                        'style' => 'width:100px;'
                                    ],
                                ],
                                [
                                    'attribute' => 'penName',
                                    'contentOptions' => [
                                        'style' => 'width:100px;'
                                    ],
                                ],
                                [
                                    'attribute' => 'company',
                                    'contentOptions' => [
                                        'style' => 'width:100px;'
                                    ],
                                ],
                                [
                                    'attribute'=>'position',
                                    'value'=>function($data) {
                                        return mb_substr($data->position, 0,6,'utf-8');
                                    },
                                    'contentOptions' => [
                                        'style' => 'width:120px;'
                                    ],
                                ],
                                [
                                    'label'=> '维护人',
                                    'value' => function($data) {
                                        return $data->assignment->user->username;
                                    },
                                    'contentOptions' => [
                                        'style' => 'width:80px;'
                                    ],

                                ],
                                [
                                    'label' => '完善度',
                                    'contentOptions' => [
                                        'style' => 'width:80px;'
                                    ],
                                    'format' => 'html',
                                    'value' => function ($data) use ($integrity) {
                                        return Html::tag("span",$integrity->toHtml( $integrity->getIntegrityByObj($data) ), ['style' => 'color:#f00;font-size:16px;']) ;
                                    }
                                ],
                                // 'phone',
                                // 'email:email',
                                // 'qq',
                                // 'wecat',

                                // 'referee',
                                // 'leadSource',
                                // 'thumbs',
                                // 'signature',

                                // 'created_at'=>[
                                //     'header'=>"添加时间",
                                //     'value'=>function($data){

                                //         return date("Y-m-d", $data->created_at); 
                                //     }   
                                // ],
                                [
                                    'label' => '最后维护时间',
                                    'value'=>function($data){

                                        return date("Y-m-d H:i", $data->updated_at); 
                                    },
                                    'contentOptions' => [
                                        'style' => 'width:140px;'
                                    ],
                                ],

                                [
                                    'class' => 'backend\widget\ActionColumns',
                                    'buttons' => [
                                        //教练信息不允许被删除
                                        'delete' => function($url, $row, $key) use ($lecturerAssignment){
                                            $return = '';
                                            //如果是该用户维护的教练则显示联系按钮
                                            if (in_array($row->id, $lecturerAssignment)) {
                                                $return = Html::a('', 'javascript:void(0)', [
                                                    'class' => 'btn btn-primary glyphicon btn-xs glyphicon-link contact_event',
                                                    'lid' => $row->id
                                                ]);
                                            }
                                            if (Yii::$app->user->identity->role == '超级管理员') {
                                                $return .= ' '.Html::a('', Yii::$app->urlManager->createAbsoluteUrl(['lecturer/delete', 'id'=>$row->id]), [
                                                    'class' => 'btn btn-danger glyphicon btn-xs glyphicon-trash',"data-confirm"=>"您确定要删除此项吗？", "data-method" => "post", "data-pjax" => "0"]);
                                            }
                                            return $return;
                                        }
                                    ],
                                ],
                            ],
                        ]); ?>
                        <div>
                            <!-- Split button -->
                            <div class="btn-group dropup eventAlll">
                              <button type="button" class="btn btn-danger">选中项批量操作</button>
                              <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                                <span class="caret"></span>
                                <span class="sr-only">选中项</span>
                              </button>
                              <ul class="dropdown-menu" role="menu">
                                <li><a href="#"><i class="glyphicon glyphicon-print"></i> <span> 打印</span></a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-comment"></i> <span> 发送短信</span></a></li>
                                <li><a href="#"><i class="glyphicon glyphicon-envelope"></i> <span> 发送邮件</span></a></li>
                                <li><a href="javascript:void(0)" class="assignment_event"><i class="glyphicon glyphicon-paperclip"></i> <span> 分配教练</span></a></li>
                                <!-- <li class="divider"></li> -->
                                <!-- <li><a href="#">分配教练</a></li> -->
                              </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    
</div>
<!-- Modal -->
<div class="modal fade" id="myModal"  tabindex="-1"  >
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
        

    </div>
  </div>
</div>
<?php 
$this->registerJsFile('@jsPath/lecturer-contact.js');
$this->registerJs('
   $(function(){
        $(".assignment_event").click(function(){
            assignment();
        })
        $(".contact_event").click(function(){
            lecturerContact($(this).attr("lid"));
        })

   })
    
    // 分配教练
    function assignment() {
        var lids = "";
        $(".msup-lecturer-index input[type=\'checkbox\']").each(function(){
   
           if ($(this).prop("checked") && typeof($(this).val()) != \'undefined\') lids += $(this).val()+",";
        })
        $(".modal").removeData();
        if (!lids) {
            alert("请选择教练");
            return false;
        }
        $(".modal").modal({
            remote:"'.Yii::$app->urlManager->createAbsoluteUrl('lecturer/assignment').'?iframe=1&lids="+lids
        });

    }
    ');
?>