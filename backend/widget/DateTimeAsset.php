<?php 
namespace backend\widget;

use yii\web\AssetBundle;

/**
 * @author Storm Knight <410345759@qq.com>
 * @since 2.0
 */

class DateTimeAsset  extends AssetBundle{ 

	public $sourcePath = "@plugin/bootstrap-datetimepicker";

	public $js = [
			'js/bootstrap-datetimepicker.js',
			// 'js/bootstrap-datepicker.js',
			'js/locales/bootstrap-datetimepicker.zh-CN.js',

	];
	public $css = [
			'css/bootstrap-datetimepicker.css',
			'css/datepicker3.css',


	];

	public $jsOptions = [

			'position' => \yii\web\View::POS_END,
	];

	public $depends = [
        'yii\web\YiiAsset',
    ];
}

?>