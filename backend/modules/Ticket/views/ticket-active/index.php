<?php
$this->title = '会员签到页';
?>
<body id="sign">

    <!--header 开始 -->
    <div class="header">
        <div class="header_bg"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/header_bg.jpg" /></div>
        <div class="logo"><a href="#"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/logo.png" /></a></div>
        <div class="download"><a href="#"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/download.png" /></a></div>
    </div>
	<!-- 主体框架 开始 -->
    <div class="sign_main">

        <div class="user_sign">
            <div class="tips"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/user_sign.png" /></div>
            <div class="sign">
                <div class="in">
				    <span class="tit">票号：</span>	
				    <input type="text" class="text bank" value="" placeholder="请输入会员签到票号" />
                    <div class="code">
                    	<img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/code.png" />
                    </div>
			    </div>
                <div class="submit">
                	<button type="submit" class="sub sub-bank" >提交</button>
                </div>
            </div>
        </div>

        <div class="user_info">
            <div class="container">
            <div class="user_info_top"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/user_info_top.png" /></div>
            <div class="in">
                <span class="tit">名称：</span>
                 <span class="name text edit"></span>
                <input type="hidden" class="text name" name="name" value="将智慧" placeholder="" />
            </div>
            <div class="in">
                <span class="tit">门票种类：</span>  
                <span class="tickets text"></span>
            </div>
            <div class="in">
                <span class="tit">联系电话：</span>  
                <span class="phone text edit"></span>
                <input type="hidden" class="text phone" name="phone" value="" placeholder="" />
            </div>

            <div class="in">
                <span class="tit">邮箱地址：</span>
                 <span class="email text edit"></span>  
                <input type="hidden" class="text email" name="email" value="liuchuanli@musp.com" placeholder="" />
            </div>
            <div class="in">
                <span class="tit">当前公司：</span>  
                <span class="company text edit"></span>
                <input type="hidden" class="text company" name="company" value="musp" placeholder="" />
            </div>
            <div class="in">
                <span class="tit">所在职位：</span>  
                 <span class="position text edit"></span>
                <input type="hidden" class="text position" name="position" value="ui设计" placeholder="" />
            </div>
            <div class="in border_none">
                <span class="tit">签到状态：</span>  
                <span class="isActivation text"></span>
            </div>
            
            <div class="submit">
                <button type="submit" class="sub sub-Activation full-and-activation">签到</button></div>

            <div class="user_info_bot">
            	<img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/user_info_bot.png" />
            </div>
    
		    <div id="active-history">
					<a href="<?= Yii::$app->urlManager->createAbsoluteUrl('Ticket/ticket-active/active-history') ?>" class="btn btn-history">我的签到历史管理</a>
		    </div>

        </div>

	</div>
	
<?= 
    $this->registerJs("baseUrl = '".Yii::getAlias('@baseUrl')."';");
?>
<?= 
$this->registerJsFile("@adminStatics/ticket/js/index.js");
?>