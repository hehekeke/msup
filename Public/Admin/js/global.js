
var global_obj={
	file_upload:function(file_input_obj, filepath_input_obj, img_detail_obj, size){
		var multi=(typeof(arguments[4])=='undefined')?false:arguments[4];
//		alert(multi);
		var queueSizeLimit=(typeof(arguments[5])=='undefined')?5:arguments[5];
		var callback=arguments[6];
		
		//初始化
		var imgpath = filepath_input_obj.val();
		if(typeof(imgpath) != undefined){
			img_detail_obj.html(global_obj.img_link(imgpath,img_detail_obj));
		}
		
//		alert('上传文件');
		file_input_obj.omFileUpload({
			action:_FILE_,
			actionData:{
				do_action:'photo',
				size:size
			},
			fileExt:'*.jpg;*.png;*.gif;*.jpeg;*.bmp',
			fileDesc:'Image Files',
			sizeLimit:0,
			onError:function(ID, fileObj, errorObj, event){
				if(errorObj.type=='File Size'){
					alert('上传图片的大小不能超过300KB！');
				}
			},
			autoUpload:true,
			multi:multi,
			queueSizeLimit:queueSizeLimit,
			swf:_PUBLIC_ +'/Admin/swf/fileupload.swf?r='+Math.random(),
			method:'post',
			onComplete:function(ID, fileObj, response, data, event){
				var jsonData=eval('('+response+')');
				if(jsonData.status==1){
					
					if(!multi){
						jsonData.imgpath = jsonData.imgpath;
						filepath_input_obj.val(jsonData.imgpath);
//						alert();
						img_detail_obj.html(global_obj.img_link(jsonData.imgpath,img_detail_obj));
					}else{
						callback(jsonData.imgpath);
					}
				}else{
					alert('图片上传失败，出现未知错误！');
				};
			}
		});
	},
	
	img_link:function(img,img_detail_obj){
		if(!img){return;}
		//如果显示的对象存在的话
		var imgwidth = 0,imgheight = 0;
		if(img_detail_obj){
			imgwidth = $(img_detail_obj).attr('imgwidth');
			imgheight = $(img_detail_obj).attr('imgheight');
		}
		
		if(!imgwidth || imgwidth <= 0){
			imgwidth = 100;
		}
		
		if(!imgheight || imgheight <= 0){
			imgheight = 100;
		}
		
		return '<a href="'+img+'" target="_blank"><img width="'+imgwidth+'" height="'+imgheight+'" src="'+img+'"></a>';
	},
	
	check_form:function(obj){
		var flag=false;
		obj.each(function(){
			if($(this).val()==''){
				$(this).css('border', '1px solid red');
				flag==false && ($(this).focus());
				flag=true;
			}else{
				$(this).removeAttr('style');
			}
		});
		return flag;
	},
	
	config_form_init:function(){
		global_obj.file_upload($('#ReplyImgUpload'), $('#config_form input[name=ReplyImgPath]'), $('#ReplyImgDetail'));
		$('#ReplyImgDetail').html(global_obj.img_link($('#config_form input[name=ReplyImgPath]').val()));
		
		$('#config_form').submit(function(){return false;});
		var action_url = $('#config_form input[name=do_action]').val();
		$('#config_form input:submit').click(function(){
			if(global_obj.check_form($('*[notnull]'))){return false;};
			
			$(this).attr('disabled', true);
			$.post(''+action_url, $('#config_form').serialize(), function(data){
				if(data.status==1){
					window.location.reload();
				}else{
					alert(data.msg);
					$('#config_form input:submit').attr('disabled', false);
				}
			}, 'json');
		});
	},
	
	reserve_form_init:function(){
		$('.reverve_field_table .input_add').click(function(){
			$('.reverve_field_table tr[FieldType=text]:hidden').eq(0).show();
			if(!$('.reverve_field_table tr[FieldType=text]:hidden').size()){
				$(this).hide();
			}
		});
		$('.reverve_field_table .input_del').click(function(){
			$('.reverve_field_table .input_add').show();
			$(this).parent().parent().hide().find('input').val('');
		});
		$('.reverve_field_table .select_add').click(function(){
			$('.reverve_field_table tr[FieldType=select]:hidden').eq(0).show();
			if(!$('.reverve_field_table tr[FieldType=select]:hidden').size()){
				$(this).hide();
			}
		});
		$('.reverve_field_table .select_del').click(function(){
			$('.reverve_field_table .select_add').show();
			$(this).parent().parent().hide().find('input').val('');
		});
	},
	
	map_init:function(){
		var myAddress=$('input[name=Address]').val();
		var destPoint=new BMap.Point($('input[name=PrimaryLng]').val(), $('input[name=PrimaryLat]').val());
		var map=new BMap.Map('map');
		map.centerAndZoom(new BMap.Point(destPoint.lng, destPoint.lat), 20);
		map.enableScrollWheelZoom();
		map.addControl(new BMap.NavigationControl());
		var marker=new BMap.Marker(destPoint);
		map.addOverlay(marker);
		
		map.addEventListener('click', function(e){
			destPoint=e.point;
			set_primary_input();
			map.clearOverlays();
			map.addOverlay(new BMap.Marker(destPoint)); 
		});
		
		var ac=new BMap.Autocomplete({'input':'Address','location':map});
		ac.addEventListener('onhighlight', function(e) {
			ac.setInputValue(e.toitem.value.business);
		});
		
		ac.setInputValue(myAddress);
		ac.addEventListener('onconfirm', function(e) {//鼠标点击下拉列表后的事件
			var _value=e.item.value;
			myAddress=_value.business;
			ac.setInputValue(myAddress);
			
			map.clearOverlays();    //清除地图上所有覆盖物
			local=new BMap.LocalSearch(map, {renderOptions:{map: map}}); //智能搜索
			local.setMarkersSetCallback(markersCallback);
			local.search(myAddress);
		});
		
		var markersCallback=function(posi){
			$('#Primary').attr('disabled', false);
			if(posi.length==0){
				alert('定位失败，请重新输入详细地址或直接点击地图选择地点！');
				return false;
			}
			for(var i=0; i<posi.length; i++){
				if(i==0){
					destPoint=posi[0].point;
					set_primary_input();
				}
				posi[i].marker.addEventListener('click', function(data){
					destPoint=data.target.getPosition(0);
				});  
			}
		}
		
		var set_primary_input=function(){
			$('input').filter('[name=PrimaryLng]').val(destPoint.lng).end().filter('[name=PrimaryLat]').val(destPoint.lat);
		}
		
		$('input[name=Address]').keyup(function(event){
			if(event.which==13){
				$('#Primary').click();
			}
		});
		
		$('#Primary').click(function(){
			if(global_obj.check_form($('input[name=Address]'))){return false};
			$(this).attr('disabled', true);
			local=new BMap.LocalSearch(map, {renderOptions:{map: map}}); //智能搜索
			local.setMarkersSetCallback(markersCallback);
			local.search($('input[name=Address]').val());
			return false;
		});
	},win_alert:function(tips, handle){
		$('body').prepend('<div id="global_win_alert"><div>'+tips+'</div><h1>好</h1></div>');
		$('#global_win_alert').css({
			position:'fixed',
			left:$(window).width()/2-125,
			top:'30%',
			background:'#fff',
			border:'1px solid #ccc',
			opacity:0.95,
			width:250,
			'z-index':10000,
			'border-radius':'8px'
		}).children('div').css({
			'text-align':'center',
			padding:'30px 10px',
			'font-size':16
		}).siblings('h1').css({
			height:40,
			'line-height':'40px',
			'text-align':'center',
			'border-top':'1px solid #ddd',
			'font-weight':'bold',
			'font-size':20
		});
		$('#global_win_alert h1').click(function(){
			$('#global_win_alert').remove();
		});
		if($.isFunction(handle)){
			$('#global_win_alert h1').click(handle);
		}
	}
}