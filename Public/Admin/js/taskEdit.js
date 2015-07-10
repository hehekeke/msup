/**
 * 任务管理js
 */

//<!-- 弹出层插件 开始 -->
    $(document).ready(function(){
    	
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
		
		
            //$('#relationapp').on('click','.relationapp',function(event){
        $('#relationapp').click(function(event){
       
            //alert(11);
            event.preventDefault();
            var $aid = $("input[name=id]").val();
            var $id = $(this).attr("label_id");
            var $url = relaionurl;
            
            $.layer({
                type : 2,
                shade : [0],
                fix: false,
                title : ['关联教练',true],
                iframe : {src : $url },
                area : ['1000px' , '560px'],
                offset : ['50px', '100px'],
                shade : [0.5 , '#000' , true],
                shadeClose : true,
                close : function(index){
    //              alert(1);
                    $('#relationid').val(layer.getChildFrame('input[name=aids]', index).val());
    //              layer.msg('您获得了子窗口标记：' + layer.getChildFrame('#name', index).val(),3,1);
                    layer.close(index);
                },
            });
        });
        
        
        $('#relationActivity').click(function(event){
            
            //alert(11);
            event.preventDefault();
            var $aid = $("input[name=id]").val();
            var $id = $(this).attr("label_id");
            var $url = relaionurl;
            
            $.layer({
                type : 2,
                shade : [0],
                fix: false,
                title : ['关联的活动',true],
                iframe : {src : $url },
                area : ['1000px' , '560px'],
                offset : ['50px', '100px'],
                shade : [0.5 , '#000' , true],
                shadeClose : true,
                close : function(index){
    //              alert(1);
                    $('#relationid').val(layer.getChildFrame('input[name=aids]', index).val());
    //              layer.msg('您获得了子窗口标记：' + layer.getChildFrame('#name', index).val(),3,1);
                    layer.close(index);
                },
            });
        });
            
            
    });
    
    //<!-- 弹出层插件 结束 -->