<?php 
namespace backend\components;
use Yii;
use yii\base\Object;
use yii\swiftmailer\Mailer;
class Mail extends Mailer{	
	private $mailer;
	public function __construct($connection) {
		parent::__construct([]);
		$this->setTransport(Yii::$app->mailer->getTransport());
		$this->messageConfig = Yii::$app->mailer->messageConfig;
		// 配置邮箱代理信息
		$this->transport = $this->getTransport()->newInstance($connection['host'], $connection['port'], 'tls');
		
		$this->viewPath = '@common/mail';
		$this->getTransport()->setUsername($connection['username']);
		$this->getTransport()->setPassword($connection['password']);
	}
}


?>