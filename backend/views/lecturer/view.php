<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\MsupDirectory;
use backend\widget\TimelySearch;
use backend\widget\UploadFile;
use backend\widget\Ueditor;
use backend\widget\Attachment;
use backend\widget\TagView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupDirectory */
/* @var $form yii\widgets\ActiveForm */
$this->title = "教练：".$model->name;
?>
<style type="text/css">
    .msupdirectory-phone .col-xs-12.table{margin-top: 0;}
    .form-block{border-radius: 3px;border: solid 1px #ddd;}
    .form-block .form-title{background: #f9f9f9;padding: 1em;width: 100%;margin-bottom: 0;}
    label.panel-heading{margin-bottom: 15px}
    ul li{list-style-type: none}
    ul.tags li{border:solid 1px #ddd;padding: 8px;}
    ul.tags li.bg1{background: #f9f9f9}
    .rightborder{border-right: solid 1px #ddd;}
    .baseInfo div.row.nm{border-bottom:solid 1px #ddd;padding:15px 0;}
</style>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header col-xs-6 npl"><?= Html::encode($this->title)?>
        </h1>
        <h4 class="page-header col-xs-6" style="margin-top: 45px;">
                    
                    <?php if ($model->assignment->user->username):?>
                    <div class="col-xs-5 np" style="margin-top:15px;">
                    维护人：<?= $model->assignment->user->username?></div>
                    <?php endif;?>
                    <div class="col-xs-4 np" style="margin-top:15px;">完整度：
                    <?php $integrity = new backend\components\Integrity;
                             echo "<em style='color:#d9534e;font-size:'>".$integrity->toHtml($integrity->getIntegrityByObj($model))."</em>";
                    ?></div>
                    <?php if ($assignment['user_id'] == Yii::$app->user->identity->id):?>
                    <div class="col-xs-3 np">
                        <a class="btn btn-primary glyphicon glyphicon-link contact_event" href="javascript:void(0)" lid="<?= $model->id?>" title="与他联系"></a>
                         <a class="btn btn-info glyphicon glyphicon-edit" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['lecturer/update', 'id' => $model->id])?>" lid="<?= $model->id?>" title="更新信息"></a>
                    </div>
                
            <?php endif;?>
        </h4>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="msup-lecturer-form">
            <div class="row">
            <!-- 基本信息Begin -->
                <div class="col-lg-6 col-xs-12 form-left">

                    <div class="panel panel-default">

                        <h5 class="nm panel-heading">教练基本信息</h5>
                        <div class="panel-body no-footer baseInfo">
                            <div class="row col-xs-12">
                                <div class="row nm">
                                    <div class="col-xs-3 npr text-right"><b>标题</b>&nbsp;&nbsp;&nbsp;</div>
                                    <div class="col-xs-9 npl"><b>内容</b></div>
                                </div>
                            <?php 
                                $baseAttributes = [
                                    'name','penName','qq','wecat','referee','idNumber','company','position','leadSource',
                                ];
                                foreach($baseAttributes as $key => $v) {
                                    if ($model->hasAttribute($v)) {


                                        echo '<div class="row nm">
                                                <div class="col-xs-3 np text-right">
                                                '.$model->attributeLabels()[$v].'：
                                                </div>
                                                <div class="col-xs-9 npl">
                                                    '.$model->$v.'
                                                </div>
                                                </div>';
                                    }
                                }
                            ?>  
                                <div class="row nm">
                                    <div class="col-xs-3 np text-right">
                                        教练状态：
                                    </div>
                                    <div class="col-xs-9 npl">
                                        <?= $model->statusLabel($model->status)?>
                                    </div>
                                </div>
                                <div class="row nm">
                                    <div class="form-group">
                                        <label for="" class="form-label">
                                            教练<?= $model->attributeLabels()['description']?>
                                        </label>
                                        <blockquote>
                                            <?= $model->description;?>
                                        </blockquote>
                                    </div>
                                </div>
                                <div class="row nm">
                                    <ul class="form-group tags npl">
                                        <label for="" class="form-label">
                                            教练标签
                                        </label>
                                    <?= TagView::widget([ 
                                                'model' => $model->modelId,
                                                'pkId'  => $model->primaryKey,
                                             ]);?>
                                    </ul>
                                </div>
                        </div>
                        </div>
                    </div>
                </div>
            <!-- 基本信息End -->
            <!-- 附件信息Begin -->
                <div class="col-lg-6 col-xs-12 form-right">
                    <!-- 头像Begin -->
                    <div class="panel panel-default">
                        <h5 class="panel-heading nm">教练头像<span class="required">*</span></h5>

                        <div class="panel-body">
                            <?php 
                                if ( is_array($model->thumbs) && !empty($model->thumbs) )  {
                                foreach( (array)$model->thumbs as $v) {
                            ?>
                            <div class="col-xs-4">
                                <img src="<?= $v['fileUrl']?>" width="100" alt="<?= $v['fileName']?>">
                            </div>
                            <?php
                                    }
                                }
                            ?>
                        </div>
                    </div> 
                    <!-- 头像end -->

                    <!-- 联系方式Begin -->
                    <div class="form-group required field-msupdirectory-phone row nm ">
                        <div class="grid panel panel-default">
                            <label class="control-label panel-heading col-xs-12" for="msupdirectory-phone">教练电话</label>
                                <div class="supdirectory-phone  text-center panel-body">
                                

                                    <table class="table text-left table-striped table-bordered dataTable no-footer">
                                        <thead>
                                            <tr>
                                                <th class="text-left">
                                                    电话
                                                </th>
                                                <th class="text-left">
                                                    常用号码
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php   

                                            if ( !empty( $directory ) ) {
                                                foreach ($directory as $key => $value) {

                                            ?>
                                            <tr>
                                                <td>
                                                    <p class="col-xs-12 text-center"><?= $value->phone?></p>
                                                </td> 
                                                <td>
                                                    <?php if($value->status == 1) {?>
                                                    <button type="button" class="btn btn-info btn-circle"><i class="fa fa-check"></i>
                                                    </button>
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                            <?php
                                                    }
                                                }

                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            
                        </div>
                    </div>
                    <!-- 联系方式End -->

                    <!-- 邮箱Begin -->
                    <div class="form-group required field-msupdirectory-email row nm ">
                        <div class="grid panel panel-default">
                            <label class="control-label panel-heading col-xs-12" for="msupdirectory-email">教练邮箱</label>
                                <div class="supdirectory-phone  text-center panel-body">
                                

                                    <table class="table text-left table-striped table-bordered dataTable no-footer">
                                    <?= Html::hiddenInput('MsupLecturer[email]', $model->email, [ 'class' => 'hiddenInput'])?>
                                        <thead>
                                            <tr>
                                                <th class="text-left">
                                                    邮箱
                                                </th>
                                                <th class="text-left">
                                                    常用邮箱
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php   

                                            if ( !empty( $email ) ) {
                                                foreach ($email as $key => $value) {

                                            ?>
                                            <tr>
                                                <td>
                                                    <p class="col-xs-12 text-center"><?= $value->email?></p> 
                                                </td> 
                                                <td>
                                                    <?php if ($value->status == 1){ ?> 
                                                        <button class="btn btn-info btn-circle">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    <?php } ?>
                                                </td>

                                            </tr>
                                            <?php
                                                    }
                                                }

                                            ?>

                                        </tbody>
                                    </table>

                                </div>
                            
                        </div>
                    </div>
                    <!-- 邮箱End -->  

                </div>
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">教练扩展信息</div>
                        <div class="panel-body">
                            <!-- 出版物Begin -->
                            <div class="form-group required field-msuppublication-publication col-xs-12">
                                <div class="grid panel panel-default">
                                    <label class="control-label panel-heading col-xs-12" for="msupdirectory-email">教练出版物</label>
                                        <div class="supdirectory-phone  text-center panel-body">
                                            <table class="table text-left table-striped table-bordered dataTable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th class="text-center">
                                                            出版物名称
                                                        </th>
                                                        <th class="text-center">
                                                            出版时间
                                                        </th>
                                                        <th>
                                                            商品网址
                                                        </th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php   

                                                    if ( !empty( $publication ) ) {
                                                        foreach ($publication as $key => $value) {

                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <?= $value->name;?>
                                                        </td> 
                                                        <td>
                                                            <?= $value->time?>
                                                        </td>
                                                        <td>
                                                            <?= $value->url?>
                                                        </td>

                                                    </tr>
                                                    <?php
                                                            }
                                                        }

                                                    ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    
                                </div>
                            </div>
                            <!-- 出版物End -->

                            <!-- 通讯地址Begin -->
                            <div class="form-group required field-msupaddress-address col-xs-12 msupaddress-address">
                                <div class="grid panel panel-default">
                                    <label class="control-label panel-heading col-xs-12" for="msupaddress-address">地址</label>
                                    <div class="row msupaddress-address nm panel-body">
                                        <table class="table col-xs-12  table-striped table-bordered dataTable no-footer">
                                            <tr>
                                                <th class="text-center">
                                                    详细地址
                                                </th>
                                                <th class="text-center">
                                                    默认使用
                                                </th>
                                                <?php if ( !empty( $address ) ){?>

                                            </tr>
                                            <?php 

                                                    foreach ($address as $key => $value) {
                                            ?>
                                            <tr class="text-center">
                                                <td>
                                                    <?= $value->address ?>
                                                    <?php if ($value->detail) echo ','.$value->detail;?>
                                                </td> 
                                                <td>
                                                    <?php if ($value->status == 1 ) { ?> 
                                                        <button class="btn btn-info btn-circle">
                                                            <i class="fa fa-check"></i>
                                                        </button>
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }

                                            ?>
                                        </table>
                                    </div>
                                    
                                </div>
                            </div>  
                            <!-- 通讯地址End -->
                        </div>
                    </div> 
                </div>

                <!-- 详细描述Begin -->
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= $model->attributeLabels()['content']?>
                        </div>
                        <div class="panel-body">
                            <?= $model->content;?>        
                        </div>
                    </div>
                </div>
                <!-- 详细描述End -->
                <!-- 备注信息Begin -->
                <div class="col-xs-12 nm">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <?= $model->attributeLabels()['remarks']?>
                        </div>
                        <div class="panel-body">
                            <?= $model->remarks;?>        
                        </div>
                    </div>
                </div>
                <!-- 详细内容end -->
            </div>

        </div>
        <hr>
    </div>

</div>
<?php 
$this->registerJsFile('@jsPath/lecturer-contact.js');

$this->registerJs('
            $(".contact_event").click(function(){
                lecturerContact($(this).attr("lid"));
            })
    ');
?>
