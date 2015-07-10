<?php 

/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */

namespace components\todolist;
use Yii;
use yii\base\Model;
use backend\models\MsupLecturer;
use backend\models\MsupContactNotes;
use backend\models\MsupLecturerAssignment;
use yii\helpers\Html;
class Contact extends ToDoList {

	// 通知时间间隔
	const INTERVAL = 30; 
	public function getTodoList()
	{

		$lecturerModel = new MsupLecturer;
		$sql = 'SELECT c.id as cid, l.id, l.name, c.lastContact, c.created_at, name, round((UNIX_TIMESTAMP()- c.created_at)/24/3600) as day from ' . $lecturerModel->tableName() . ' as l INNER JOIN '.MsupLecturerAssignment::tableName() . ' as la on la.lecturer_id = l.id and la.user_id = ' . $this->userId . ' and la.status = 1 LEFT JOIN ' . MsupContactNotes::tableName() . ' as c  on c.toId = l.id and c.toModel=' . $lecturerModel->modelId . ' and c.userid = '.$this->userId .' and c.lastContact = 1  ORDER BY day desc, c.created_at asc ';

		$lecturerRow = Yii::$app->db->createCommand($sql)->queryAll();

	   	$row = [];
	   	foreach ( (array) $lecturerRow as $key => $v) {

	   		// 根据是否沟通过以及上一次沟通时间进行提醒
	   		if ( !isset($v['day']) ) {

	   			$hint = '已成为我维护的教练，赶快跟他联系吧。';

	   		} else if (  intval( $v['day'] ) > self:: INTERVAL ) {
	   			$hint = '已经有'.Html::tag('span',$v['day'], ['style' => 'color:#f00;padding:0 5px;']).'天没有与他沟通啦。';
	   		} else { 
	   			continue;
	   		}

	   		$html = '<div class="row"><div class="col-xs-12">';
	   		$html .= '<p class="pull-left">';
	   		$html .= $v['name'].'老师,'.$hint;
	   		$html .= '</p><p class="pull-right btn btn-sm btn-info">立即去沟通</p></div></div>';
	   		$row[$key]['msg'] = $html;
	   		$row[$key]['url'] = Yii::$app->urlManager->createAbsoluteUrl(['lecturer/view', 'id' => $v['id']]);
	   	} 
	   	$lecturerRow = $row;
	   	return $lecturerRow;
	}
}
?>