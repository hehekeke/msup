/**
 * 设置编辑器的宽度
 * @file
 * @since 1.2.6.1
 */
UE.plugin.register('resize', function (){
	
	var lastWidth;
	

    return {
       commands:{
           /**
            * @command anchor
            * @method execCommand
            * @param { String } cmd 命令字符串
            * @param { String } name 锚点名称字符串
            * @example
            * ```javascript
            * //editor 是编辑器实例
            * editor.execCommand('anchor', 'anchor1');
            * ```
            */
           'resize':{
               execCommand:function (cmd, name) {
            	   var me = this;
            	   var node = me.body.lastChild;
                   while(node && node.nodeType != 1){
                       node = node.previousSibling;
                   }
                   var options = me.options;
                   
            	   currentWidth = Math.max(domUtils.getXY(node).x + node.offsetWidth + 25 ,Math.max(options.minFrameWidth, options.initialFrameWidth)) ;
            	   if(currentWidth > 300){
//            		   this.setOpt('initialFrameWidth','300');
            		   //me.setWidth(300,true);
            		   //this.width = 300;
            		   
            	   }else{
//            		   this.setOpt('initialFrameWidth',lastWidth);
            		   //this.width = lastWidth;
            	   }
            	   lastWidth = currentWidth;
               }
           }
       }
    }
});
