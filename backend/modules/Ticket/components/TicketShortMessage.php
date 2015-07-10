<?php 
namespace backend\modules\Ticket\components;
use yii;
use yii\base\Object;
use backend\models\MsupSettings;
use backend\models\MsupUserMember;
use backend\models\MsupScheduling;
use yii\base\InvalidValueException;
use backend\modules\Ticket\models\MsupSchedulingTicket;
class TicketShortMessage extends Object{

	private $shortMessage;
	private $phone;
	public $model;
	public $redirctUrl='http://api.buzz.cn/index.php/Wap/index/';
	
	/**
	 * [__construct description]
	 * @param MsupSchedulingTicket $model 模型类，必须是一个实例
	 */
	public function __construct(MsupSchedulingTicket $model) {
		parent::__construct();
		$this->shortMessage = Yii::$app->ShortMessageManager;
		$this->model = $model;
		if (!$this->model->id) {
			echo '不能发送空的门票信息给会员知道不';
			exit;
		}
	}
	// 发送出票成功信息
	public function sendSuccessMessage($phone = null){
		if (!$phone && !$this->phone) {
			echo '没有手机号就别瞎调用';
			exit;
		} else if ($phone){
			$this->phone = $phone;
		}

        $shortUrl = $this->generateShortUrl($this->model->owner);
        $schedulingTickets = $this->model->getSchedulingTickets()->one();
        $scheduling = $schedulingTickets->getScheduling()->one();
        $message = '出票成功！《'.$scheduling->title.'》将于'.date('Y年m月d日 H点i分', $scheduling->startTime).'开始，请凭票号'.$this->model->bank.'提前30分钟至会场签到。 '.$shortUrl['shortUrl'].' 点击链接查看活动详细信息。【msup】';
        $res = $this->shortMessage->sendShortMessage($this->phone, $message);

        if ($res['error'] == 0) {
            return true;
        } else {
            // $this->errors = $res['message'];
            return false;
        }
	}

	public function generateShortUrl($memberid) {
        $userModel = new MsupUserMember;
        $user = $userModel->find()->where(['id' => $memberid])->select('auth_key')->one();
        // 生成短链接
        $shortUrlClass = new \components\ShortUrl;
        $shortUrl =  $shortUrlClass->create($this->redirctUrl.'key/'.$user->auth_key);
        return $shortUrl;
    }

	// 设置短信发送服务器的类
	public function setShorMessage(ShortMessage $shortMessage){
		$this->shortMessage = $shortMessage;
	}
	public function setPhone($phone){
	 	$this->phone = $phone;
	}

	// 发送票号转移信息
	public function sendMoveTicketMessage($phone)
	{
		if (!$phone && !$this->phone) {
			echo '没有手机号就别瞎调用';
			exit;
		} else if ($phone){
			$this->phone = $phone;
		}

        $shortUrl = $this->generateShortUrl($this->model->owner);
        $schedulingTickets = $this->model->getSchedulingTickets()->one();
        $scheduling = $schedulingTickets->getScheduling()->one();
        $message = '尊敬的会员，您的《'.$scheduling->title.'》门票（票号：'.$this->model->bank.'）已经成功转移。很遗憾您无法参与该活动，您可以通过Buzz在线查看该活动的PPT进行学习。下载地址：http://buzz.cn 【msup】';
        $res = $this->shortMessage->sendShortMessage($this->phone, $message);

        if ($res['error'] == 0) {
            return true;
        } else {
            $this->errors = $res['message'];
            return false;
        }
	}
}


?>