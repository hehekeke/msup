<?php 
namespace components;

use yii;
use yii\web\Controller;
class Message extends Controller{
	// 来源 URL
	public $referUrl = null;
	// 链接跳转时间
	public $jumpTime = 3000;
	
	public function __construct($referUrl = null, $jumpTime = 3000) {
		$this->referUrl = is_null($referUrl) ? Yii::$app->request->getReferrer() : $referUrl;
		$this->jumpTime = $jumpTime;
	}

	public function showMessage() {
		$this->actionShowMessage();
	}

	public function showSuccessMessage($message, $referUrl = '', $time = 0) {
		Yii::$app->getSession()->setFlash('msg.success', $message);
        $this->showMessage();
	}

	public function showErrorMessage($message)
	{
		Yii::$app->getSession()->setFlash('msg.error', $message);
	}
}


?>