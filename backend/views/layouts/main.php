<?php
use backend\modules\Ticket\Ticket;

use backend\assets\AppAsset;
use backend\components\GlobalFunc;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;

/* @var $this \yii\web\View */
/* @var $content string */
AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    

    <meta charset="<?= Yii::$app->language ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script>
        <script src="http://apps.bdimg.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    

</head>
<body>
    <?php $this->beginBody() ?>

    <div id="wrapper">
    
        <?php if (!Yii::$app->request->get('iframe')) {?>
        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="<?= Yii::$app->urlManager->createAbsoluteUrl('/') ?>">后台管理系统</a>
            </div>
            <!-- /.navbar-header -->


            <ul class="nav navbar-top-links navbar-right">
             <!--    <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class='glyphicon glyphicon-envelope'></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class='glyphicon glyphicon-list'></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class='glyphicon glyphicon-bell'></i>
                        <i class="fa fa-caret-down"></i>
                    </a>
                </li> -->
                <li>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('Ticket/ticket-active/web-index')?>">
                        WEB版门票签到系统
                    </a>
                </li>
                <li>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('Ticket/ticket-active/index')?>">
                        移动版门票签到系统
                    </a>
                </li>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="glyphicon glyphicon-user"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">
                        <li>
                            <a href="#">
                                <i class="fa fa-gear fa-fw"></i> 设置
                            </a>
                        </li>
                        <!-- <li class="divider"></li> -->
                        <li>
                            <?php 

                                if (Yii::$app->user->isGuest) {
                            ?>
                            
                            <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl('site/login')?>"><i class="fa fa-sign-out fa-fw"></i> 登录</a>

                            <?php 
                                } else {

                            ?>
                            <a href="<?php echo Yii::$app->urlManager->createAbsoluteUrl('site/logout')?>"><i class="fa fa-sign-out fa-fw"></i> 退出</a>

                            <?php 
                                }
                            ?>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <!-- <li class="sidebar-search">
                            <div class="input-group custom-search-form">
                                <input type="text" class="form-control" placeholder="Search...">
                                <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                            </div>
                            <!-- /input-group -->
                        <!-- </li> -->

<?php 
    $globalFunc = new GlobalFunc;
    $authChild = \backend\models\MsupAuthItemChild::findAll( ['parent' => Yii::$app->user->identity->role] );
    $tempChild = [];
    foreach ($authChild as $v) {
        $tempChild[] = substr($v['child'],$globalFunc->rGetCharPost($v['child'], '\\', 2)+1);
    }
    $menu = [
        [
            'icon' => 'home',
            'text' => '首页',
            'url'  => 'site\index'
        ],
        //教练
        [
            'icon' => 'user',
            'text' => '教练管理',
            'item' => [
                [
                    'text' => '我维护的教练',
                    'url'  => 'lecturer\my',
                ],
                [
                    'text' => '教练列表',
                    'url'  => 'lecturer\index',
                ],
                [
                    'text' => '添加教练',
                    'url'  => 'lecturer\create'
                ],
            ]
        ],
        // 课程
        [
            'icon' => 'tasks',
            'text' => '课程管理',
            'item' => [
                [
                    'text' => '课程列表',   
                    'url'  => 'course\index'
                ],
                [
                    'text' => Yii::t('app', '我上传的课程'),
                    'url' => 'course\my',
                ],
                [
                    'text' => '添加课程',   
                    'url'  => 'course\create'                   
                ],
                [
                    'icon' => 'time',
                    'text' => '课程时长管理',
                    'url'  => 'course-usedtime\index',
                ],

            ],
        ],
        // 排课
        [
            'icon' => 'dashboard',
            'text' => '排课管理',
            'item' => [
                [
                    'text' => '排课列表',   
                    'url'  => 'scheduling\index'
                ],
                [
                    'text' => '我上传的排课',   
                    'url'  => 'scheduling\my'
                ],
                [
                    'text' => '添加排课',   
                    'url'  => 'scheduling\create'
                ],
            ],
        ],
        // 门票
        // [
        //     'icon' => 'list-alt',
        //     'text' => '票务管理',
        //     'item' => [
        //         [
        //             'text' => '我的出票', 
        //             'url'  => 'Ticket\scheduling-ticket\schedulings'
        //         ]
        //     ]
        // ],
        //权限
        [
            'icon' => 'lock',
            'text' => '系统用户管理',
            'item' => [
                [
                    'text' => '角色管理',
                    'url'  => 'auth-item\index',
                ],
                [
                    'text' => '用户管理',
                    'url'  => 'user\admin'
                ]
            ]
        ],
        //标签
        [
            'icon' => 'tags',
            'text' => '标签管理',
            'item' => [
                [
                    'text' => '标签栏目管理',
                    'url'  => 'category\index' 
                ],
                [
                    'text' => '标签管理',
                    'url'  => 'tags\index',
                ]
            ],
        ],
        //任务
        // [
        //     'icon' => 'tasks',
        //     'text' => '任务管理',
        //     'item' => [
        //         [
        //             'text' => '任务列表',
        //             'url'  => 'task\index',
        //         ],
        //         [
        //             'text' => '添加任务',
        //             'url'  => 'task\edit'
        //         ]
        //     ],
        // ],

        //审核
        [
            'icon' => 'eye-open',
            'text' => '审核管理',
            'item' => [
                
                [ 
                    'text' => '审核列表',
                    'url' => 'review\index',
                ],
                [
                    'text' =>'版本历史',
                    'url'  => 'history\index'
                ]
            ],

        ],
        //意见反馈
        [
            'icon' => 'info-sign',
            'text' => '意见反馈',
            'item' => [
                [
                    'text' => '反馈列表',
                    'url'  => 'feedback\index'
                ],
                [
                    'text' => '提交反馈',
                    'url'  => 'feedback\create',
                ],
            ],
        ],
        // 设置
        // [
        //     'icon' => 'cog',
        //     'text' => '设置',
        //     'item' => [
        //         [
        //             'text' => '站点管理',
        //             'url'  => 'sites\index',
        //         ],

        //     ],
        // ],

    ];


    /**
     * 根据权限生成目录
     * @param  [type] $menu    [description]
     * @param  [type] $actions [description]
     * @return [type]          [description]
     */
    function generateMenu($menu, $actions) {
        $globalFunc = new GlobalFunc;
        $navBar = '<li class="nav-item">
                        <a href="' . Yii::$app->urlManager->createAbsoluteUrl('site/index') 
                        . '"><span class="glyphicon glyphicon-home"></span>
                  我的个人中心</a></li>';
        foreach ($menu as $key => $value) {
            $li = '';//初始化一组导航按钮
            if ( !empty($value['item']) ) {

                $secondLevel = '';

                // 生成2级导航按钮
                foreach ($value['item'] as $k => $v) {
                    $action = explode('\\', $v['url']);
                    $len = count($action)-1;
                    $realyAction = $action[$len-1].'\\'.$action[$len];
                    if ( isset($v['url']) && is_string($v['url']) && in_array($realyAction, $actions)) {
                        $v['url'] = str_replace('\\', '/', $v['url']);
                        $secondLevel .= '<li>';

                        $secondLevel .= '<a href="'.Yii::$app->urlManager->createAbsoluteUrl($v['url']).'">';
                        $secondLevel .= $v['text'].'</a></li>';
                    }
                }
            }

            // 将按钮连入到总的按钮组
            if ($secondLevel) {
                    $url = isset($value['url'])&&in_array($value['url'], $actions) ? Yii::$app->urlManager->createAbsoluteUrl($value['url']) : '#';
                    $url = str_replace('\\', '/', $url);
                    $li  = '<li class="nav-item">';
                    $li .= '<a href="'.$url.'">';
                    $li .= '<span class="glyphicon glyphicon-'.$value['icon'].'"></span> ';
                    $li .= $value['text'].'<span class="fa arrow"></span></a>';
                    $li .= '<ul class="nav nav-second-level">';
                    $li .= $secondLevel.'</ul></li>';
            } else {
                $li = '';
            }

            $navBar .= $li;
        }
        return $navBar;
    }
    $realyMenu =  generateMenu($menu, $tempChild);
?>
<?= $realyMenu;?>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>
            <!-- /.navbar-static-side -->
        </nav>
        <?php }?>
        <div id="page-wrapper" style='min-height: 204px;<?php if (Yii::$app->request->get('iframe')) echo 'margin-left:0px;'?>' >
            <?php echo $content; ?>
       
        </div>
    </div>
    <!-- /#wrapper -->
    
      <script type="text/javascript">
	     var NREUMQ=NREUMQ||[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);
	     var _PUBLIC_ = '<?php echo Yii::$app->request->baseUrl;?>/Public';//公共资源文件目录
	     var _FILE_ = '{:U("Home/Index/fileupload")}';//文件上传函数
	     window.UEDITOR_HOME_URL = '<?php echo Yii::$app->request->baseUrl;?>/Public/plugin/ueditor1_4_3/';
  </script>
<?php 
$this->registerJs('$(".form-group.required").each(function(){
                            $(this).find("label.control-label").each(function(){
                                if ( $(this).find(
                                    "span.required").length == 0) {
                                    $(this).append("<span class=\'required\'>*</span>");

                                }
                            })
                    })'

);
$this->registerJsFile("@jsPath/local.js");
?>
    <?php $this->endBody() ?>

</body>
</html>
<?php $this->endPage() ?>
