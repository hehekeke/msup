<?php

namespace backend\modules\Ticket\controllers;

use Yii;
use backend\modules\Ticket\models\MsupSchedulingTickets;
use backend\modules\Ticket\models\MsupSchedulingTicket;
use backend\modules\Ticket\models\MsupSchedulingTicketSearch;
use backend\models\MsupUserMember;
use backend\models\MsupSchedulingSearch;
use backend\models\MsupScheduling;
use backend\models\MsupMemberInfo;
use backend\controllers\CommonController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SchedulingTicketController implements the CRUD actions for MsupSchedulingTicket model.
 */
class SchedulingTicketController extends CommonController
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
     * Lists all MsupSchedulingTicket models.
     * @return mixed
     */
    public function actionIndex($schedulingId = 0, $schedulingIdTicketsId=0)
    {
        $searchModel = new MsupSchedulingTicketSearch;
        $params = Yii::$app->request->queryParams;
        $title = '查看所有出票信息';
        if($schedulingIdTicketsId)$params[$searchModel->formName()]['stid'] = $schedulingIdTicketsId;
        if($schedulingId) {
            // $title = '查看';
            $params[$searchModel->formName()]['sid'] = $schedulingId;
            $schedulingModel = new MsupScheduling;
            $scheduling = $schedulingModel->findOne($schedulingId);
            $title = '查看 《'.$scheduling->title.'》出票信息';

        }

        $params[$searchModel->formName()]['create_admin'] = ($params[$searchModel->formName()]['create_admin'])? ($params[$searchModel->formName()]['create_admin']) : Yii::$app->user->identity->id;
        

        $dataProvider = $searchModel->search($params);
        $dataProvider->query->with('user')->with('userMemberInfo')->with('schedulingTickets.tickets');
        return $this->render('index', [
            'title' => $title,
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // 转移 门票给其他会员
    public function actionMoveTicket($id){
        $model = new MsupSchedulingTicket();
        $ticket = $this->findModel($id);
        if (!$ticket->id) {
            $this->redirect([ '/show-message/error-message', 
                        'message' => '您要转移的门票已不存在', 
                        'backUrl' => Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $schedulingId]),
                    ]);
        }

        $userModel = new MsupUserMember;
        $memberInfoModel = new MsupMemberInfo;
        $ticketsModel = new MsupSchedulingTickets;
        $tickets = $ticketsModel->getTicketsBySchedulingId($ticket->sid);

        // 检查该手机号是否已经注册，并为要保存的信息自动设置购买者和拥有者
        if ($userModel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $model->saveOwnerInfo() ) {
            // 根据票的拥有者得到用户信息
            $model->bank = $model->createBank();
            $model->sid = $ticket->sid;
            if ( $model->save() && $ticket->delete()) {
                return $this->redirect([ '/show-message/chose-message', 
                        'message' => '门票转移成功，新的票号为'.$model->bank.'。点击立即跳转可查看您的出票信息', 
                        'okUrl' => Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $schedulingId]),
                        'cancelUrl' =>  Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $schedulingId])
                    ]);
            } else if($model->id && $res['error'] !=0 ) {

            }

        } else {

            $schedulingModel = new \backend\models\MsupScheduling;
            $scheduling = $schedulingModel->find()->where(['id' => $ticket->sid])->one();
            $model->linkUrl = $scheduling->getLinkUrl();

            return $this->render('create', [
                'model' => $model,
                'userModel' => $userModel,
                'memberInfoModel' => $memberInfoModel,
                'tickets' => $tickets,
            ]);
        }
    }
    // 查看所有排课
    public function actionSchedulings() {
        $searchModel = new MsupSchedulingSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        return $this->render('schedulings', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
            ]);
    }
    // 查看排课所有出票信息
    public function actionSchedulingAllTicket($schedulingId) {
        $searchModel = new MsupSchedulingTicketSearch;
        $params = Yii::$app->request->queryParams;
        $params[$searchModel->formName()]['sid'] = $schedulingId;
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupSchedulingTicket model.
     * @param in teger $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MsupSchedulingTicket model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($schedulingId)
    {
        $model = new MsupSchedulingTicket();
        $userModel = new MsupUserMember;
        $memberInfoModel = new MsupMemberInfo;
        $ticketsModel = new MsupSchedulingTickets;
        $tickets = $ticketsModel->getTicketsBySchedulingId($schedulingId);

        // 检查该手机号是否已经注册，并为要保存的信息自动设置购买者和拥有者
        if ($userModel->load(Yii::$app->request->post()) && $model->load(Yii::$app->request->post()) && $model->saveOwnerInfo() ) {
            // 根据票的拥有者得到用户信息
            $model->bank = $model->createBank();
            $model->sid = $schedulingId;

            if ( $model->save() ) {
                
                return $this->redirect([ '/show-message/chose-message', 
                        'message' => '出票成功，票号为'.$model->bank.'，票号已经通过短信和邮箱发送给用户。点击立即跳转可查看您的出票信息', 
                        'okUrl' => Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $schedulingId]),
                        'cancelUrl' =>  Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-ticket/index', 'schedulingId' => $schedulingId])
                    ]);
            } else if($model->id && $res['error'] !=0 ) {

            }
            // return $this->redirect(['view', 'id' => $model->id]);

        } else {
            $schedulingModel = new \backend\models\MsupScheduling;

            $scheduling = $schedulingModel->find()->where(['id' => $schedulingId])->one();
            $model->linkUrl = $scheduling->getLinkUrl();

            return $this->render('create', [
                'model' => $model,
                'userModel' => $userModel,
                'memberInfoModel' => $memberInfoModel,
                'tickets' => $tickets,
            ]);
        }
    }


    /**
     * Updates an existing MsupSchedulingTicket model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
     public function actionUpdate($schedulingId)
    {
        $model = new MsupSchedulingTicket();
        $userModel = new MsupUserMember;
        $memberInfoModel = new MsupMemberInfo;
        $ticketsModel = new MsupSchedulingTickets;
        $tickets = $ticketsModel->getTicketsBySchedulingId($schedulingId);

        if ($userModel->load(Yii::$app->request->post())) {
            $row = $userModel->find()->where(['phone' => $userModel->phone])->one();
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'userModel' => $userModel,
                'memberInfoModel' => $memberInfoModel,
                'tickets' => $tickets,
            ]);
        }
    }
    /**
     * 更新门票拥有者的信息
     * @return [type] [description]
     */
    public function actionUpdateOwnerInfo($bank){
        $model = new MsupSchedulingTicket;
        $owner = $model->findOne(['bank' => $bank]);
        if (!$owner->id) {
            return json_encode(['errmsg' => '该门票不存在', 'errno' => 2]);
        } 
        $returnInfo = $owner->updateOwnerInfo(Yii::$app->request->post()['data']);
        if (!$owner->owner) {
            $owner->owner = $owner->purchase = $returnInfo['userId'];
            $owner->update();
        }
        echo json_encode($returnInfo);
    }
    /**
     * Deletes an existing MsupSchedulingTicket model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    /**
     * Finds the MsupSchedulingTicket model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupSchedulingTicket the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupSchedulingTicket::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
