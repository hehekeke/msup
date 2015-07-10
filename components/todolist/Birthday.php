<?php 
/**
 * 教练生日提醒
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
namespace components\todolist;
use yii;
use yii\helpers\Html;
use backend\models\MsupLecturer;

class Birthday extends ToDoList{

	public $userId;
	const INTERVAL = 30; //距离生日天数。

	public function getTodoList()
	{

		$lecturerModel = new MsupLecturer;
		$lecturerRow = $lecturerModel->find()
									 ->select($lecturerModel->tableName().'.id, FROM_UNIXTIME(updated_at) as updated_at, name, idNumber')
									 ->innerJoinWith(['lecturerAssignment' => function($query) {
									 	$query->select('id');
									 }])
									 ->where(['user_id' => $this->userId])
									 ->andWhere('CHAR_LENGTH(idNumber) = 18')
									 ->asArray()->all();
	   	$row = [];

	   	foreach ($lecturerRow as $key => &$v) {

	   		// 由身份证号码计算还有多少天过生日,天数小于等于设定值时，则提醒
	   		$idNumber = date("Y", time()).substr($v['idNumber'], 10, 4);
	   		
	   		$birthday = date("m月d日", strtotime(substr($v['idNumber'], 6, 8)));

	   		$dayInterval = round ( (strtotime($idNumber) - time()) /60/60/24);

	   		if ($dayInterval < self::INTERVAL && $dayInterval > 0) { 
	   			$row[$key]['msg'] = $v['name'].'老师，将在'.Html::tag('span', $dayInterval, ['style' => 'color:#f00;padding:0 5px;']).'天后过生日'.'( '.Html::tag('span', $birthday, ['style' => 'color:#428bca']).' )';
	   		}

	   	} 

	   	$lecturerRow = $row;
	   	return $lecturerRow;
	}
}

?>