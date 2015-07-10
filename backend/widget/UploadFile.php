<?php 
namespace backend\widget; 
use yii;
use yii\base\InvalidCallException;
use yii\base\Widget;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;


/**
 * examples
 * UploadFile::widget(
 * 		[
 * 			'extensions' => 'jpg,gif,png',
 * 			'size' => '2mb',
 * 			'number' => '5',
 * 		);
 * 
 */
class UploadFile extends Widget {

	public $fieldName = '';
	/**
	 * div 容器
	 * @var [type]
	 */
	public $container;
	// 是否显示进度条
	public $isProgress = true;
	// 进度条Id
	public $progressId = '';
	// 是否自动上传
	public $isAutoUpload = true;
	/**
	 * 上传格式
	 * default 'jpg,gif,png',
	 * 参数格式
	 * $extensions = [
	 * 	"Image Files" => 'jpg, gif,png',
	 * 	"Zip Files" => 'zip',
	 * 	"PDF Files" => 'pdf',
	 * 	];
	 * @var [type]
	 */
	public $mime_types;

	public $buttonText = '文件上传';
	/**
	 * 文件大小
	 * default php.ini max_upload_file_size;
	 * @var [type]
	 */
	public $size; //上传大小限制
	/**
	 * 文件数量
	 * default null 不限制
	 * @var [type]
	 */
	public $number = 20;  

	// 处理上传文件的链接
	public $url = '';

	public function init () {

		if (!$this->fieldName) {
			throw new InvalidCallException("上传组件缺少 fieldName 参数");
		}

		$max_upload_file_size = ini_get('upload_max_filesize');
		if (!$this->size || $this->size > $max_upload_file_size ) {
			$this->size = $max_upload_file_size;
		}

		$Security = new \yii\base\Security;

		// 设置进度条ID
		if ( $this->isProgress ) {
			if (!$this->progressId) {
				$this->progressId = 'prosess_'.$Security->generateRandomString(8);
			}
		}

		if (!$this->container ) {
			$this->container = 'uploader_'.$Security->generateRandomString(8);
		}


		if (!$this->url) $this->url = Yii::$app->urlManager->createAbsoluteUrl(["/upload/index"]);
		parent::init();
	}

	public function run($value='')
	{
		$view = $this->getView();
		$options = json_encode($this);
		echo '<div class="fieldInputs" name="'.$this->fieldName.'"></div>';
		echo '<span class="btn btn-success fileinput-modal show-'.$this->fieldName.'-modal">
				                    <i class="glyphicon glyphicon-plus"></i>
				                    <span>'.$this->buttonText.'</span>
			 </span>';
		echo '<div class="modal uploadPluginModal" name="'.$this->fieldName.'" id="'.$this->fieldName.'" tabindex="-1">
				<div class="modal-dialog modal-lg">
					<div class="modal-content">
						<div class="modal-body"></div>
					</div>
  				</div>
			 </div>';
		$view->registerJsFile("/Public/plugin/uploadFile/js/index.js");
		$view->registerJs(
				'
					$(".uploadPluginModal").each(function(){
						$(this).modal({remote:"'.Yii::$app->urlManager->createAbsoluteUrl([ 'attachment/upload-plugin-view', 'fieldName' => $this->fieldName]).'"}).modal("hide");
					})

					$(".fileinput-modal").click(function(){
						$(this).next(".uploadPluginModal").modal("show");
					})
			   '
			);

	}
}
?>