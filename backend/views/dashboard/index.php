<?php 
    $this->registerJs('localStorage.nowItem=0;$("ul.collapse.in").removeClass("in")');
?>

<?php
/* @var $this yii\web\View */
use backend\widget\Todolist;
$this->title = '个人面板';
?>
<div class='site-index row'>
    <div class="col-lg-12">
        <h1 class="page-header"><?=$this->title?></h1>
    </div>
    <!-- 资料维护信息统计 -->
    <div class="row nm">
            <div class="col-lg-3 col-md-12 col-sm-12">
                <div class="panel panel-primary">
                    <div class="panel-heading">
                        <div class="row">

                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-user 5x" style="font-size:5em;"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?= $myCount['myLecturers']?></div>
                                <div>正在维护的教练</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['lecturer/index', 'create_admin' => Yii::$app->user->identity->id])?>">
                        <div class="panel-footer">
                            <a class="pull-left" href="<?= Yii::$app->urlManager->createAbsoluteUrl(['lecturer/my', 'create_admin' => Yii::$app->user->identity->id])?>"> 查看详细</a>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 col-sm-12">
                <div class="panel panel-green">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-tasks fa-5x" style="font-size:5em;"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?= $myCount['myCourses']?></div>
                                <div>我上传的课程</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['course/index', 'create_admin' => Yii::$app->user->identity->id])?>">
                        <div class="panel-footer">
                            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['course/index', 'create_admin' => Yii::$app->user->identity->id])?>" class="pull-left">
                            查看详细
                            </a>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 col-sm-12">
                <div class="panel panel-yellow">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="glyphicon glyphicon-calendar" style="font-size:5em;"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?= $myCount['myScheduling'];?></div>
                                <div>我的排课</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['scheduling/index', 'create_admin' => Yii::$app->user->identity->id]) ?> ">
                        <div class="panel-footer">
                            <span class="pull-left">查看详细</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
            <div class="col-lg-3 col-xs-12 col-sm-12">
                <div class="panel panel-red">
                    <div class="panel-heading">
                        <div class="row">
                            <div class="col-xs-3">
                                <i class="fa fa-support fa-5x" style="font-size:5em;"></i>
                            </div>
                            <div class="col-xs-9 text-right">
                                <div class="huge"><?= $myCount['myTickets']?></div>
                                <div>我的出票</div>
                            </div>
                        </div>
                    </div>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('Ticket/scheduling-ticket/schedulings');?>">
                        <div class="panel-footer">
                            <span class="pull-left">查看详细</span>
                            <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                            <div class="clearfix"></div>
                        </div>
                    </a>
                </div>
            </div>
    </div>
    <!-- 待办事项 -->
    <div class="row nm">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">待办事项</div>
                <div class="panel-body">
                    <?= Todolist::widget(
                        ['userId' => $userId]
                    );?>      
                </div>
            </div> 
        </div>
    </div>
        </div>
    </div>
</div>
