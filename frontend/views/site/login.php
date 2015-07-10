<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>用户登录</title>

    <!-- Bootstrap Core CSS -->
    <?php $this->registerCssFile(Yii::$app->request->baseUrl.'/Public/Admin/css/bootstrap.min.css');?>

    <!-- MetisMenu CSS -->
    <?php $this->registerCssFile(Yii::$app->request->baseUrl.'/Public/Admin/css/plugins/metisMenu/metisMenu.min.css');?>

    <!-- Custom CSS -->
    <?php $this->registerCssFile(Yii::$app->request->baseUrl.'/Public/Admin/css/sb-admin-2.css');?>

    <!-- Custom Fonts -->
    <?php $this->registerCssFile(Yii::$app->request->baseUrl.'/Public/Admin/css/font-awesome-4.1.0/css/font-awesome.min.css');?>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="http://apps.bdimg.com/libs/html5shiv/3.7/html5shiv.min.js"></script>
        <script src="http://apps.bdimg.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="container">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="login-panel panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title">用户登录</h3>
                    </div>
                    <div class="panel-body">
                        <?php $form = ActiveForm::begin([
                            'id' => 'appedit',
                            'options' => ['name'=>'appedit','role'=>'form'],
                            'method'=>'post'
                            ]);
                        ?>
                            <fieldset>
                                <div class="form-group">
                                    <?= $form->field($model, 'username') ?>
                                </div>
                                <div class="form-group">
                                    <?= $form->field($model, 'password')->passwordInput() ?>
                                </div>
                                <div class="checkbox">
                                    <?= $form->field($model, 'rememberMe')->checkbox() ?>
                                </div>
                                <!-- Change this to a button or input when using this as a form -->
                                <div class="form-group">
                                    <?= Html::submitButton('Login', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
                                </div>
                            </fieldset>
                        <?php ActiveForm::end();?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- jQuery Version 1.11.0 -->
    <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/jquery-1.11.0.js');?>

    <!-- Bootstrap Core JavaScript -->
    <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/bootstrap.min.js');?>

    <!-- Metis Menu Plugin JavaScript -->
    <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/plugins/metisMenu/metisMenu.min.js');?>

    <!-- Custom Theme JavaScript -->
    <?php $this->registerJsFile(Yii::$app->request->baseUrl.'/Public/Admin/js/sb-admin-2.js');?>
    
    
</body>

</html>
