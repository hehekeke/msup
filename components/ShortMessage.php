<?php 
namespace components;
use Yii;
use backend\models\MsupSettings;
abstract class ShortMessage {
	public $apiKeyInfo = [];
	public function __construct(){
		$this->setApiKeyInfo();
	}
	/**
	 * 需要添加一个事件
	 * @param  [type] $mobile  [description]
	 * @param  [type] $message [description]
	 * @return [type]          [description]
	 */
	function sendShortMessage($mobile, $message) {

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $this->apiKeyInfo['url']);

		curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		curl_setopt($ch, CURLOPT_HEADER, FALSE);

		curl_setopt($ch, CURLOPT_HTTPAUTH , CURLAUTH_BASIC);
		curl_setopt($ch, CURLOPT_USERPWD  , $this->apiKeyInfo['password']);

		curl_setopt($ch, CURLOPT_POST, TRUE);
		curl_setopt($ch, CURLOPT_POSTFIELDS, array('mobile' => $mobile,'message' => $message.' '.Yii::$app->params['shortMessageSignature']));

		$res = curl_exec( $ch );
		curl_close( $ch );
		$res = json_decode($res, true);
		return $res;
	}

	function setApiKeyInfo(){
		$settings = new MsupSettings;
		$apiKeyInfo = $settings->find()->select('messageApiKey')->one();
		$apiKeyInfo = json_decode($apiKeyInfo['messageApiKey'], true);
		if (empty($apiKeyInfo)) {
			throw new \yii\base\ErrorException('您尚未配置短信APIKEY');
		}
		$this->apiKeyInfo = $apiKeyInfo;
	}


}


?>