<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;
use backend\components\Dashboard;
use backend\controllers\CommonController;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
// 仪表盘， 根据不同角色跳转到不同的URL
class DashboardController extends CommonController {

	/**
	 * 用户个人面板
	 * @param  [type] $ud user_id 用户的个人id
	 * @return [type]     [description]
	 */
	public function actionSuper($ud = null)
	{
		$dashboard = new Dashboard;
		$userId = empty($ud) ? Yii::$app->user->identity->id : $ud;
		$dashboard->setUserId($userId);
		$myCount = $dashboard->lecturerAdminCount($userId);
		return $this->render('index', ['myCount' => $myCount, 'userId' => $userId]);
	}

	public function actionLecturer() {

		return $this->render('index');
	}

	public function actionMy($m, $create_admin) {
		$url = Url::to([$m.'/index/', 'create_admin' => $create_admin]);
		$this->redirect($url);
	}
	public function actionUser($userId = null) {
		if (!$userId) {
			throw new NotFoundHttpException('该页面不存在');
		}
	}
	
}

?>