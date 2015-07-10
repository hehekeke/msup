<?php 
namespace backend\components;


use Yii;
use backend\models\MsupRequest;
use backend\models\MsupSites;
use components\api\BaseErrorHandler;

class ApiAccest {

	public $firstTimeKey = 'asft';//第一次访问时间秒数Key
	public $numberKey = 'asn';   //访问次数 Key
	public $maxNumber = 1000;    //每分钟最大访问数
	public $timeOut = 60;      //超时时间 单位 s
	public function validateSource($source = '') {
		// $row = MsupSites::findOne([ 'siteUrl' => Yii::$app->request->getReferrer()]);
		return true;
		if (!$row->id) {
			return false;
		} else {
			return true;
		}

	}
	/**
	 * 检查访问次数
	 * @return returnCode error_code: -1 站点不允许访问， -2 访问次数超常
	 */
	public  function checkNumberOfTimes($num = 100) {

		$returnCode = [];
		$session = Yii::$app->session;
		$time = time();
		$firstTime = $session->get($this->firstTimeKey);

		// 第一次访问或者离上一次访问时间大于60秒的时候设置初始值
		if (empty($firstTime) || $time-$firstTime>=$this->timeOut) {
			$firstTime = $time;
			$session->set($this->firstTimeKey, $firstTime);
			$session->set($this->numberKey, 1);
		// 时间在范围之内且次数不大于指定数时，给指定数加1
		} else if (($time - $firstTime) < $this->timeOut-1) {
			
			$number = $session->get($this->numberKey);
			if (!($number>$this->maxNumber)) {
				$session->set($this->numberKey, $number+1);
			}else{
				$returnCode['errno'] = BaseErrorHandler::ERROR_CODE_2;
				$returnCode['errmsg'] = BaseErrorHandler::ERROR_MESSAGE_2;
			}
		}
		return empty($returnCode['errmsg']) ? [] : $returnCode;
		
		// 来源站点是否允许访问 暂时弃用
		// if ($this->validateSource()) {

		// 	$row = MsupRequest::find()
		// 						->orderBy('id desc')
		// 						->where(
		// 							[ 
										
		// 								'ip' => Yii::$app->request->getUserIP(),

		// 							 ])
		// 						->andWhere( time().' - firstTime < 60 ')
		// 						->one();								
		// 	if ($row->id) {
		// 		if ( $row->numbers >= $num ) {
		// 			$returnCode['errno'] = BaseErrorHandler::ERROR_CODE_1;
		// 			$returnCode['errmsg'] = BaseErrorHandler::ERROR_MESSAGE_2;
		// 		} else {
		// 			$row->numbers += 1;
		// 			$row->update();
		// 		}
		// 	} else {
				
		// 		$request = new MsupRequest;
		// 		$request->source = Yii::$app->request->getReferrer();
		// 		$request->ip = Yii::$app->request->getUserIP();
		// 		$request->firstTime = time();
		// 		$request->numbers = 0;

		// 		$request->insert();

		// 	}

		// }  else {
		// 	$returnCode['errno'] = BaseErrorHandler::ERROR_CODE_2;
		// 	$returnCode['errmsg'] = BaseErrorHandler::ERROR_MESSAGE_2;
		// }

		// return empty($returnCode['errmsg']) ? [] : $returnCode;
	}
}

?>