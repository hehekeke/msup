<?php 
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
$this->title = '登录';
?>
<body id="login">
    <!--header 开始 -->
    <div class="header">
        <div class="header_bg"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/header_bg.jpg" /></div>
        <div class="logo"><a href="#"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/logo.png" /></a></div>
        <div class="download"><a href="#"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/download.png" /></a></div>
    </div>
    <!--header 结束 -->

    <div class="main">

            <div class="welcome">
                <img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/welcome.png" />
            </div>
            <?php $form = ActiveForm::begin([
                'id' => 'appedit',
                'options' => ['name'=>'appedit','role'=>'form'],
                'method'=>'post'

                ]);
            ?>
            
                <div class="login_form">

                    <div class="login">
                        <div class="in">
    						<span class="tit">帐号：</span>
                            <?= Html::textInput('LoginForm[username]', $model->username, ['class' => 'text'])?>
    					</div>

                       <div class="in1">
    						<span class="tit">密码：</span>
                            <?= Html::passwordInput ('LoginForm[password]', $model->password, ['class' => 'text'])?>
    					</div>
                    </div>

                    <div class="submit">
                     <?= Html::submitButton('', ['class' => 'sub btn btn-primary', 'name' => 'login-button']) ?>
                    </div>
                </div>
                <div class="forget_pwd"><a href="#">忘记密码？</a></div>
             <?php ActiveForm::end();?>
        </div>