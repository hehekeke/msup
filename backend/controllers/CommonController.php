<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use yii\web\NotFoundHttpException;

/**
 * 公用的controller
 */
class CommonController extends Controller
{
    private $isUseReview;
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'actions' => ['login', 'error'],
    //                     'allow' => true,
    //                 ],
    //                 [
    //                     'actions' => ['logout', 'index'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }

    public function getIsUseReview() {
        return Yii::$app->params['review'][Yii::$app->controller->id];
    }
    /**
     * @inheritdoc
     */
    public function actions()
    {
        
        //定义当前登录的用户
        define('UID', 10);
        
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }
    
    /**
     * 输出json
     */
    protected function json($data){
        echo json_encode($data);
        exit;
    }


    protected function printr($data){
        echo '<pre>';
        var_dump($data);
        exit;
    }

    public function beforeAction($action)
    {   
        
        $actionId = $action->id;
        $controller = Yii::$app->controller->module->controllerNamespace.'\\'.Yii::$app->controller->id.'\\';
        if ( (Yii::$app->user->can($controller.$actionId)) || Yii::$app->user->identity->role == '超级管理员') {
            return true; 
        } else if( in_array(Yii::$app->controller->id.'/'.$actionId, ['site/index', 'site/login', 'site/logout']))  {
            return true;
        } else if (!Yii::$app->user->identity->id) {
            $this->redirect(['site/login']);
        } else {
            $this->redirect([ '/show-message/error-message', 
                              'message' => '您没有权限进行此操作',
                              'backUrl' => '/admin.php',
                              'timeOur' => 5000,
                             ]);
        }
    }

    
}
