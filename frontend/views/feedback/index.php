<?php
/* @var $this yii\web\View */

?>
<!DOCTYPE html>
<html lang="zh-cn">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=0">
<title>课程反馈</title>
<link rel="stylesheet" type="text/css" href="/Public/Frontend/mobile/jquery.mobile-1.4.2.min.css">
<link rel="stylesheet" type="text/css" href="/Public/Frontend/css/main.css">
<script src="/Public/Frontend/js/jquery-1.11.1.min.js"></script>
<script src="/Public/Frontend/mobile/jquery.mobile-1.4.2.min.js"></script>
<script src="/Public/Frontend/js/main.js"></script>
</head>

<body class="app_body">
    <div class="app_bg">
        <div class="app_wraper">
            <section class="app_top">
            	<?php if(in_array($tagid, array(1,2,3,4,5))):?>
                <img src="http://api.buzz.cn/Public/images/mpd_banner_<?php echo $tagid;?>.png" alt="">
                <?php endif; ?>
                <p class="app_top_txt"><?php echo $title;?> 体验反馈</p>
            </section>
            <section class="app_score">
                <p class="app_score_tips">如果您为本次课程的体验打分，您觉得可以打___分（满分10分）</p>
                <form method="post" action="app_course.html">
                    <div data-role="fieldcontain">
                        <input type="range" name="points" id="points" value="6" min="0" max="10" data-highlight="true">
                    </div>
                    <div class="app_score_wraper">
                        <ul class="app_score_num">
                            <li class="app_li01"><span></span><p><span>0</span>分</p></li><li class="app_li02"><span></span><p><span>2</span>分</p></li><li class="app_li03"><span></span><p><span>4</span>分</p></li><li class="app_li04"><span></span><p><span>6</span>分</p></li><li class="app_li05"><span></span><p><span>8</span>分</p></li><li class="app_li06"><span></span><p><span>10</span>分</p></li>
                        </ul>
                   </div>
                </form>
            </section>
            <ul class="app_service_list">
                <li>
                    <p class="app_service_ask">1.您觉得本节课程分享的内容质量如何?</p>
                    <dl class="app_radio01 app_service_answer" id="q2">
                        <dd data="1">很满意</dd>
                        <dd data="2">满意</dd>
                        <dd data="3">比较满意</dd>
                        <dd data="4">很差</dd>
                    </dl>
                </li>
                <li>
                    <p class="app_service_ask">2.您觉得本节课程讲师课堂气氛营造的如何?</p>
                    <dl class="app_radio01 app_service_answer app_lang_txt" id="q3">
                        <dd data="1">极佳</dd>
                        <dd data="2">很好</dd>
                        <dd data="3">一般</dd>
                        <dd data="4">很差</dd>
                    </dl>
                </li>
                <li>
                    <p class="app_service_ask">3.您觉得本节课程达到您的预期目标了吗?</p>
                    <dl class="app_radio01 app_service_answer" id="q4">
                        <dd data="1">达到</dd>
                        <dd data="2">未达到 </dd>
                    </dl>
                </li>
                <li>
                    <p class="app_service_ask">4.您希望将本节课程第一时间推荐给您的:</p>
                    <dl class="app_radio01 app_service_answer app_lang_txt" id="q5">
                        <dd data="1">上级领导</dd>
                        <dd data="2">HR经理</dd>
                        <dd data="3">朋友</dd>
                        <dd data="4">同事</dd>
                    </dl>
                </li>
                <li>
                    <p class="app_service_ask">5. 您对以下哪些 msup 的课程感兴趣?</p>
                    <?php 
                    	$a1 = ['软件项目管理 10 项锦囊妙计','全脑思维下的产品设计','嵌入式软件架构设计与实例','卓越软件测试质量体系最佳实践','通往卓越管理的阶梯'];
                    	$a2 = ['敏捷开发实践管理精髓','需求分析训练营','Hadoop 与 Spark 大数据架构专题','高效测试:测试用例设计与执行的敏捷化','如何培养互联网时代的研发领导力-打造自组织团队'];
                    	$a3 = ['swift 时代下的 ios8 开发实践','产品经理系列-产品竞争分析及策略','分布式架构最佳实践','问题驱动的软件测试设计','敏捷团队领导力培训'];
                    	$a4 = ['持续集成与持续交付实践','iOS 与 Android 用户体验(UX)与用户界面(UE)设计课程','卓越软件代码质量体系最佳实践','自动化测试框架设计与最佳实践','用文化打造高效能工程师团队的实战指导'];
                    ?>
                    <dl class="app_radio01 app_service_answer" id="q6">
                        <dd data="1"><?php echo $a1[$tagid - 1];?></dd>
                        <dd data="2"><?php echo $a2[$tagid - 1];?></dd>
                        <dd data="3"><?php echo $a3[$tagid - 1];?></dd>
                        <dd data="4"><?php echo $a4[$tagid - 1];?></dd>
                    </dl>
                </li>
            </ul>
            <div class="app_pages"><a href="javascript:void(0);" id="submit">提交反馈</a></div>
            
        </div>
    </div>
    <script type="text/javascript">
    		$(document).ready(function(){
    			$("#submit").click(function(){
    				var q1 = $(".ui-slider-handle.ui-btn").attr("aria-valuenow");
    				$.post('',{_csrf : '<?php echo $csrf; ?>','MsupUserFeedback[relationid]':'<?php echo $paikeid;?>','MsupUserFeedback[relationtype]':'paike','MsupUserFeedback[uid]':'<?php echo $uid; ?>','MsupUserFeedback[q1]':q1,'MsupUserFeedback[q2]':$("#q2").attr("ans"),'MsupUserFeedback[q3]':$("#q3").attr("ans"),'MsupUserFeedback[q4]':$("#q4").attr("ans"),'MsupUserFeedback[q5]':$("#q5").attr("ans"),'MsupUserFeedback[q6]':$("#q6").attr("ans")},function(data){
    					data = $.parseJSON(data);;
    					if(data.errorCode == "0"){
    						alert("反馈成功");
    						window.location="http://api.buzz.cn/index.php/Mpd/<?php if($f==1):?>course?paikeid=<?php echo $paikeid;?><?php else:?>courselist<?php endif;?>";
    					}else{
    						alert('反馈失败:'+data.errorName);
    						return false;
    					}
    				});
    			});
    		});
    </script>
</body>
</html>