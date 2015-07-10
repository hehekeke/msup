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
 * 即时搜索 
 * 生成一个Input表单。附带JS
 */
class TimelySearch extends Widget {

	/**
	 * @param array 需要搜索的模型和字段
	 * example
	 * ```php 
	 * ['model'=>'filed']
	 * ```
	 * @var [type]
	 */
	public $model;
	/**
	 * 搜索时所用的链接 如果没有则报错
	 * @var string
	 */
	public $searchUrl = '';
	/**
	 * 容器信息
	 * @var [type]
	 */
	public $containerOptions;
	/**
	 * 绑定的input表单class或者ID
	 * example
	 * ```
	 * "input"=>'.className',
	 * 
	 * ```
	 * @var [type]
	 */
	public $input = null;
	//提示信息
	public $message = '您是否要查找';
	public $options;
	public $data;

	//输出字段  需要展现给用户看的字段名
	public $key; 

	public function init($value='')
	{

		if (!$this->searchUrl) {
			throw new  InvalidCallException("缺少 `searchUrl` 参数");
		} 

		$this->searchUrl = Yii::$app->urlManager->createUrl($this->searchUrl);

	}


	public function run($value='')
	{
		$view = $this->getView();
		TimelySearchAsset::register($view);
		if (!$this->input) {
			echo  Html::textInput("search", " ", ["class"=>'timelySearch','data-list'=>'.default_list','autocomplete'=>'off']);
			$this->input = '.timelySearch';	
		} 

		$view->registerJs('jQuery("'.$this->input.'").timely({"message":"'.$this->message.'", "searchUrl":"'.$this->searchUrl.'", "key":"'.$this->key.'"});');
		
	}



}



?>