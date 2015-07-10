// JavaScript Document
$(document).ready(function(e) {
	$("dl.app_radio01 dd").click(function(){
		$(this).addClass("cur");
		$(this).siblings("dd").removeClass("cur");
		$(this).attr("data-info",true);
		$(this).siblings("dd").attr("data-info",false);
		$(this).parent().attr("ans",$(this).attr("data"));
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
	$(".ui-slider-handle").on("touchmove",function(){
		var mySpan=$(".app_score_wraper li").find("p").children("span");
		var myVal=$(".ui-slider-input").val();
		mySpan.each(function(index,element) {
			if(mySpan.eq(index).html()==myVal){
				mySpan.eq(index).parents("li").addClass("cur");
			}else{
				mySpan.eq(index).parents("li").removeClass("cur");
			};
		});
	
	});

	
});