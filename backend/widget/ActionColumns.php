<?php 
namespace backend\widget;

use yii;
use yii\grid\ActionColumn;
use yii\helpers\Html;
use backend\components\GlobalFunc;
class ActionColumns extends \yii\grid\ActionColumn
{
	protected function initDefaultButtons()
	{
		//当前控制器中有权限的方法
		$allowActions = \backend\models\MsupAuthItemChild::find()->where('child like "%'.Yii::$app->controller->id.'%" AND parent ="'.\Yii::$app->user->identity->role.'"')->asArray()->all();
		$allows  = []; 

		foreach ($allowActions as $key => $value) {
			$controller = substr($value['child'], GlobalFunc::rGetCharPost($value['child'], '\\', -2)+1);
			$action = substr($value['child'],GlobalFunc::getCharPost($value['child'], '\\', 2)+1);
			$action = substr($action, 0, strpos($action,'\\'));

			if ($action == Yii::$app->controller->id) {
				$allows[] = substr($value['child'], GlobalFunc::rGetCharPost($value['child'], '\\', -2)+1);
			}
			
		}
		if (!empty($allows)) {
			$this->template = '';
			$buttons = ['view', 'update', 'delete'];
			$denyAction = array_intersect($buttons, $allows);
			foreach($denyAction as $v) {
				$this->template .= ' {'.$v.'} ';
			}
       	}

       	parent::initDefaultButtons();
	}
}

?>