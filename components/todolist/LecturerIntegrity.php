<?php
/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */

namespace components\todolist;

use Yii;
use components\todolist\ToDoListInterface;
use backend\models\MsupLecturer;
use yii\helpers\Html;
use backend\components\Integrity;
class LecturerIntegrity extends ToDoList{
	//教练信息最低完整度，低于次数将提醒教练顾问
	const MIX_INTEGRITY = 30;
	public function getTodolist($value='')
	{

		$model = new MsupLecturer;

		$lecturerRow = $model->find()->innerJoinWith( [
			'lecturerAssignment' => function($query){
							$query->where( 'user_id = '.$this->userId);} ])
									 ->all();

	    $row = [];
	    $integrity = new Integrity;
	    foreach ( (array) $lecturerRow as $k => $v) {
	    	if ($v->primaryKey) { 
	    		$vIntegrity = $integrity->getIntegrityByObj($v);
	    		if ( intval($vIntegrity) < self::MIX_INTEGRITY ) {
	    			$html = '<div class="row"><div class="col-xs-12">';
	    			$html .= '<p class="pull-left">'.$v->name.'老师，他的信息尚余 '.Html::tag('span',(100 - substr($vIntegrity,0,-1)).'%',['style' => 'color:#f00;padding:0 5px;'] ).'未完成'.'</p>';
	    			$html .='<p class="pull-right btn btn-sm btn-info">立即去完善</p></div></div>';
	    			// echo substr($vIntegrity,0,-1);
	    		$row[$k]['msg'] = $html;
	    		$row[$k]['url'] = Yii::$app->urlManager->createAbsoluteUrl(['lecturer/update', 'id' => $v->id]);
	    		}
	    	} 
		}

	   	return $row;

	}



}
?>