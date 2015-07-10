<?php 
namespace app\models;

use Yii;
// use \yii\rbac\Rule;
class BaseRule extends \yii\rbac\Rule {

	function execute($user, $item, $params) {
		if ($item == Yii::$app->controller->module->controllerNamespace.'\\'.Yii::$app->controller->id.'\\'.Yii::$app->controller->action->id) {
			return true;
		} else {
			return false;
		}

	}

}


?>