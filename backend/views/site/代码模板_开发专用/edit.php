<?php
use yii\web\View;
use backend\assets\EditAsset;
$this->title = '任务';
EditAsset::register($this);
?>

<!-- 内容开始 -->


    


<div id="page-wrapper" style="min-height: 204px;">
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
                                    <form role="form" do_action="{:U('editDo')}" id="appedit">
                                        <div class="form-group">
                                            <label>话题标题</label>
                                            <input class="form-control" name="topictitle" value="{$info['topictitle']}">
                                        </div>
                                        <div class="form-group">
                                            <label>话题类型</label>
                                            <select class="form-control" name="topictype">
                                                <option value="1" <eq name="info['topictype']" value="1">selected="selected"</eq>>产品经理</option>
                                                <option value="2" <eq name="info['topictype']" value="2">selected="selected"</eq>>团队经理</option>
                                                <option value="3" <eq name="info['topictype']" value="3">selected="selected"</eq>>架构师</option>
                                                <option value="4" <eq name="info['topictype']" value="4">selected="selected"</eq>>开发经理</option>
                                                <option value="5" <eq name="info['topictype']" value="5">selected="selected"</eq>>测试经理</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label>关联的教练</label>
                                            <input class="form-control" name="teacherid" id="relationapp" value="{$info['teacherid']|default=''}">
                                        </div>
                                        <div class="form-group">
                                            <label>关联的活动</label>
                                            <input type="hidden" name="relationtype" value="activity"/>
                                            <input class="form-control" name="relationid" id="relationActivity" value="{$info['relationid']|default='0'}">
                                        </div>
                                         <div class="form-group">
                                            <label>话题赞数量</label>
                                            <input class="form-control" name="praisecount" value="{$info['praisecount']|default=0}">
                                        </div>
                                        <div class="form-group">
                                            <label>话题收藏数量</label>
                                            <input class="form-control" name="collectcount" value="{$info['collectcount']|default=0}">
                                        </div>
                                        <div class="form-group">
                                                <label for="disabledSelect">话题评论数量</label>
                                                <input class="form-control" name="commentcount" type="text" placeholder="" disabled="disabled" value="{$info['commentcount']|default=0}">
                                         </div>
                                         <div class="form-group">
                                            <label>开始时间</label>
                                            <input class="form-control" id="starttime" name="starttime" value="{$info['starttime']}">
                                        </div>
                                        <div class="form-group">
                                            <label>结束时间</label>
                                            <input class="form-control" id="endtime" name="endtime" value="{$info['endtime']}">
                                        </div>
                                         <div class="form-group">
                                            <label>短描述</label>
                                            <textarea class="form-control" rows="5" name="desc" >{$info['desc']}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>详细描述</label>
                                            <textarea id="editor" style="height:450px;" name="content" >{$info['content']}</textarea>
                                        </div>
                                        <div class="form-group">
                                            <label>状态</label>
                                            <div class="radio">
                                                <label>
                                                    <input type="radio" name="status"  value="1" <eq name="info['status']" value="1">checked</eq>>上线
                                                </label>
                                                <label>
                                                    <input type="radio" name="status" <eq name="info['status']" value="0">checked</eq> value="0">下线
                                                </label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="topicid" value="{$info['topicid']|default=0}"/>
                                        <button type="submit" class="btn btn-info">提交</button>
                                    </form>
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
        </div>

      <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/taskEdit.js',['depends'=>EditAsset::className()]);?>


    
    <script type="text/javascript">
        var relaionurl = '';
    </script>
    


<!-- 内容结束 -->