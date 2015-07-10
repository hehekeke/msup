<?php
use yii\web\View;
use backend\assets\EditAsset;
use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '任务';
EditAsset::register($this);
?>

<!-- 内容开始 -->



            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">任务记录修改</h1>
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-6">
                                    <?php $form = ActiveForm::begin([
    'id' => 'appedit',
    'options' => ['name'=>'appedit','role'=>'form','do_action'=>Yii::$app->urlManager->createAbsoluteUrl(['taskrecord/editdo',['taskid'=>$info['taskid']]])],
]);
 ?>
                                    <div class="form-group">
                                            <label>任务记录ID</label>
                                            <input class="form-control" name="recordid" value="<?php echo $info['recordid'] > 0 ? $info['recordid'] : 0;?>" disabled="disabled">
                                        </div>
                                        <div class="form-group">
                                            <label>关联的任务名称</label>
                                            <input class="form-control" disabled="disabled" name="taskname" value="<?php echo $info['task']['taskname'];?>">
                                        </div>
                                        <div class="form-group">
                                            <label>关联的教练id</label>
                                            <input class="form-control" id="relationapp" name="lecturer_id" value="<?php echo $info['lecturer_id'];?>">
                                        </div>
                                        
                                        <input type="hidden" name="recordid" value="<?php echo $info['recordid'] > 0 ? $info['recordid'] : 0;?>"/>
                                        <input type="hidden" name="taskid" value="<?php echo $info['taskid'] > 0 ? $info['taskid'] : 0;?>"/>
                                        <button type="submit" class="btn btn-info">提交</button>
                                        
                                    <?php ActiveForm::end();?>
                                    
                                </div>
                                <!-- /.col-lg-6 (nested) -->
                                
                                <!-- /.col-lg-6 (nested) -->
                            </div>
                            <!-- /.row (nested) -->
                        </div>
                        <!-- /.panel-body -->
                    </div>
                    <!-- /.panel -->
                </div>
                <!-- /.col-lg-12 -->
            </div>
            <!-- /.row -->

      <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/taskrecordEdit.js',['depends'=>EditAsset::className()]);?>

    <script type="text/javascript">
        var relaionurl = '<?php echo Yii::$app->urlManager->createAbsoluteUrl(['taskrecord/relationteacher','lecturer_id'=>$info['lecturer_id']]);?>';
    </script>
    


<!-- 内容结束 -->