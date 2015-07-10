<?php
namespace backend\components;

use yii;
use backend\models\MsupLecturer;
use backend\models\MsupLecturerAssignment;
use backend\models\MsupCourse;
use backend\models\MsupScheduling;
use backend\modules\Ticket\models\MsupSchedulingTicket;
class Dashboard {

	public static $userId;

	public function __construct() {
		self::$userId = self::getUserId();
	}
	/**
	 * 获取个人维护的教练
	 * @return [type]          [description]
	 */
	public static function myLecturers()
	{
		$lecturer = new MsupLecturer;
		$query = $lecturer->find()->leftJoin('msup_lecturer_assignment la', 'la.lecturer_id = '.$lecturer->tableName().'.id');

		if (self::$userId) {
			$query = $query->where('la.user_id = '.self::$userId);
		}
		$query = $query->andWhere(['la.status' => 1]);
		$row = $query->count();

		return $row;
	}

	public static function setUserId($userId=null)
	{
		self::$userId = $userId ? $userId : Yii::$app->user->identity->id;
	}

	public static function getUserId() 
	{
		if (empty(self::$userId)){

			self::$userId = Yii::$app->request->get('user_id') ? Yii::$app->request->get('user_id') : Yii::$app->user->identity->id;
		}
		return self::$userId;
	}

	// 获取个人上传的课程
	public static function myCourses() {
			return MsupCourse::find()->where(['create_admin' => self::$userId])->count();
	}

	public function mySchedulings($value='')
	{
		return MsupScheduling::find()->where(['create_admin' => self::$userId])->count();
	}
	public  static function myTickets() {
		return MsupSchedulingTicket::find()->where(['create_admin' => self::$userId])->count();
	}
	// 待处理事物
	public  function lecturerAdminCount($user_id) {

		return [ 
			'myLecturers' => $this->myLecturers(),
			'myCourses' => $this->myCourses(),
			'myScheduling' => $this->mySchedulings(),
			'myTickets' => $this->myTickets(),
 		];
	}

}

?>