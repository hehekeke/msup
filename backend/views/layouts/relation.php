<?php
use backend\assets\AppAsset;
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
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

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
        
        <?php echo $content; ?>

    </div>
    <!-- /#wrapper -->
    
      <script type="text/javascript">
	     var NREUMQ=NREUMQ||[];NREUMQ.push(["mark","firstbyte",new Date().getTime()]);
	     var _PUBLIC_ = '<?php echo Yii::$app->request->baseUrl;?>/Public';//公共资源文件目录
	     var _FILE_ = '{:U("Home/Index/fileupload")}';//文件上传函数
	     window.UEDITOR_HOME_URL = '<?php echo Yii::$app->request->baseUrl;?>/Public/plugin/ueditor1_4_3/';
      </script>

    <?php $this->endBody() ?>
    
</body>
</html>
<?php $this->endPage() ?>