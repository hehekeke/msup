
function upload (options) {

    var defaults = {
        'url' : 'http://www.msup.com/admin.php/upload/index',
        'number' : 1,
        'chunk_size' : '2mb',
        'max_file_size' :'2mb',
        'mime_types':[
                {title : "Image files", extensions : "jpg,gif,png"},
                {title : "Zip files", extensions : "zip"},
                {title : "Pdf files", extensions : "pdf,ppt"},
            ],
        'container' : "uploader"

    }
    var options = $.extend(defaults, options);

    $("#"+options.container).plupload({
        // General settings
        runtimes : 'html5,flash,silverlight,html4',
        url : options.url,

        // User can upload no more then 20 files in one go (sets multiple_queues to false)
        max_file_count: options.number,
        chunk_size: options.chunk_size,

        // Resize images on clientside if we can
        resize : {
            width : 200, 
            height : 200, 
            quality : 90,
            crop: false // crop to exact dimensions
        },
        
        filters : {
            // Maximum file size
            max_file_size : options.max_file_size,
            // Specify what files to browse for
            mime_types: options.mime_types,
        },

        // Rename files by clicking on their titles
        rename: true,
        
        // Sort files
        sortable: true,

        // Enable ability to drag'n'drop files onto the widget (currently only HTML5 supports that)
        dragdrop: true,

        // Views to activate
        views: {
            list: true,
            thumbs: true, // Show thumbs
            active: 'thumbs'
        },

        // Flash settings
        flash_swf_url : './Moxie.swf',

        // Silverlight settings
        silverlight_xap_url : './Moxie.xap'
    });

}

$('form').submit(function(e) {
    var form = $(this);
    if ($(this).find('input.uploadPluginInput').length > 0) {

        var reg = new RegExp("\"","g");
        var fieldName = '';
        var fieldValue = '';

        // 获取上传
        $(".fieldInputs").each(function(){
            fieldValue = '';
            fieldName  = $(this).attr("name");

            // 查找该元素父级中所有的input.uploadPluginInput的表单并获取值且合并成一条json
            fieldValue = getFieldValue($(this).parent(), fieldValue); 
            fieldValue +=  (fieldValue == '') ? '' : ']';
            if (fieldValue && fieldValue != '[]') form.append("<input type='hidden' class='parse-uploadFiles' name='"+fieldName+"' value='"+fieldValue+"'>");
        })

        $(".parse-uploadFiles").each(function(){

            var attachment = $(this).val();
            var fieldName = $(this).attr("name");
            if (attachment != ''  && attachment != 'undefined') {
                createAttahchemntByPost(url, attachment, fieldName);
            }
        })
    } else {
        // 当删除掉所有的附件或者没有传附件时候传入空值
        $(".fieldInputs").each(function(){
            if ($(this).find("input.parse-uploadFiles").length == 0 && $(".parse-uploadFiles").length == 0) {
                fieldValue = '';
                fieldName  = $(this).attr("name");
                form.append("<input type='hidden' class='parse-uploadFiles' name='"+fieldName+"' value=''>");
            }

        })
    }

    return true;
})

// 获取元素内上传附件字段的值
function getFieldValue(ele, fieldValue) {

    if (ele.find("input.uploadPluginInput").length < 0) return fieldValue;

    fieldValue = (fieldValue == '') ? '[' : fieldValue;

    ele.find("input.uploadPluginInput").each(function () {
        fieldValue += (fieldValue == '[') ? $(this).val() : ','+$(this).val();
        $(this).remove();
    })
    return fieldValue;
}
/**
 * 添加信息到附件表中
 * @param  {[string]}    url        [负责处理数据的接口]
 * @param  {[string]}    attachment [实际数据]
 * @param  {[string]}    fieldName  [字段名]
 * @return {[bollean]}              [处理成功与否]
 */
function createAttahchemntByPost(url, attachment, fieldName) {
    $.post(
        url,
        {attachment:attachment, field:fieldName},
        function(data) {
            if (data == "1") {
                return true;
            } else {
                return false;
            }
        }
    )

}

// 在表单中删除某一个文件
$(".panel-body").on("click", ".remove-attachment", function(){
    $(this).parents("tr").remove();
})


