<?php 
namespace backend\modules\Ticket\components;

use yii;
use backend\models\MsupSettings;
use backend\models\MsupUserMember;
use backend\models\MsupScheduling;
use yii\base\InvalidValueException;
use backend\components\Mail;
class TicketMail {
	public $bank = '';
	public $email = '';
	public $layout = 'ticket-mail';
    public $linkUrl;
	public $scheduling;//课程排期信息
	public function __construct(\backend\modules\Ticket\models\MsupSchedulingTicket $model, $email){
        $this->linkUrl = $model->linkUrl;
		$this->bank = $model->bank;
		$schedulingModel = new MsupScheduling;
		$this->scheduling = $schedulingModel->findOne($model->sid);
		$this->email = empty($email) ? $this->getEmail() : $email;
	}
	public function setLayout($layout) {
		if (!empty($layout)) $this->layout = $layout;
	}
    
	public function sendEmail(){
        $mail = $this->getMail();
        $userModel = new MsupUserMember;
        $row = $userModel->find()->where(['email' => $this->email])->with('memberInfo')->one();
        $mail = $mail->compose($this->layout, ['subject' => '麦思博 '.$this->scheduling->title.' 门票票号', 'htmlBody' => '您好，感谢您报名参加我们的 XXX 课程，您的门票票号为'.$this->bank.'，此票号用于会场现场签到', 'scheduling' => $this->scheduling, 'userName' => $row->memberInfo->name,'bank' =>$this->bank, 'linkUrl' => $this->linkUrl]);
        $mail->setTo($this->email); 
        $mail->setSubject('麦思博会员购票通知');
        $mail->setTextBody($textBody);
        if ($mail->send()) {
            return true;
        } else {
            return '邮件发送失败';
        }
    }
    public function getMail(){
        $info = new MsupSettings;
        $mail = new Mail($info->getConnectionInfo());
        return $mail;
    }
    public function sendMoveTicketEmail() {
        $mail = $this->getMail();
        $userModel = new MsupUserMember;
        $row = $userModel->find()->where(['email' => $this->email])->with('memberInfo')->one();
        $mail = $mail->compose($this->layout, ['subject' => '麦思博 '.$this->scheduling->title.' 门票转移通知', 'htmlBody' => '您好，您票号为'.$this->bank.'的门票已转移成功感谢您的参与。', 'scheduling' => $this->scheduling, 'userName' => $row->memberInfo->name,'bank' =>$this->bank, 'linkUrl' => $this->linkUrl]);
        $mail->setTo($this->email); 
        $mail->setSubject('麦思博会员门票转移通知');
        $mail->setTextBody($textBody);
        if ($mail->send()) {
            return true;
        } else {
            return '邮件发送失败';
        }
    }
    public function getBank(){
    	if (!$this->bank) {
    		$model = new \backend\modules\Ticket\models\MsupSchedulingTicket;
    		$this->bank = $model->createBank();
    	}
    }
    public function setBank($bank){
    	if (!empty($bank)) $this->bank = $bank;
    }
    public function setEmail($email){
    	if(!empty($email)) $this->email = $email;
    }

    public function getEmail(){

    	$userMemberModel = new MsupUserMember;
        $member = $userMemberModel->findOne($this->model->owner);
    	return $member->email;
    }

}


?>