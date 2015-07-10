<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use backend\models\MsupDirectory;
use backend\widget\TimelySearch;
use backend\widget\UploadFile;
use backend\widget\Ueditor;
use backend\widget\Attachment;
use backend\widget\Tag;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupDirectory */
/* @var $form yii\widgets\ActiveForm */

?>
<?php $id = $model->isNewRecord ? Yii::$app->security->generateRandomString(8) : $model->id; ?>

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= Html::encode($this->title)?>
        <small>带<span class="required">*</span>的为必填项</small></h1>
    </div>
</div>
<div class="row">
    <div class="col-xs-12">
        <div class="msup-lecturer-form">
            <div class="row">
            <?php $form = ActiveForm::begin([ "id" => "form", "class"=> "row nm" ]); ?>
                <div class="col-lg-6 col-xs-12 form-left">

                    <div class="panel panel-default">

                        <h5 class="nm panel-heading">教练基本信息</h5>
                        <div class="panel-body no-footer">
                            <?= $form->field($model, 'name')->textInput(['maxlength' => 30, 'placeholder'=>'请填写教练真实姓名 如：张三']) ?>

                            <?= $form->field($model, 'penName')->textInput(['maxlength' => 100,'placeholder'=>'请填写教练笔名 如：金庸']) ?>

                            <?= $form->field($model, 'idNumber')->textInput([ 'placeholder'=>' 请填写教练身份证号，将用于生日提醒'])?>
                    
                            <?= $form->field($model, 'company')->textInput(['maxlength' => 100, 'placeholder'=>'请填写教练当前任职公司']) ?>
                            <?= $form->field($model, 'office')->textInput(['maxlength' => 100, 'placeholder'=>'请填写教练当前任职部门']) ?>
                            <?= $form->field($model, 'position')->textInput(['maxlength' => 100, 'placeholder'=>'请填写教练当前职位']) ?>
                            <?= $form->field($model, 'qq')->textInput(['maxlength' => 20, 'placeholder'=>'请填写教练QQ']) ?>

                            <?= $form->field($model, 'wecat')->textInput(['maxlength' => 30 ,'placeholder'=>'请填写教练微信']) ?>
                            <!-- 推荐人不可更改 -->

                            <?php 
                                if ($model->referee) { 
                                    echo $form->field($model, 'referee')->textInput(['maxlength' => 100, 'placeholder'=>'请填写教练推荐人', 'disabled' => 'disabled']);
                                } else {
                                   echo $form->field($model, 'referee')->textInput(['maxlength' => 100, 'placeholder'=>'请填写教练推荐人']); 
                                }
                            ?>
                            <?= $form->field($model, 'description')->textarea(['maxlength' => 1000, 'placeholder'=>'李明先生，目前居于中国北京市。2007年1月起至今，李先生在甲公司担任项目经理，该公司主营业务为IT解决方案。李先生主要负责项目开发等事宜。之前，李先生曾在乙公司担任技术经理。李先生自1999年期从事企业信息化工作，拥有丰富的行业经验。', 'style' => 'height:100px;']) ?>
                            <?= $form->field($model, 'status')->dropDownList($model->statusLabel) ?>
                            <?= $form->field($model, 'content')->textarea(['max-length' => '100', 'scroll-y' => 'false', 'style' => 'height:120px;', ])?>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-xs-12 form-right">
                    <!-- 头像Begin -->
                    <div class="panel panel-default">
                        <h5 class="panel-heading nm">教练头像（用于网站展示，分辨率 300*300）<span class="required">*</span></h5>

                        <div class="panel-body">
                            <?= Attachment::widget( [ 
                                                'url'=>'attachment/upload',
                                                'model' => $model,
                                                'field' => 'MsupLecturer[thumbs]',
                                                'number' => 1,
                                            ] ) ;
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
                                    <?= Html::hiddenInput('MsupLecturer[phone]', $model->phone, [ 'class' => 'hiddenInput'])?>
                                        <thead>
                                            <tr>
                                                <th class="text-left">
                                                    电话
                                                </th>
                                                <th class="text-left">
                                                    常用号码
                                                </th>
                                                <th>
                                                   删除 
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
                                                    <input type="text" value="<?= $value->phone;?>"id="msupdirectory-phone" class="col-xs-8 form-control" name="update[MsupDirectory][<?= $value->id?>][phone]" >  
                                                </td> 
                                                <td>
                                                    <input type="radio" id="msupdirectory-status" class="col-xs-1 np" name="update[MsupDirectory][<?= $value->id?>][status]" <?php if($value->status == 1) echo "checked='checked'"?> value="1">
                                                </td>
                                                <td>
                                                    <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }

                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" id="msupdirectory-phone" class="col-xs-8 form-control" name="MsupDirectory[phone]" placeholder='请填写教练电话'  >  
                                                </td> 
                                                <td>
                                                    <input type="radio" id="msupdirectory-status" class="col-xs-1 np" name="MsupDirectory[status]"value="<?= $value->status?>">
                                                </td>
                                                <td>
                                                    <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                </td>

                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center col-xs-12 np">
                                        <a class="more more_phone btn btn-success col-xs-12">新增一条</a>
                                    </div>
                                    <div class="help-block"></div>

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
                                                <th>
                                                   删除 
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
                                                    <input type="text" value="<?= $value->email;?>"id="msupdirectory-email" class="col-xs-8 form-control" name="update[MsupEmail][<?= $value->id?>][email]" >  
                                                </td> 
                                                <td>
                                                    <input type="radio" id="msupdirectory-status" class="col-xs-1 np" name="update[MsupEmail][<?= $value->id?>][status]" <?php if($value->status == 1) echo "checked='checked'"?> value="1" />
                                                </td>
                                                <td>
                                                    <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }

                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" id="msupdirectory-phone" class="col-xs-8 form-control" name="MsupEmail[email]" placeholder='请填写教练邮箱'  >  
                                                </td> 
                                                <td>
                                                    <input type="radio" id="msupdirectory-status" class="col-xs-1 np" name="MsupEmail[status]" value="1">
                                                </td>
                                                <td>
                                                    <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="text-center col-xs-12 np">
                                        <a class="more more_email btn btn-success col-xs-12">新增一条</a>
                                    </div>
                                    <div class="help-block"></div>

                                </div>
                            
                        </div>
                    </div>
                    <!-- 邮箱End -->  

                </div>
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">教练标签</div>
                            <div class="panel-body">
                                <?= Tag::widget([ 
                                    'model' => $model->modelId,
                                    'pkId'  => $model->primaryKey,
                                    'cate'  => '2,4',

                                 ]);?>
                            </div> 
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">教练扩展信息</div>
                        <div class="panel-body">
                            <!-- 出版物Begin -->
                            <div class="form-group field-msuppublication-publication col-xs-12">
                                <div class="grid panel panel-default">
                                    <label class="control-label panel-heading col-xs-12" for="msupdirectory-email">教练出版物</label>
                                        <div class="supdirectory-phone  text-center panel-body">
                                            <table class="table text-left table-striped table-bordered dataTable no-footer">
                                                <thead>
                                                    <tr>
                                                        <th class="text-left">
                                                            出版物名称
                                                        </th>
                                                        <th class="text-left">
                                                            出版时间
                                                        </th>
                                                        <th>
                                                            商品网址
                                                        </th>

                                                        <th>
                                                           删除 
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
                                                            <input type="text" value="<?= $value->name;?>" id="msupublication-name" class="col-xs-8 form-control" name="update[MsupPublication][<?= $value->id?>][name]"  >  
                                                        </td> 
                                                        <td>
                                                            <input type="text" id="msupdirectory-status" class="form-control" name="update[MsupPublication][<?= $value->id?>][time]" value="<?= $value->time; ?>">
                                                        </td>
                                                        <td>
                                                            <input type="text" id="msupdirectory-status" class="form-control" name="update[MsupPublication][<?= $value->id ?>][url]" value="<?= $value->url?>">
                                                        </td>
                                                        <td>
                                                            <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                        </td>
                                                    </tr>
                                                    <?php
                                                            }
                                                        }

                                                    ?>
                                                    <tr>
                                                        <td>
                                                            <input type="text" id="msuppublication-name" class="col-xs-6 form-control" name="MsupPublication[name]" placeholder='请填写出版物名称' >  
                                                        </td> 
                                                        <td>
                                                            <input type="text" id="msuppublication-time" class="colxs-6 form-control" name="MsupPublication[time]">
                                                        </td>
                                                        <td>
                                                           <input type="text" id="msuppubliction-url" class="colxs-6 form-control" name="MsupPublication[url]">
                                                        </td>
                                                        <td>
                                                            <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <div class="text-center col-xs-12 np">
                                                <a class="more more_publication btn btn-success col-xs-12">新增一条</a>
                                            </div>
                                            <div class="help-block"></div>

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
                                                <th class="text-left">
                                                    详细地址
                                                </th>
                                                <th class="text-left">
                                                    默认使用
                                                </th>
                                                <th>
                                                    删除 
                                                </th>
                                    
                                                <?php if ( !empty( $address ) ){?>

                                            </tr>
                                            <?php 

                                                    foreach ($address as $key => $value) {

                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text"  id="msupaddress-address" class="col-xs-8 form-control addreee-update" name="update[MsupAddress][<?= $value->id?>][address]" select-address p="pu<?=$key?>" c="cu<?=$key?>" a="au<?=$key?>" d="du<?=$key?>" ng-model="xxxu<?=$key?>"    placeholder="<?= $value->address?><?php if ($value->detail){?>,<?php } ?><?= $value->detail ?>" value="<?= $value->address?><?php if ($value->detail)?>,<?php?><?= $value->detail ?>">  
                                                </td> 
                                                <td>
                                                    <input type="radio" id="msupaddress-status" class="col-xs-1 np"value="1" name="update[MsupAddress][<?= $value->id?>][status]" <?php if($value->status == 1) echo "checked='checked'"?>>
                                                </td>
                                                <td>
                                                        <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                </td>
                                            </tr>
                                            <?php
                                                    }
                                                }

                                            ?>
                                            <tr>
                                                <td>
                                                    <input type="text" id="msupaddress-address" class="col-xs-8 form-control" name="MsupAddress[address]" select-address p="p" c="c" a="a" d="d" ng-model="xxx" placeholder="请选择所在地"  >  
                                                </td> 
                                                <td>
                                                    <input type="radio" id="msupaddress-status" class="col-xs-1 np"value="1"name="MsupAddress[status]">
                                                </td>
                                                <td>
                                                    <a  class="btn btn-danger deleteRelation showDelete" href="javascript:void(0)">删除</a>
                                                </td>
                                            </tr>
                                            <?php for ($i = 1;$i<5;$i++) {?>
                                            <tr class="hideInput">
                                                <td>
                                                    <input type="text" id="msupaddress-address" class="col-xs-8 form-control" name="new[MsupAddress][<?= $i; ?>][address]" select-address p="p<?= $i;?>" c="c<?= $i;?>" a="a<?= $i;?>" d="d<?= $i;?>" ng-model="xxx<?= $i;?>" placeholder="请选择所在地" >  
                                                </td> 
                                                <td>
                                                    <input type="radio"value="1" id="msupaddress-status" class="col-xs-1 np" name="new[MsupAddress][<?= $i; ?>][status]">
                                                </td>
                                                <td>
                                                    <a  class="btn btn-danger deleteRelation" href="javascript:void(0)">删除</a>
                                                </td>
                                            </tr>
                                            <?php }?>
                                        </table>
                                        <div class="text-center col-xs-12 np">

                                            <a class="more btn col-xs-12 text-right btn-success">新增一条</a>

                                        </div>
                                        <div class="help-block"></div> 
                                    </div>
                                    
                                </div>
                            </div>  
                            <!-- 通讯地址End -->
                        </div>
                    </div> 
                </div>
                <!-- 备注信息Begin -->
                <div class="col-xs-12 nm">   
                    <label for="msuplecturer[remarks]" class="form-label">备注信息</label>
                    <?= Ueditor::widget(['fieldName'=> 'MsupLecturer[remarks]','id'=>'Ueditor', 'content'=>$model->remarks])?>
                </div>
                <!-- 详细内容end -->
            </div>

        </div>
        <hr>
        <div class="form-group col-xs-12">
            <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => 'btn btn-lg btn-success col-lg-3']) ?>
        </div>
    </div>

</div>
    <?php ActiveForm::end(); ?>

<?php 
$this->registerJs('
    select_path = "'.@web.'/Public/plugin/select_address";
    $(function(){
        var cloneParent,cloneInput,cloneIndex,nowInputName;
        $(".hideInput").hide();
        $(".more").click(function() {
            cloneParent = $(this).parent().prev("table").find("tbody");
            cloneInput = cloneParent.find("tr:last").clone();
            cloneIndex = cloneParent.find("tr").length;

        })
        // 新增一条联系记录
        $(".more_phone").click(function(){
            var nowInputName = "new[MsupDirectory]["+(cloneIndex-1)+"]";
            cloneInput.find("input[type=text]").attr("name", nowInputName+"[phone]").val("");
            cloneInput.find("input[type=radio]").attr("name", nowInputName+"[status]").prop("checked", false);
            cloneInput.appendTo(cloneParent);
        })

        // 新增一条Email输入
        $(".more_email").click(function(){
            var nowInputName = "new[MsupEmail]["+(cloneIndex-1)+"]";

            cloneInput.find("input[type=text]").attr("name", nowInputName+"[email]").val("");
            cloneInput.find("input[type=radio]").attr("name", nowInputName+"[status]").prop("checked", false);
            cloneInput.appendTo(cloneParent);
        })

        // 新增一条地址输入
        var ind;
        $(".field-msupaddress-address .more").click(function(){
            if(!ind) {
                ind = 1;
            }
            $(".field-msupaddress-address .hideInput").eq(ind).show();
            ind++;
        })
       
       //新增一条出版物输入
        $(".more_publication").click(function(){
            var nowInputName = "new[MsupPublication]["+(cloneIndex-1)+"]";
            cloneInput.find("input[name=\'MsupPublication[name]\']").attr("name", nowInputName+"[name]").val("");
            cloneInput.find("input[name=\'MsupPublication[time]\']").attr("name", nowInputName+"[time]").val("");
            cloneInput.find("input[name=\'MsupPublication[url]\']").attr("name", nowInputName+"[url]").val("");

            cloneInput.appendTo(cloneParent);

        })
       //单选按钮点击事件
        $("table").on("click","input[type=radio]",function(){

            var that = $(this).parent().parent().index();
            var val  = $(this).parent().prev("td").find("input").val() 
            if ( val == undefined) {
                alert("该条记录必须填写");
                $(this).prop("checked", false);
                return false;
            } else {
                $(this).parents("table").find(".hiddenInput").val(val);
            }
            $(this).parent().parent().parent().find("input[type=\'radio\']").each(function(){
                if ($(this).parent().parent().index() !== that) {
                    $(this).prop("checked", false);
                }

            })
        })

        //删除多项内容中的一行
        $(".form-group table").on("click", ".showDelete", function(){
            var gp = $(this).parent().parent();
            if (gp.parent().find(".showDelete").length <= 1) {
               return false;  
            }  else {
                
                gp.find("input").attr("value", "");
                gp.find("input").attr("placeholder", "");
                gp.hide();
            }


        })
        $("form").submit(function(){
            $(".addreee-update").each(function(){
                if ($(this).val() == "") {
                    $(this).val($(this).attr("placeholder"))
                }
            })
        })

    })'
);
?>

<!-- 即时搜索 -->
<?= TimelySearch::widget([
            'searchUrl'=>'lecturer/search-by-name',
            'input'=>'#msuplecturer-name',
            'message'=>'我们已搜到以下相关教练:',
            'key' => 'name'
            ]
        );
?>

<?php 
    $this->registerJsFile('@web/Public/plugin/select_address/js/plugins/angular/angular.min.js');
    $this->registerJsFile('@web/Public/plugin/select_address/js/selectAddress2.js');
    $this->registerJsFile('@web/Public/plugin/select_address/js/index.js');
    $this->registerJsFile('@web/Public/Admin/js/lecturer.js');
?>

