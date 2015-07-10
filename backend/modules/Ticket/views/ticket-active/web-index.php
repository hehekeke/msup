<?php
use yii\web\JqueryAsset;

$this->title = '会员签到页';
JqueryAsset::register($this);
?>
<body id="sign">

    <!--header 开始 -->
    <div class="header">
        <div class="container">
            <div class="logo"><a href="#"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/web/images/logo.png" /></a></div>
            <div class="logo_intro">
                <a href="#">
                    <img src="<?= Yii::getAlias("@adminStatics")?>/ticket/web/images/logo_intro.png" />
                </a>
            </div>
        </div>
    </div>
    <!--header 结束 -->

    <!-- 主体框架 开始 -->
    <div class="sign_main">
        <div class="container">

            <div class="user">

                <div class="user_sign">
                    <div class="tips"><img src="<?= Yii::getAlias("@adminStatics")?>/ticket/web/images/user_sign.png" /></div>
                    <div class="sign">
                        <div class="in">
                            <span class="tit">票号：</span>    
                            <input type="text" class="text bank" value="" placeholder="请输入会员签到票号" />
                        </div>
                        <div class="submit">
                            <!-- <input type="submit" class="sub sub-bank"  value="" /> -->
                            <button type="submit" class="sub sub-bank" >提交</button>
                        
                        </div>
                    </div>
                </div>

                <div class="user_info">
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
                        <button type="submit" class="sub sub-Activation full-and-activation">签到</button>
                    </div>
                </div>
            </div>

            <div class="sign_history" style="height:61px;">

                <a href="<?= Yii::$app->urlManager->createAbsoluteUrl('Ticket/ticket-active/active-history') ?>" class="showHistory"><div class="top"></div></a>

                <!-- <div class="contain"> -->

                   <!--  <div class="in">
                        <div class="ticket_no">
                            <span class="tit">票号：</span>    
                            <div class="tel">201505243847</div>
                        </div>
                        <div class="name">
                            <span class="tit">姓名：</span>    
                            <div class="tel">将智慧</div>
                        </div>

                        <div class="mobile_no">
                            <span class="tit">手机：</span>    
                            <div class="tel">15102212312</div>
                        </div>

                        <div class="sign_state">已签到</div>
                    </div> -->
                <!-- </div> -->

               <!--  <div class="page">
                    <em>共1页</em>
                    <a href="#">首页</a>
                    <a href="#">上一页</a>
                    <a href="#" class="on">1</a>
                    <a href="#">下一页</a>
                    <a href="#">末页</a>                      
                </div> -->

            </div>

        </div>
    </div>
    <!-- 主体框架 结束 -->
<?= 
    $this->registerJs("baseUrl = '".Yii::getAlias('@baseUrl')."'; var bank=0;");
?>
<!-- 补全信息 JS Start -->
<!-- 补全信息 JS End -->

<?= 
    $this->registerJsFile("@adminStatics/ticket/js/index.js");
?>
</body>