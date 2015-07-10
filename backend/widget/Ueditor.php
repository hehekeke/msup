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


class Ueditor extends widget{

	/**
	 * 容器
	 * @var [type]
	 */
	public $container = 'Ueditor';
	public $fieldName = '';

	/**
	 * 容器的样式
	 * @var [type]
	 */
	public $containerOptions = [ 'id' => 'Ueditor', 'name'=>'', 'style'=>'height:440px;'];
	/**
	 * 文字内容
	 * @var string
	 */
	public $content = '';
	public function init($value='')
	{
		if (!$this->container) {
			$this->container = 'Ueditor';
		} 
		if (!$this->fieldName) {
			throw new InvalidCallException("缺少FieldName参数");
		}
		
		if (!$this->containerOptions['id']) $this->containerOptions['id'] = $this->container;
		if (!$this->containerOptions['name']) $this->containerOptions['name'] = $this->fieldName;
		# code...
	}
	public function run($value='')
	{
		$view = $this->getView();

		\backend\assets\EditAsset::register($view);	
		echo Html::tag('textarea', $this->content, $this->containerOptions);
		$view->registerJs(
			'ued = UE.getEditor("'.$this->container.'");
			$("form").submit(function(){
				$("#'.$this->containerOptions['id'].'").html(ued.getContent());
				// return false;
			})
			'
			);
		# code...
	}
}


?>