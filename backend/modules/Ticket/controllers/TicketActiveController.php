<?php 
namespace backend\modules\Ticket\controllers;
use yii;
use yii\filters\VerbFilter;
use backend\controllers\CommonController;
use yii\web\Controller;
use common\models\LoginForm;
use backend\modules\Ticket\models\MsupSchedulingTicket;
class TicketActiveController extends Controller {

	public $layout = 'main_buzz_mobile';
	public function actionIndex()
	{
		$this->layout = 'main_buzz_mobile';
		return $this->render('index');
	}

	public function actionWebIndex(){
		$this->layout = 'main_buzz_pc';
		return $this->render('web-index');		
	}
	/**
	 * 签到
	 * @param  [type] $bank [description]
	 * @return [type]       [description]
	 */
	public function actionActivation($bank){
		$model = new MsupSchedulingTicket;
		$row = $model->find()->where(['bank' => $bank])->asArray()->one();
		$return = [];
		if ($row['id']) {
			$model->updateAll([ 'isActivation' => 1, 
								'update_admin' => Yii::$app->user->identity->id, 
								'actived_at' => time(0)], ['id' => $row['id']]
							);
			$return['errno'] = 0;
			$return['data'] = $row;
		} else {
			$return['errno'] = 1;
			$return['errmsg'] = '该门票不存在';
		}
		return json_encode($return);
	}

	public function actionLogin($phone = 1) 
	{
		$this->layout = 'main_buzz_mobile';
        if (!\Yii::$app->user->isGuest) {
            return $this->redirect('index');
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
	}
	public function actionGetTicketInfo($bank){
		$model = new MsupSchedulingTicket;
		$row = $model->getTicketInfo($bank);
		$return = [];
		
		if (!empty($row)) {

			if (!empty($row['userInfo']['phone']) && preg_match('/^1{1}\d{10}$/', $row['userInfo']['phone'])) {
			$row['userInfo']['phone'] =  substr($row['userInfo']['phone'],0,3).'****'.substr($row['userInfo']['phone'],7,4);
			}
			$return['errno']  = 0;
			$return['data'] = $row;
		} else {
			$return['errno'] = 1;
			$return['errmsg'] = '该门票不存在';
		}
		return json_encode($return);
	}
	public function actionActiveHistory(){
		$model = new MsupSchedulingTicket;
		$row = $model->find()->where(['update_admin' => Yii::$app->user->identity->id, 'isActivation' => 1])->with('userMemberInfo')->asArray()->all();
		return  $this->render('active-history', [
					'row' => $row
				]
		);
	}

	public function beforeAction($action)
    {   
        
        $actionId = $action->id;
        $controller = Yii::$app->controller->module->controllerNamespace.'\\'.Yii::$app->controller->id.'\\';
        if ( (Yii::$app->user->can($controller.$actionId)) || Yii::$app->user->identity->role == '超级管理员') {
            return true; 
        } else if( in_array(Yii::$app->controller->id.'/'.$actionId, ['ticket-active/index', 'ticket-active/login', 'ticket-active/logout']))  {
            return true;
        } else if (!Yii::$app->user->identity->id) {
            $this->redirect('login');
        } else {
            $this->redirect([ '/show-message/error-message', 
                              'message' => '您没有权限进行此操作',
                              'backUrl' => '/admin.php',
                              'timeOur' => 5000,
                             ]);
        }
    }


}


 ?>