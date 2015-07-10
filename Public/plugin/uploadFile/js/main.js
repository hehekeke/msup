/*
 * jQuery File Upload Plugin JS Example 8.9.1
 * https://github.com/blueimp/jQuery-File-Upload
 *
 * Copyright 2010, Sebastian Tschan
 * https://blueimp.net
 *
 * Licensed under the MIT license:
 * http://www.opensource.org/licenses/MIT
 */

/* global $, window */
$(function () {

    // 在uploadPluginModal中的确认点击后，将表格格式化后插入到原来的页面中
    $(".uploadPluginModal").on("click",".uploadEnter",function(){
        var trs = $(this).parents(".uploadPluginModal").find("tr.template-download");
        var container = $(this).parents(".uploadPluginModal").parent();
            trs.each(function(){

                var size = $(this).find("span.size");
                var inputName = $(this).find("input.uploadPluginInput").attr("name");
                var inputValue = $(this).find("input.uploadPluginInput").val();

                var file = JSON.parse($(this).find("input.uploadPluginInput").val())

                var deleteBtn  = "<td><a href=\'javascript:void(0)\' class=\'deleteBtntn btn-sm btn-danger remove-attachment\'><span class=\'\'></span>删除</a></td>";
                var htmls  = "<tr>";
                    // 插入input表单
                    htmls += "<td class=\'fileName\'> <input type=\'hidden\' class=\'uploadPluginInput\' name=\'" + inputName + "\' value=\'" + inputValue + "\'/>"
                    //插入文件名
                    htmls += " <a href=\'" + file.fileUrl + "\' target=\'_blank\'>" + file.fileName + "</a></td>" 
                    //插入文件大小
                    htmls += "<td class=\'size\'><span>" + size.text() + "</span></td>" 
                    //插入删除按钮
                    htmls += deleteBtn + "</tr>";

                if (container.find("table.uploadFiles").length == 0) {
                    var tableHtml = "<table class=\'uploadFiles table text-left table-striped table-bordered dataTable no-footer attachment\' style=\'margin-top:10px;\'>"
                    tableHtml += "<thead><tr><th>附件名</th><th>大小</th><th>删除</th></tr>"
                    tableHtml += "</table>";
                    container.append(tableHtml);
                }
                container.find("table.uploadFiles").append(htmls);

            })
        trs.remove();

    })



    // Initialize the jQuery File Upload widget:
    // $('#fileupload').fileupload({
    //     // Uncomment the following to send cross-domain cookies:
    //     //xhrFields: {withCredentials: true},
    //     url: 'http://www.msup.com/admin.php/attachment/upload'
    // }).on('fileuploaddone', function (e, data){
    // });

    // Enable iframe cross-domain access via redirect option:

    // $('#fileupload').fileupload(
    //     'option',
    //     'redirect',
    //     window.location.href.replace(
    //         /\/[^\/]*$/,
    //         '/cors/result.html?%s'
    //     )
    // );

    // if (window.location.hostname === 'blueimp.github.io') {
    //     // Demo settings:
    //     $('#fileupload').fileupload('option', {
    //         url: '//jquery-file-upload.appspot.com/',
    //         // Enable image resizing, except for Android and Opera,
    //         // which actually support image resizing, but fail to
    //         // send Blob objects via XHR requests:
    //         disableImageResize: /Android(?!.*Chrome)|Opera/
    //             .test(window.navigator.userAgent),
    //         maxFileSize: 5000000,
    //         acceptFileTypes: /(\.|\/)(gif|jpe?g|png)$/i
    //     });
    //     // Upload server status check for browsers with CORS support:
    //     if ($.support.cors) {
    //         $.ajax({
    //             url: '//jquery-file-upload.appspot.com/',
    //             type: 'HEAD'
    //         }).fail(function () {
    //             $('<div class="alert alert-danger"/>')
    //                 .text('Upload server currently unavailable - ' +
    //                         new Date())
    //                 .appendTo('#fileupload');
    //         });
    //     }
    // } else {
    //     // Load existing files:
    //     $('#fileupload').addClass('fileupload-processing');
    //     $.ajax({
    //         // Uncomment the following to send cross-domain cookies:
    //         //xhrFields: {withCredentials: true},
    //         url: $('#fileupload').fileupload('option', 'url'),
    //         dataType: 'json',
    //         context: $('#fileupload')[0]
    //     }).always(function () {
    //         $(this).removeClass('fileupload-processing');
    //     }).done(function (result) {
    //         $(this).fileupload('option', 'done')
    //             .call(this, $.Event('done'), {result: result});
    //     });
    // }
 
});
