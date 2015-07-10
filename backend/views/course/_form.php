<?php

use yii\helpers\Html;
use backend\widget\ActiveForm;
use backend\widget\Tag;
use backend\widget\Attachment;
/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourse */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header"><?= $title ?></h1>
    </div>
</div>
<?php $form = ActiveForm::begin(); ?>  
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">课程基本信息</div>
            <div class="panel-body">

                <div class="floatl col-xs-6">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => 255, 'placeholder' => '请填写课程的名称']) ?>
                    <?= $form->field($model, 'courseNumber')->textInput(['maxlength' => 255, 'placeholder' => '请填写课程的编号']) ?>

                    <?= $form->field($model, 'level')->dropDownList($model->levelLabel)?>
                    <?= $form->field($model, 'type')->dropDownList($model->typeLabel)?>

                    <!-- <?= $form->field($model, 'sponsor')->textInput(['maxlength' => 255]) ?> -->

                    <?= $form->field($model, 'lecturer_id')->textInput(['id'=>'relationapp', 'readonly' => 'readonly', 'placeholder' => '点击关联教练']) ?>
                    <?= Html::hiddenInput("MsupCourse[lecturer_id]", $model->lecturer_id);?>

                    <?= $form->field($model, 'price')->textInput(['maxlength' => 11, 'placeholder' => '请填写该课程的价格（单位：RMB）']) ?>
                    <div class="form-group">
                        <label class="form-label">价格信息</label>
                        <table class="table table-bordered table-striped" id="priceDesc">
                            <thead>
                                <tr>
                                    <th>价格</th>
                                    <th>描述</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php if(!empty($model->priceDesc) && is_array($model->priceDesc)) {
                            foreach($model->priceDesc as $k  => $v) {
                        ?>
                       <tr>
                            <td>
                                <input class="form-control"type="text" value="<?= $v[price]?>"id="">
                            </td>
                            <td>
                                <input class="form-control" type="text" value="<?= $v[desc]?>" id="">
                            </td>
                            <td><button type="button"  class="coursedelete btn btn-danger btn-sm">删除</button></td>
                        </tr>
                        <?php  }  } ?>
                        <tr>
                            <td>
                                <input class="form-control"type="text"  id="">
                            </td>
                            <td>
                                <input class="form-control"type="text" id="">
                            </td>
                            <td><button type="button"  class="coursedelete btn btn-danger btn-sm">删除</button></td>
                        </tr>
                            </tbody>
                        </table>
                        <input type="hidden" name="MsupCourse[priceDesc]" class="priceDesc-input" />
                        <a href="javascript:void(0)" id="priceDescAdd"class="btn btn-success">添加一条价格信息</a>
                    </div>
                    <?= $form->field($model, 'num')->textInput(['placeholder' => '请填写该课程预计参与的人数']) ?>
                    <?= $form->field($model, 'usedtimeid')->dropDownList($courseusedtime)?>
                    <?= $form->field($model, 'desc')->textarea(['placeholder' => '请填写课程简介', 'maxlength' => 255])?>

                
                </div>
    
                <div class="floatr col-xs-6">
                    <!-- 课程附件Begin -->
                    <div class="panel panel-default">
                        <h5 class="panel-heading nm control-label">
                            <label class="control-label">
                                <?= $model->attributeLabels()[file]?>
                            </label>
                        </h5>

                        <div class="panel-body">
                            <?= Attachment::widget( [ 
                                                'url'=>'attachment/upload',
                                                'model' => $model,
                                                'field' => 'MsupCourse[file]',
                                                'number' => 1,
                                            ] ) ;
                            ?>
                        </div>
                    </div> 
                    <!-- 课程附件end -->
                
                </div>
                <div class="floatr col-xs-6 ">
                    <!-- 课程图片Begin -->
                    <div class="panel panel-default form-group required">
                        <h5 class="panel-heading nm">
                             <label class="control-label">
                                <?= $model->attributeLabels()[thumbs]?>
                            </label>
                        </h5>
                        <div class="panel-body">
                            <?= Attachment::widget( [ 
                                                'url'=>'attachment/upload',
                                                'model' => $model,
                                                'field' => 'MsupCourse[thumbs]',
                                                'number' => 1,
                                            ] ) ;
                            ?>
                        </div>
                    </div> 
                    <!-- 课程图片end -->
                </div>
                <div class="floatr col-xs-6">
                     <!-- 演讲稿 Begin-->
                    <div class="panel panel-default">
                        <h5 class="panel-heading nm"><?= $model->attributeLabels()[speech]?></h5>

                        <div class="panel-body">
                            <?= Attachment::widget( [ 
                                                'url'=>'attachment/upload',
                                                'model' => $model,
                                                'field' => 'MsupCourse[speech]',
                                                'number' => 1,
                                            ] ) ;
                            ?>
                        </div>
                    </div> 
                    <!-- 演讲稿End -->
                </div>
               
                
    
            </div>

        </div>
        <div class="panel panel-default">
            <div class="panel-heading"> 将课程发送到网站</div>
            <div class="panel-body">
                <div class="row nm" style="background: #f9f9f9;padding-top: 15px">
                <div class="col-xs-2">
                    <?= $form->field($model, 'assignToMpd')->checkBox() ?>
                </div>
                <div class="col-xs-2">
                    <?= $form->field($model, 'assignToTop100')->checkBox() ?>
                </div>
                <div class="col-xs-2">
                    <?= $form->field($model, 'assignToMsup')->checkBox() ?>
                </div>
                <div class="col-xs-2">
                    <?= $form->field($model, 'assignToOready')->checkBox() ?>
                </div>
                <div class="col-xs-2">
                    <?= $form->field($model, 'assignToSalon')->checkBox() ?>
                </div>
                <div class="col-xs-2">
                </div>
                </div>
            </div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">课程标签</div>
                <div class="panel-body">
                    <?= Tag::widget([ 
                        'model' => $model->modelId,
                        'pkId'  => $model->primaryKey,
                        'cate'  => '3,4',
                        'isRequire' => true,
                     ]);?>
                </div> 
        </div>
       
        <div class="panel panel-default">
            <div class="panel-heading">课程大纲</div>
            <div class="panel-body">
          
                <?= $form->field($model, 'character')->textarea(['rows' =>3]) ?>
                <?= $form->field($model, 'profit')->textarea(['rows' =>3]) ?>
                <?= $form->field($model, 'target')->textarea(['rows' =>3]) ?>
                <?= $form->field($model, 'trainees')->textarea(['rows' =>3]) ?>
                
                <div class="form-group field-msupcourse-usedtimeid">
                    <label class="control-label" for="msupcourse-usedtimeid">五、培训内容（即培训大纲，要求章节清晰、技术点明确，最好表明所需课时，请参阅范文）</label>
                    <table class="table table-bordered table-striped container nb" id="training">
                        <tr class="row">
                            <td class="">#</td>
                            <td class="col-xs-3">主题</td>
                            <td class="col-xs-6">授课内容</td>
                            <td >操作</td>
                        </tr>
                        <?php $num = 1; if(!empty($model->training) && is_array($model->training)) {
                            foreach($model->training as $k  => $v) {
                        ?>
                                <tr class="row">
                                <td><?= $k+1 ?></td>
                                <td class="col-xs-6">
                                    <textarea class="col-xs-12 form-control training-title" name="MsupCourse[training][title][] " value="<?= $v[title] ?>"><?= $v[title] ?></textarea>
                                </td>
                                <td class="col-xs-6">
                                    <textarea class="col-xs-12 form-control training-content" name="MsupCourse[training][content][]" value="<?= preg_replace('/<br\/>/','\n',$v[content]) ?>">
                                        <?= preg_replace('/<br\/>/','&#13;&#10;',$v[content]) ?>
                                    </textarea>
                                </td>
                                <td>
                                    <button type="button"  class="coursedelete btn btn-danger">删除</button>
                                </td>
                            </tr>
                        <?php $num = $k+2; }  } ?>
                        <tr class="row">
                            <td><?= $num ?></td>
                            <td class="col-xs-6">
                                <textarea class="col-xs-12 form-control training-title" name="MsupCourse[training][title][]"></textarea>
                            </td>
                            <td class="col-xs-6"><textarea class="col-xs-12 form-control training-content" name="MsupCourse[training][content][]"></textarea></td>
                            <td><button type="button"  class="coursedelete btn btn-danger">删除</button></td>
                        </tr>
                      </table>
                    <input type="hidden" name="MsupCourse[training]" class="training-input"/>
                    <div class="text-right"><button id="trainingadd" type="button" class="btn btn-success">添加一条培训内容</button></div>
                </div>
<!--                 
                <?= $form->field($model, 'teacher')->textarea(['rows' =>3]) ?>
                <?= $form->field($model, 'relation')->textarea(['rows' =>3]) ?> -->
                <?= $form->field($model, 'appointment')->dropDownList($model->appointments) ?>
                <?= $form->field($model, 'appointmentTime')->textarea() ?>
                <?= $form->field($model, 'other')->textarea();?>
                <?= $form->field($model, 'content')->textarea(['rows' => 8]);?>
            </div>
        </div>
        
<!--         <div class="panel panel-default">
            <div class="panel-heading">抢先试听</div>
            <div class="panel-body">

               <!-- <?= $form->field($model, 'file')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'media')->textarea(['rows' => 6]) ?>

                <?= $form->field($model, 'thumbs')->textarea(['rows' => 6]) ?> --> 
<!--                 <?= $form->field($model, 'auditionvideo')->textarea(['rows' => 3]) ?>
                <?= $form->field($model, 'auditiondesc')->textarea(['rows' => 3]) ?> -->
                
            <!-- </div> -->
        <!-- </div>  -->
        <div class="form-group">
            <?= Html::submitButton($model->isNewRecord ? '添加' : '更新', ['class' => $model->isNewRecord ? 'btn btn-lg btn-success submitForm' : 'btn btn-lg  btn-primary submitForm']) ?>
        </div>

        
    </div>
</div>
<?php ActiveForm::end(); ?>
<!-- 关联讲师 -->
<div class="modal fade" id="couse-relationapp"  tabindex="-1">
  <div class="modal-dialog modal-lg">
    <div class="modal-content" >
        <div class="modal-header row nml nmr">
            <div class="pull-left"><h5>关联讲师</h5></div>
            <div class="pull-right">
                <button type="button" data-dismiss="modal"class="btn btn-default couse-relationapp">取消</button>
                <button type="button" data-dismiss="modal" class="btn btn-primary sure-select-lecturer">确定选择</button>
            </div>
        </div>
        <div class="modal-body"></div>

    </div>
  </div>
</div>
<?php 
$this->registerJs('
    $("#couse-relationapp").on("click", ".pagination a", function(event){
       event.stopImmediatePropagation(); 
        var url = $(this).attr("href");
        $(this).attr("href", "javascript:void(0)")
        $("#couse-relationapp .modal-body *").remove();
        $("#couse-relationapp .modal-body").load(url);
        return false;
    })
    $(document).ready(function(){
        $("#relationapp").click(function(event){
            var $url = "'.Yii::$app->urlManager->createAbsoluteUrl(['taskrecord/relationteacher']).'";
            $("#couse-relationapp .modal-body").load($url);
            $("#couse-relationapp").modal("show");
        });

        var i ='.$num.';    
        //添加培训内容
        $("#trainingadd").click(function(){
            i++;
            $("#training").append(\'<tr class="row"><td>\'+i+\'</td><td class="col-xs-6"><textarea class="col-xs-12 training-title form-control" name="MsupCourse[training][title][]"></textarea></td><td class="col-xs-6"><textarea class="col-xs-12  training-content form-control" name="MsupCourse[training][content][]"></textarea></td><td><button type="button"  class="coursedelete btn btn-danger">删除</button></td></tr>\');
        });
        $("#priceDescAdd").click(function(){
            $("#priceDesc tbody").append("<tr><td><input class=\"form-control\" /></td><td><input class=\"form-control\" /></td><td><button type=\"button\"  class=\"coursedelete btn btn-danger\">删除</button></td></tr>");
        })
        $("#priceDesc").on("click", ".coursedelete", function(){
            if ($("#priceDesc").find(".coursedelete").length == 1) {
                return false;
            }
            $(this).parent().parent().remove();
        })
        //点击删除按钮
       $("#training").on("click", ".coursedelete",function(){
           if ($("#training").find(".coursedelete").length == 1) {
                return false;
            }
            $(this).parent().parent().remove();
            var j = 1;
            $("#training tr").each(function(){
                var txt = $(this).find("td").eq(0);
                if (txt.text() !== "#") {
                    txt.text(j);
                    j++;
                }
            })
            i = j-1;
        });
   
        $(".submitForm").click(function(event){
                
            var type =1 ;
            var i = 0; 
            // 检查关联教练
            if (!$("input[name=\'MsupCourse[lecturer_id]\']").val()) {
                alert("课程教练不能为空");
                return false;
            }
            var priceDescContent = {
                "priceDesc":[]
            }
            $("#priceDesc tbody tr").each(function(event) {
                    var that = $(this).find("input").eq(0);
                    if (!that.val()) {
                        type = 0;
                        return false;
                    }
    
                    var thisPriceDesc = {
                        "price": "",
                        "desc": ""
                    }
        
                    if ( type ) {
                        thisPriceDesc.price = that.val();
                        thisPriceDesc.desc = that.parent().next("td").find("input").val();
                        if (!thisPriceDesc.desc) {
                                alert("价格描述不能为空")
                                type = 0;
                                return false;
                        }
                        
                        if(type) {
                            type =1;
                            priceDescContent["priceDesc"][i] = thisPriceDesc;
                             i++; 
                        }
                    }
                return true;
            })

            $(".priceDesc-input").val( JSON.stringify(priceDescContent) );

            //保存培训内容信息
            var training = {
                "training" : []
            };

            var i = 0;
            var type = 1;
            var noValue  = 0;
            $(".training-title").each(function(event) {

                    // 有标题才添加内容，有内容才将数据加入到值中
                    if (!$(this).val()) {
                        type = 0;
                        return false;
                    }
    
                    var thisTraining = {
                        "title":"",
                        "content":""
                    };
        
                    if ( type ) {
                        thisTraining.title = $(this).val();
                        thisTraining.content = $(this).parent().next("td").find(".training-content").val();
                        if (!thisTraining.content ) {
                            alert("授课内容不能为空")
                            type = 0;
                            return false;
                        }

                        
                        if(type) {
                            type =1;
                            training["training"][i] = thisTraining
                             i++;
                        }
                       
                        if (type && !noValue){
                            noValue = 1;
                        }
                    }
                return true;
            })
            $(".training-input").val( JSON.stringify(training) );
            if (!noValue && !$("#msupcourse-content").val()) { 
                alert("培训内容不能为空");
                return false;
            }else{
                return true;
            }
           
        })

    });'

);
?>
