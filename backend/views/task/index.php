<?php
/* @var $this yii\web\View */
use yii\widgets\LinkPager;
$this->title = '任务管理';
use yii\helpers\Html;
?>


<!-- 内容开始 -->
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= Html::encode($this->title)?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">话题列表</div>
                    <div class="panel-body">
                        <div class="table-responsive">
                            <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid"><div class="row"><div class="col-sm-6"><div id="dataTables-example_filter" class="dataTables_filter">
                            <form action="<?php echo Yii::$app->urlManager->createAbsoluteUrl('task/index');?>" method="get">
                            <label>搜索:<input type="search" name="search" class="form-control input-sm" aria-controls="dataTables-example">&nbsp;&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-info">提交</button></label></form>
                            </div></div></div><table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
                                <thead>
                                    <tr role="row">
                                        <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 100px;">id</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 222px;">话题标题</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending" style="width: 98px;">添加的用户id</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Engine version: activate to sort column ascending" style="width: 108px;">添加时间</th>
                                        <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="CSS grade: activate to sort column ascending" style="width: 266px;">操作</th>
                                    </tr>
                                </thead>
                                <tbody>
                                
                                <?php $i = 0;?>
                                <?php foreach($list as $k=>$v):?>
                                <tr class="gradeA <?php if($i%2 == 0){echo 'odd';}else{echo 'even';}$i++;?>">
                                        <td class="sorting_1"><?php echo $v['taskid'];?></td>
                                        <td class=" "><?php echo $v['taskname'];?></td>
                                        <td class=" "><?php echo $v['userid'];?></td>
                                        <td class="center "><?php echo date('Y-m-d H:i:s',$v['time']);?></td>
                                        <td class="center ">
                                            <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['task/print','taskid'=>$v['taskid']]);?>" class="btn btn-info">打印</a>
                                            <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['taskrecord/index','taskid'=>$v['taskid']]);?>" class="btn btn-info">任务详情</a>
                                            <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['task/edit','taskid'=>$v['taskid']]);?>" class="btn btn-info">修改</a>
                                            <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl(['task/del','taskid'=>$v['taskid']]);?>" class="btn btn-info">删除</a>
                                        </td>
                                    </tr>
                                <?php endforeach;?>
                                
                                    
                                </tbody>
                            </table><div class="row"><div class="col-sm-6"><div class="dataTables_info" id="dataTables-example_info" role="alert" aria-live="polite" aria-relevant="all"></div></div><div class="col-sm-6 text-right"><div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate"><?= LinkPager::widget(['pagination' => $pages]); ?></div></div></div></div>
                        </div>
                        <!-- /.table-responsive -->
                    </div>
                        <!-- /.panel-body -->
                </div>
                    <!-- /.panel -->
             </div>
                <!-- /.col-lg-12 -->
        </div>
            <!-- /.row -->
        
        <!-- 内容结束 -->