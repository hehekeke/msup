<?php 
namespace backend\controllers;
use Yii;
use yii\web\Controller;
use yii\helpers\ArrayHelper;

use backend\models\MsupUserMember;
use backend\models\MsupScheduling;
use backend\modules\Ticket\models\MsupSchedulingTicket;
use backend\models\MsupCrontabNotice;

class ShortMessageCrontabController extends Controller{

	public $sid;
	/**
	 * [getTicketOnwer description]
	 * @param  [type] $sid [description]
	 * @return [type]      [description]
	 */
	private function getSchedulingTicketOnwer($id){
		
		$owner = ArrayHelper::toArray($this->getSchedulingTickInfo($this->sid));
		return ArrayHelper::getColumn($owner, 'owner');
	}
	// public function actionIndex(){
	// 	$url = 'http://api.buzz.cn/index.php/Mpd/index';
	// 	$shortUrl = new \components\ShortUrl;
	// 	p($shortUrl->create($url));

	// }
	/**
	 * 获取门票信息
	 * @return [type] [description]
	 */
	public function getSchedulingTickInfo($id)
	{
		$ticketModel = new MsupSchedulingTicket;
		$ticks = $ticketModel->find()->where(['sid' => $id])->andWhere('owner!=\'\'')->groupBy('owner')->all(); 
		return $ticks;
	}
	private function getNotifyMemberPhoneList($condition)
	{
		$userModel = new MsupUserMember;
		$memberList = $userModel->find()->where($condition)->select('phone')->andWhere('!isNull(phone)')->asArray()->all();
		return ArrayHelper::getColumn($memberList, 'phone');
	}
	public function getPhones($sid){
		$members = $this->getSchedulingTicketOnwer($sid);
		$members = implode(',', $members);
		$phones  = $this->getNotifyMemberPhoneList('id in ('.$members.')'); 
		return $phones;
	}
	private function getScheduling($sid)
	{
		$schedulingModel = new MsupScheduling;
		$scheduling = $schedulingModel->findOne($sid);
		return $scheduling;
	}
	/**
	 * 课程结束前10分钟提示
	 * @return [type] [description]
	 */
	public function actionBeforeTenMinute($id){
		$time = time();
		$scheduling = $this->getScheduling($id);
		$courses = $scheduling->getSchedulingVenueCourse()->asArray()->all();
		foreach($courses as $v) {
			$hourAndMinute = explode(':', $v['endTime']);
			$hour = $hourAndMinute[0]*3600;
			$minute = $hourAndMinute[1]*60;
			$courseTime = $v['date'] + $hour+$minute;
			if ( ( ($courseTime - $time) > 0) &&
				 ( ($courseTime - $time) <= 600) && 
				 ($this->getTodaySecond() == $v['date']) ) 
			{
				$title = date("Y-m-d H:i", $courseTime).'课程结束提示已发送';
				if(!$this->checkCrontabhasDo($title)) {
					$message = '尊敬的会员您好，本节课程即将结束，在收获知识的同时，请填写您宝贵的意见，帮助我们改进。 http://p.msup.cn/NAfP 点击链接进行反馈。';
					// $message = '尊敬的会员您好，上午的课程已经结束，欢迎您到1楼就餐，在收获知识的同时，请填写您宝贵的意见，帮助我们改进。 http://p.msup.cn/NAfP 点击链接进行反馈。';
					$this->sendShortMessageList($message);
					$this->createOneCrotabNotice($title);
					echo '发送成功';
					exit;
				}
			}
		}
	}


	/**
	 * 一门课程结束后
	 * @return [type] [description]
	 */
	// public function actionAfterCourseEnd()
	// {

	// }

	/**
	 * 课程开始前一天
	 * @return [type] [description]
	 */
	public function actionBeforeCourseStartOneDay($id)
	{

		$scheduling = $this->getScheduling($id);
		$startTime = $scheduling['startTime'];
		$dateDiff = (strtotime(date("Y-m-d H:i", $startTime)) - time())/(24*3600);
		$title = $scheduling['title'].'开始前一天通知已发送';
		if ( ($dateDiff <= 1) && !$this->checkCrontabhasDo($title)) {
			$hour = date("H", $scheduling['startTime']);
			if ($hour == '00') $hour = 10;
			$ticketModel = new MsupSchedulingTicket;
			$row = $ticketModel->find()->with('userMember')->where(['sid' => $id])->andWhere('owner!=\'\'')->groupBy('owner')->asArray()->all();	
			foreach($row as $v) {
				if (!empty($v['userMember']) && !empty($v['userMember']['phone'])) {
					$message = '尊敬的会员您好，《'.$scheduling->title.'》将于明天'.$hour.'点开始，请凭票号'.$v['bank'].'提前30分钟至会场签到。 http://www.mpd.org.cn 点击链接查看活动详细信息。';
					$this->sendShortMessage( $message,  $v['userMember']['phone']);
				}
			}
			$this->createOneCrotabNotice($title);
			echo '发送成功';
		}
	}
	/**
	 * 根据通讯列表发送数据
	 * @param  [type] $message [description]
	 * @param  [type] $phones  [description]
	 * @return [type]          [description]
	 */
	private function sendShortMessageList($message, array $phones = null) {
		if (!$phones) {
			$phones = $this->getPhones($this->sid);
		}
		foreach($phones as $v) {
			$this->sendShortMessage($message, $v);
		}
	}

	public function sendShortMessage($message, $phone){
		if (preg_match('/^1{1}\d{10}/', $phone)) {
			$rep = Yii::$app->ShortMessageManager->sendShortMessage($phone, $message);
		}
		if ($rep['errno'] == 0){
			return true;
		} else {
			return $rep['msg'];
		}
	}


	public function init(){
		$this->sid = Yii::$app->request->get('id');
	}

	/**
	 * 一天课程结束后
	 * @return [type] [description]
	 */
	public function actionAfterDayEnd($id)
	{
		$scheduling = $this->getScheduling($id);
		$course = $scheduling->getSchedulingVenueCourse()->orderBy('endTime desc')->where(['date' => $this->getTodaySecond()])->asArray()->one();
		$time = time();
		$title = date("Y-m-d", $time).' '.$scheduling['title'].'课程结束后提示';

		if (!$this->checkCrontabhasDo($title)) {

			$courseEndTimeSecond =  strtotime(date("Y-m-d", $course['date']).' '.$course['endTime']);
			if ( $time-$courseEndTimeSecond > 60) {
				$message = '尊敬的会员，一天的学习结束了，请注意休息，保持良好的精神状态迎接明天的课程。今天的内容较多不知您是否都有吸收，有很多与您共同学习的小伙伴正在交流，您可以下载Buzz与其一起互动。下载地址：http://buzz.cn';
				$this->sendShortMessageList($message);
				$this->createOneCrotabNotice($title);
				echo '发送成功';

			}
		}
	}
	public function getTodaySecond(){
		return strtotime(date('Y-m-d', time()));
	}
	/**
	 * 所有课程结束后
	 * @return [type] [description]
	 */
	public function actionAllCourseEnd($id)
	{
		$scheduling = $this->getScheduling($id);
		$course = $scheduling->getSchedulingVenueCourse()->orderBy('date desc,endTime desc')->asArray()->one();
		$time = time();
		$title = $scheduling['title'].'所有课程结束后提示';
		if (!$this->checkCrontabhasDo($title)) {
			$courseEndTimeSecond =  strtotime(date("Y-m-d", $course['date']).' '.$course['endTime']);
			if ( ($this->getTodaySecond() == $course['date']) && $time-$courseEndTimeSecond > 60) {
				$message = '尊敬的msup会员，两天的工作坊结束了，但是您的新征程才刚开始，希望将您的课堂笔记与启发，转化为明天工作的新模式，升级您的工作与事业发展。持续刷新您的经验值，还可以了解：www.msup.com.cn';
				$this->sendShortMessageList($message);
				$this->createOneCrotabNotice($title);
				echo '发送成功';

			}
		}
	}
	/**
	 * 课程开始前3天
	 * @return [type] [description]
	 */
	public function actionBeforeCourseStartThreeDay(){

	}
		// 添加一条定时任务记录
	private function createOneCrotabNotice($title, $hasDo = 1){
		$crontabModel = new MsupCrontabNotice; 
		$id = $crontabModel->create($title, $hasDo);
		return $id;
	}
	// 检查定时记录是否执行过
	private function checkCrontabhasDo($title) {
		$crontabModel = new MsupCrontabNotice; 
		$crontab = $crontabModel->findOne(['title' => $title]);
		if ($crontab->id){
			return true;
		} else {
			return false;
		}
	}
}


?>