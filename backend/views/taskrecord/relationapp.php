<?php 
use backend\assets\EditAsset;
use yii\widgets\LinkPager;
?>

<div id="relationapp-page">
            <div class="row">
                <div class="col-lg-12">
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            教练列表
                        </div>
                        <!-- /.panel-heading -->
                        <div class="panel-body">
                            <div class="table-responsive">
                                <div id="dataTables-example_wrapper" class="dataTables_wrapper form-inline" role="grid">
                                    <div class="row">
                                        <div class="col-xs-6 col-ms-12">
                                            <div id="dataTables-example_filter" class="dataTables_filter">
                                                <label>角色:&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <select name="roleTag" class="form-control input-sm">
                                                        <?php foreach($roleTags as $k => $v): ?>
                                                        <option <?php if($_GET['tagId'] == $k) echo 'selected="selected"'?> value="<?= $k?>">
                                                         <?= $v ?>            
                                                        </option>
                                                        <?php endforeach?>
                                                    </select>
                                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="submit" class="btn btn-info selectByRole">确认</button>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-ms-12">
                                            <div id="dataTables-example_filter" class="dataTables_filter">
                                                <label>搜索:&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <input type="search" name="search" class="form-control input-sm" aria-controls="dataTables-example">&nbsp;&nbsp;&nbsp;&nbsp;
                                                    <button type="submit"  class="btn btn-info searchLecturer">提交</button>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    <table class="table table-striped table-bordered table-hover dataTable no-footer" id="dataTables-example" aria-describedby="dataTables-example_info">
                                        <thead>
                                            <tr role="row">
                                                <th></th>
                                                <th class="sorting_asc" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-sort="ascending" aria-label="Rendering engine: activate to sort column ascending" style="width: 100px;">id</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Browser: activate to sort column ascending" style="width: 100px;">教师头像</th>
                                                <th class="sorting" tabindex="0" aria-controls="dataTables-example" rowspan="1" colspan="1" aria-label="Platform(s): activate to sort column ascending">教师名称</th>
                                                <th>现任公司</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                         
                                        <?php $i = 0;?>
                                        <?php foreach($list as $k=>$v):?>
                                        <tr class="gradeA <?php if($i%2 == 0){echo 'odd';}else{echo 'even';}$i++;?>">
                                                <td class="sorting_1">
                                                    <input type="checkbox" name="aids" value="<?php echo $v['id'];?>" <?php if($v['id'] == $lecturer_id){echo 'checked';}?>/>
                                                </td>
                                                <td class="">
                                                    <?php echo $v['id'];?></td>
                                                <td class=" ">
                                                    <img src="<?php echo $v['thumbs'];?>" width="50px" height="50px"/>
                                                </td>
                                                <td class=" "><?php echo $v['name'];?></td>
                                                <td><?= $v['company']?></td>
                                            </tr>
                                       <?php endforeach;?>
                                                
                                            <tr>
                                                <td style="" class="text-left" colspan="6">
                                                    <button id="selectbutton" type="submit" class="btn btn-primary sure-select-lecturer" data-dismiss="modal">确认选择</button>
                                                </td>
                                            </tr>
                                        
                                        </tbody>
                                    </table>
                                    <div class="row">
    <!--                                     <div class="col-xs-12">
                                            <div class="dataTables_info" id="dataTables-example_info" role="alert" aria-live="polite" aria-relevant="all">
                                            </div>
                                        </div> -->
                                        <div class="col-xs-12 text-right pill-right">
                                            <div class="dataTables_paginate paging_simple_numbers" id="dataTables-example_paginate">
                                                <?= LinkPager::widget(['pagination' => $pages]); ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
        </div>

      <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/relation.js');?>

