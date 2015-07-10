<?php 
$this->title = '签到历史';
?>
<body id="sign_his">

    <!-- 主体框架 开始 -->

    <div class="sign_history">

        <div class="top_href">
            <div class="href"><a href="<?= Yii::$app->urlManager->createAbsoluteUrl('Ticket/ticket-active/index')?>"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/images/top_href.png" /></a></div>
            <div class="title"><span>签到历史</span></div>
        </div>

        <div class="container">

		<?php foreach($row as $v):?>
            <div class="sign_content">
                <div class="sign_detail">
                    <div class="in">
                        <span class="tit">票号：</span>	
	                    <div class="tel"><?= $v[bank] ?></div>
                    </div>
                    <div class="in">
                        <span class="tit">姓名：</span>	
	                    <div class="tel"><?= $v[userMemberInfo][name]?></div>
                    </div>
                    <div class="in">
                        <span class="tit">公司：</span>	
	                    <div class="tel"><?= $v[userMemberInfo][company]?></div>
                    </div>
                </div>
                <!-- <div class="sign_state">
                	
                </div> -->
            </div>
		<?php endforeach;?>
	    </div>
    </div>

    <!-- 主体框架 结束 -->

</body>
</html>
