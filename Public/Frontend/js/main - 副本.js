// JavaScript Document
$(document).ready(function(e) {
	$("dl.app_radio01 dd").click(function(){
		$(this).addClass("cur");
		$(this).siblings("dd").removeClass("cur");
		$(this).attr("data-info",true);
		$(this).siblings("dd").attr("data-info",false);
	})
	
	$("dl.app_radio02 dd").click(function(){
		if($(this).hasClass("cur")){
			$(this).removeClass("cur");
			$(this).attr("data-info",false);
		}else{
			$(this).addClass("cur");
			$(this).attr("data-info",true);
		}
	})
	
	$(".ui-slider-handle").on("taphold",function(){
		alert($(".ui-shadow-inset").val());
		var myIndex=$(".ui-shadow-inset").val();
		var mySpan=$(this).parents(".ui-field-contain").siblings(".app_score_wraper").find(".app_score_num li p span");
		var myLi=$(this).parents(".ui-field-contain").siblings(".app_score_wraper").find(".app_score_num li");
		if(mySpan.html()==myIndex){
			myLi.addClass("cur");
			myLi.siblings().removeClass("cur");
		}
	});

	
});