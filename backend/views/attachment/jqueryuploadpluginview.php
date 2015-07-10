<?php 

use yii\helpers\Html;
use backend\widget\JqueryFileUploadAsset;
JqueryFileUploadAsset::register($this);
?>
<?php 

$container = (Yii::$app->request->get('container')) ?  Yii::$app->request->get('container') : Yii::$app->security->generateRandomString(8);
?>
<style type="text/css">
	.uploadFileName{display: none;}
</style>
<div class="container col-xs-12">

	<div class="row">
		<div class="col-xs-12">
			<div class="panel panel-default">
				<div class="panel-heading">文件上传</div>
				<div class="panel-body">
					<form id="<?= $container ?>" action='' method='POST' enctype="multipart/form-data" class=
					''>
				        <!-- Redirect browsers with JavaScript disabled to the origin page -->
				        <noscript><input type="hidden" name="redirect" value="https://blueimp.github.io/jQuery-File-Upload/"></noscript>
				        <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
				        <div class="row fileupload-buttonbar">
				            <div class="col-lg-7 col-sm-12">
				                <!-- The fileinput-button span is used to style the file input field as button -->
				                <span class="btn btn-success fileinput-button">
				                    <i class="glyphicon glyphicon-plus"></i>
				                    <span>添加文件</span>
				                    <input type="file" name="files[]" multiple>
				                </span>
				                <button type="submit" class="btn btn-primary start">
				                    <i class="glyphicon glyphicon-upload"></i>
				                    <span>开始上传</span>
				                </button>
				                <button type="reset" class="btn btn-warning cancel">
				                    <i class="glyphicon glyphicon-ban-circle"></i>
				                    <span>取消上传</span>
				                </button>
				                <button type="button" class="btn btn-danger delete">
				                    <i class="glyphicon glyphicon-trash"></i>
				                    <span>删除</span>
				                </button>
				                <input type="checkbox" class="toggle">
				                <!-- The global file processing state -->
				                <span class="fileupload-process"></span>
				            </div>
				            <!-- The global progress state -->
				            <div class="col-lg-5 col-sm-12 fileupload-progress fade">
				                <!-- The global progress bar -->
				                <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
				                    <div class="progress-bar progress-bar-success" style="width:0%;"></div>
				                </div>
				                <!-- The extended global progress state -->
				                <div class="progress-extended">&nbsp;</div>
				            </div>
				        </div>
				        <!-- The table listing the files available for upload/download -->
				        <table role="presentation" class="table table-striped col-xs-12"><tbody class="files"></tbody></table>
				    </form>
				    <!-- The blueimp Gallery widget -->
					<div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls" data-filter=":even">
					    <div class="slides"></div>
					    <h3 class="title"></h3>
					    <a class="prev">‹</a>
					    <a class="next">›</a>
					    <a class="close">×</a>
					    <a class="play-pause"></a>
					    <ol class="indicator"></ol>
					</div>
					<!-- 选择文件后显示 The template to display files available for upload -->
					<script id="template-upload" type="text/x-tmpl">
					{% for (var i=0, file; file=o.files[i]; i++) { %}
					    <tr class="template-upload fade">
					        <td>
					            <span class="preview"></span>
					        </td>
					        <td>
					                 <input type="hidden" class="uploadPluginInput" value='{"fileName":"{%= file.name %}","fileUrl":"{%= file.url %}", "thumbnailUrl" :"{%= file.thumbnailUrl %}"}' />


					            <p class="name">{%=file.name%}</p>
					            <strong class="error text-danger"></strong>
					        </td>
					        <td>
					            <p class="size">上传中...</p>
					            <div class="progress progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="progress-bar progress-bar-success" style="width:0%;"></div></div>
					        </td>
					        <td>
					            {% if (!i && !o.options.autoUpload) { %}
					                <button class="btn btn-primary start" disabled>
					                    <i class="glyphicon glyphicon-upload"></i>
					                    <span>开始</span>
					                </button>
					            {% } %}
					            {% if (!i) { %}
					                <button class="btn btn-warning cancel">
					                    <i class="glyphicon glyphicon-ban-circle"></i>
					                    <span>取消</span>
					                </button>
					            {% } %}
					        </td>
					    </tr>
					{% } %}
					</script>
					<!-- 上传完后显示 The template to display files available for download -->
					<script id="template-download" type="text/x-tmpl">
					{% for (var i=0, file; file=o.files[i]; i++) { %}
					    <tr class="template-download fade">
					        <td>
					            <span class="preview">
					                {% if (file.thumbnailUrl) { %}
					                    <a href="{%=file.url%}" title="{%=file.name%}" target="_blank"><img src="{%=file.thumbnailUrl%}"></a>
					                {% } %}
					            </span>
					        </td>
					        <td>
					            <p class="name">
					                {% if (file.url) { %}

					                <input type="hidden" class="uploadPluginInput" value='{"fileName":"{%= file.name %}","fileUrl":"{%= file.url %}", "thumbnailUrl" :"{%= file.thumbnailUrl %}"}' />
					                	<span class="name">{%= file.name %} </span>
					                	<input type="text" class="uploadFileName" value="{%= file.name %}"/>
					                {% } else { %}
					                    <span>{%=file.name%}</span>
					                {% } %}
					            </p>
					            {% if (file.error) { %}
					                <div><span class="label label-danger">Error</span> {%=file.error%}</div>
					            {% } %}
					        </td>
					        <td>
					            <span class="size">{%=o.formatFileSize(file.size)%}</span>
					        </td>
					        <td>
					            {% if (file.deleteUrl) { %}
					                <button class="btn btn-danger delete" data-type="{%=file.deleteType%}" data-url="{%=file.deleteUrl%}"{% if (file.deleteWithCredentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
					                    <i class="glyphicon glyphicon-trash"></i>
					                    <span>删除</span>
					                </button>
					                <a class="btn btn-info changeFileName">
									    <i class="glyphicon glyphicon-edit"></i>
									    <span>修改文件名</span>
									</a>
					                <input type="checkbox" name="delete" value="1" class="toggle">
					            {% } else { %}
					                <button class="btn btn-warning cancel">
					                    <i class="glyphicon glyphicon-ban-circle"></i>
					                    <span>Cancel</span>
					                </button>
					            {% } %}
					        </td>
					    </tr>
					{% } %}
					</script>
				</div>

				<div class="col-xs-12 npt npb">
					<div class="panel-footer row">
							<span data-dismiss="modal" class='pull-right btn btn-default'>放弃</span>
							<span class="pull-right">&nbsp;</span>
							<span data-dismiss="modal" class='pull-right btn btn-primary uploadEnter'>确定</span>
					</div>
				</div>
    <!-- The file upload form used as target for the file upload widget -->
</div>
<?php 

$this->registerJs(
		' 
		 // 修改上传文件名
		 $("#'.$container.'").on("click", ".changeFileName",function(){
		 	var inputTd = $(this).parents("tr").find("span.name").parent();
		 	inputTd.find("span.name").hide();
			inputTd.find("input.uploadFileName").show();
			$(this).find("span").text("确定");
			$(this).removeClass("changeFileName").addClass("sureChange");
		 })
		// 确认修改
		 $("#'.$container.'").on("click", ".sureChange",function(){
			var inputTd = $(this).parents("tr").find("span.name").parent();
			var fileName = inputTd.find("input.uploadFileName").val();
			inputTd.find("input.uploadFileName").hide();
			inputTd.find("span.name").text(fileName).show();
			$(this).find("span").text("修改文件名");
			var jsondata = JSON.parse(inputTd.find("input.uploadPluginInput").val());
			jsondata.fileName = fileName;
			inputTd.find("input.uploadPluginInput").val(JSON.stringify(jsondata));
			$(this).removeClass("sureChange").addClass("changeFileName");
		 })

		 $("#'.$container.'").fileupload({
        	// Uncomment the following to send cross-domain cookies:
        	//xhrFields: {withCredentials: true},
        	url: "'.Yii::getAlias('@baseUrl').'/admin.php/attachment/upload"
    	}).on("fileuploaddone", function (e, data){
    	});

		'
	);
?>