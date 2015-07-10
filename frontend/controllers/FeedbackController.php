<?php

namespace frontend\controllers;
use Yii;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use frontend\models\MsupUserFeedback;

class FeedbackController extends Controller{
    
    /**
     * 显示信息
     */
    public function actionIndex(){
        
        $model = new MsupUserFeedback();
        
        if (Yii::$app->request->isAjax) {
//             var_dump($model->load(Yii::$app->request->post()));
            if( $model->load(Yii::$app->request->post()) && $model->validate() && $model->save()){
                $this->ajaxJson(['errorCode'=>'0','errorName'=>'']);
            }else{
                $error = array_slice(array_values($model->getErrors()), 0,1);
                $this->ajaxJson(['errorCode'=>'1','errorName'=>$error]);
            }
            
        } else {
            $this->layout = "none";
            $paikeid = @intval($_GET['paikeid']);
            $uid = @intval($_GET['r']);
            $f = @intval($_GET['f']);
            $tagid = @intval($_GET['tagid']);
            $title = @trim($_GET['t']);
            if(!in_array($tagid, array(1,2,3,4,5))){
                $tagid = 1;
            }
//             var_dump($_COOKIE['_csrf']);exit;
            return $this->render('index',['csrf'=> Yii::$app->getRequest()->getCsrfToken(),'paikeid'=>$paikeid,'uid'=>$uid,'f'=>$f,'tagid'=>$tagid,'title'=>$title]);
        }
        
        
        
    }
    
    /**
     * 输出json
     * @param unknown $data
     */
    protected function ajaxJson($data){
        echo json_encode($data);
        exit;
    }
    
    
}