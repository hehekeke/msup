<?php
use yii\web\View;
use backend\assets\EditAsset;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->title = '任务';
EditAsset::register($this);
?>

<!-- 内容开始 -->



            <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">任务修改</h1>
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
    'options' => ['name'=>'appedit','role'=>'form','do_action'=>Yii::$app->urlManager->createAbsoluteUrl(['task/editdo'])],
]);
 ?>
                                    <div class="form-group">
                                            <label>任务ID</label>
                                            <input class="form-control" name="taskid" value="<?php echo $info['taskid'] > 0 ? $info['taskid'] : 0;?>" disabled="disabled">
                                        </div>
                                        <div class="form-group">
                                            <label>任务名称</label>
                                            <input class="form-control" name="taskname" value="<?php echo $info['taskname'];?>">
                                        </div>
                                        
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

      <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/taskEdit.js',['depends'=>EditAsset::className()]);?>

    <script type="text/javascript">
        var relaionurl = '';
    </script>
    


<!-- 内容结束 -->