/**
 * 七里枫香  www.zhumin518.cn  
 */

var global_plugins = {
		//百度地图插件
		baidu_map:function(){
			var myAddress=$('input[name=activityaddress]').val();
			var destPoint=new BMap.Point($('input[name=latitude]').val(), $('input[name=longitude]').val());
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
			
			var ac=new BMap.Autocomplete({'input':'activityaddress','activityaddress':map});
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
				$('input').filter('[name=latitude]').val(destPoint.lng).end().filter('[name=longitude]').val(destPoint.lat);
			}
			
			$('input[name=activityaddress]').keyup(function(event){
				if(event.which==13){
					$('#activityaddress').click();
				}
			});
			
			$('#Primary').click(function(){
				if(global_plugins.check_form($('input[name=Address]'))){return false};
				$(this).attr('disabled', true);
				local=new BMap.LocalSearch(map, {renderOptions:{map: map}}); //智能搜索
				local.setMarkersSetCallback(markersCallback);
				local.search($('input[name=location]').val());
				return false;
			});
			
			$(function(){
				if(global_plugins.check_form($('input[name=activityaddress]'))){return false};
				$(this).attr('disabled', true);
				local=new BMap.LocalSearch(map, {renderOptions:{map: map}}); //智能搜索
				local.setMarkersSetCallback(markersCallback);
				local.search($('input[name=activityaddress]').val());
				return false;
			});
			
		},
		//百度编辑器插件
		ueditor:function(inputname){
			UE.getEditor(inputname);
		},
		//检查表单
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
		//上传的文件的地址信息
		filename:'',
		//ajax上传文件
		ajaxfileupload:function(ElementId){
			$.ajaxFileUpload
            (
                {
                    url:'index.php?m=apk&c=index&a=fileUpload&filename='+ElementId,
                    secureuri:false,
                    fileElementId:ElementId,
                    dataType: 'json',
                    beforeSend:function(){
                        
                    },
                   complete:function(){
                       
                   },              
                   success: function (data, status){
                  	 //alert(data);return ;
                      if(typeof(data.errno) != 'undefined'){
                            if(data.errno != ''){
                              alert(data.errmsg);
                              return false;
                            } else {
                              alert(data.errmsg);
                              return false;
                            }
                      }
                      
                      $("#"+ElementId).before('<input class="text-input small-input" type="text" name="thumbs[]" value="'+data.file+'" /><input class="button thumbsdel" type="button" value="删除"/><br /> ');
                  }
                   
              }
            );
			
		},
		//活动图组
		uploadimg:function(elementid){
			global_plugins.ajaxfileupload(elementid);
		}
};