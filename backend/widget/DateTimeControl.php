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

use backend\widget\DateTimeAsset;
/**
 * 日期时间选择控件
 */
class DateTimeControl extends Widget {

	/**
	 * 时间选择格式
	 * @var string
	 */
	public $format = 'yyyy-mm-dd';
	public $model;
	public $attribute;
	/**
	 * 模型的属性
	 * @var string
	 */
	public $fieldName = '';

	// 字段的值
	public $value;
	// 表单属性
	public $contentOptions = '';

	// 是否渲染表单Html
	public $renderInput = false; 
	/**
	 * @property autoclose;
	 * 是否在选择一个日期后立即关闭日期时间选择器 
	 * @var [type]
	 */
	public $autoclose = true; 

	public function init()
	{
		if (!$this->fieldName && !$this->contentOptions['class']) {
			throw new InvalidCallException('缺少 `fieldName` 参数');
		}	

		parent::init();
	}

	public function run() {

		$view = $this->getView();
		DateTimeAsset::register($view);
		$Security = new yii\base\Security;
		$css = 'dateTimePicker_'.$Security->generateRandomString(8);
		$this->contentOptions['class'] .= ' '.$css;
		$this->contentOptions['readonly'] = 'true';
		if ($this->renderInput) {
			echo Html::textInput($this->fieldName, $this->value, $this->contentOptions);
		}

		$css = implode('.',explode(' ',$this->contentOptions['class']));
		// p($this->format);
		if ( $this->format == 'yyyy-mm-dd') {
			$view->registerJs('
				$(function(){
					$(".'.$css.'").datetimepicker({
					language:  "zh-CN",
					format: "'.$this->format.'",
			        weekStart: 1,
			        todayBtn:  1,
					autoclose: '.$this->autoclose.',
					todayHighlight: 1,
					startView: 2,
					minView: 2,
					// maxView: 2,
					forceParse: 0
			    	});
				})
				');
		} else {
			$view->registerJs('
			$(function(){
				$(".'.$css.'").datetimepicker({
				language:  "zh-CN",
				format: "'.$this->format.'",
		        weekStart: 1,
		        todayBtn:  1,
				autoclose: '.$this->autoclose.',
				todayHighlight: 1,
				startView: 2,
				minView: 0,
				maxView: 1,
				forceParse: 0
		    	});
			})
			');
		}

	}
}


?>