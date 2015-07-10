<?php 
namespace Msup\components;
use Yii;

/**
* RBAC权限管理 
*/
class PhpManager extends \yii\rbac\PhpManager
{
	
	public function init()
	{
		parent::init();
		if ( !Yii::$app->user->isGuest ) {
				$this->assign(Yii::$app->user->indentity->id, Yii::$app->user->indentity->role);
		} 
	}
}

?>