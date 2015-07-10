<?php 
namespace backend\controllers;
use yii;
use yii\web\Controller;
use yii\filters\VerbFilter;

/**
 * 显示信息
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
 class ShowMessageController extends Controller
 { 	
 	public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];
    }
    /**
     * 可选择跳转页面
     * @param  [type] $message   [显示文字信息]
     * @param  [type] $okUrl     [立即跳转按钮]
     * @param  [type] $cancelUrl [回退按钮]
     * @return [type]            [description]
     */
 	public function actionChoseMessage($message, $okUrl, $cancelUrl)
 	{	
 		Yii::$app->getSession()->setFlash('msg.success', $message);
 		return $this->render('choseMessage',[
 			'message' => $message,
 			'okUrl' => $okUrl,
 			'cancelUrl' => $cancelUrl
 			]);
 	}

    public function actionErrorMessage($message, $backUrl, $timeOut = 3000){
        Yii::$app->getSession()->setFlash('msg.error', $message);
        return $this->render('errorMessage', [
                              'backUrl' => $backUrl,
                              'timeOut'  => $timeOut,
            ]);
    }

    public function actionEmail(){
        $this->layout = 0;
        return $this->render('email');
    }


 } 
 ?>