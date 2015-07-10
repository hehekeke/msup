/**
 * 讲师相关JS
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
$("。msup-lecturer-form form").submit(function(){

	var lphone = '';
	var lemail = '';
	var lthumb = $("input[name='MsupLecturer[thumbs]']").val();
	var ltags  = '';

	$(".field-msupdirectory-phone input[name='MsupDirectory[phone]']").each(function () {
		lphone += $(this).val();
	})

	$(".field-msupdirectory-email input[name='MsupEmail[email]']").each(function(){
		lemail += $(this).val();
	})

	if ( lthumb == '' || lthumb == 'undefind' || lthumb == '[]') {
		alert('必须上传教练头像');
		return false;
	} else if ( lphone == '' || lphone == 'undefind' || lphone == '[]' ) {
		alert('必须添写教练电话');
		return false;
	} else if (lemail == '' || lemail == 'undefind' || lemail == '[]'){
		alert('必须填写教练邮箱');
		return false;
	}

	return true;
})


