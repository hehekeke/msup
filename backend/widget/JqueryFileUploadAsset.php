<?php 
namespace backend\widget;

use Yii;
use yii\web\JqueryAsset;
use yii\web\AssetBundle;

class JqueryFileUploadAsset extends AssetBundle {

	public $sourcePath = '@plugin';
    public $basePath = '@webroot';
    public $baseUrl = '@web/Public/plugin/uploadFile/';
    public $pluginsUrl = '@web/Public/plugin/uploadFile/';

	public $js = [
	        'js/vendor/jquery.ui.widget.js',
            'js/tmpl.min.js',
            'js/load-image.all.min.js',
            'js/canvas-to-blob.min.js',
            'js/jquery.blueimp-gallery.min.js',
            'js/jquery.iframe-transport.js',
            'js/jquery.fileupload.js',
            'js/jquery.fileupload-process.js',
            'js/jquery.fileupload-image.js',
            'js/jquery.fileupload-audio.js',
            'js/jquery.fileupload-video.js',
            'js/jquery.fileupload-validate.js',
            'js/jquery.fileupload-ui.js',
            'js/cors/jquery.xdr-transport.js',
            'js/main.js',
	];
	public $css = [
			'css/style.css',
			'css/blueimp-gallery.min.css',
        	'css/jquery.fileupload.css',
        	'css/jquery.fileupload-ui.css',
	];

	public $cssOptions = [
			'position' => \yii\web\View::POS_END,
	];

	public function __construct($value)
	{
		parent::__construct($value);
		echo '<noscript><link rel="stylesheet" href="css/jquery.fileupload-noscript.css"></noscript>
			  <noscript><link rel="stylesheet" href="css/jquery.fileupload-ui-noscript.css"></noscript>';
	}
}


?>