var app_obj={
	appedit_init:function(){
		//加载上传按钮
		global_obj.file_upload($('#banner_file'), $('#appedit input[name=banner]'), $('#banner_detail'));
		//加载上传按钮
		global_obj.file_upload($('#thumb_file'), $('#thumb_hidden'), $('#thumb_detail'));
	
//		if(!$.isEmptyObject($("#editor"))){
			var ue = UE.getEditor('editor');
//		}
		
		
		$('#starttime').datetimepicker().datetimepicker({step:1});
		$('#endtime').datetimepicker().datetimepicker({step:1});
		
		$("#time").click(function(){
			$(".daterangepicker").css('left',$('#time').offset().left).css('top',$('#time').offset().top + 30);
		});
		
		//ajax提交更新，返回
		$('#appedit').submit(function(){return false;});
		$('#appedit button[type=submit]').click(function(){
			$(this).attr('disabled', true);
			var $url = $("#appedit").attr('do_action');
			$.post($url, $('#appedit').serialize(), function(data){
				$('#appedit input:submit').attr('disabled', false);
				if(data.status==1){
					//setTimeout("function(){window.location = data.jumpurl;}",1000); //这样就行拉
				//	setTimeout("window.location = data.jumpurl;",1000); //这样就行拉
				
				//	global_obj.win_alert('操作成功',function(){
						window.location = data.jumpurl;
				//	});
					
					
//					
				}else{
					global_obj.win_alert('设置失败：'+data.errmsg);
//					$('#appedit input:submit').attr('disabled', true);
				};
			}, 'json');
		});
		
		$('#home_form .item .rows .b_l a[href=#shop_home_img_del]').click(function(){
			var _no=$(this).attr('value');
			$('#home_form .b_r').eq(_no).html('');
			$('#home_form input[name=ImgPathList\\[\\]]').eq(_no).val('');
			this.blur();
			return false;
		});
	},
	
	
}