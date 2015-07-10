<?php

namespace backend\modules\Ticket\controllers;

use Yii;
use backend\modules\Ticket\models\MsupSchedulingTickets;
use backend\modules\Ticket\models\MsupSchedulingTicketsSearch;
use backend\modules\Ticket\models\MsupTickets;
use backend\controllers\CommonController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


/**
 * 票的种类与排课的关联控制器
 * SchedulingTicketsController implements the CRUD actions for MsupSchedulingTickets model.
 */
class SchedulingTicketsController extends CommonController
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
     * Lists all MsupSchedulingTickets models.
     * @return mixed
     */
    public function actionIndex($schedulingId)
    {
        $searchModel = new MsupSchedulingTicketsSearch();
        $params = Yii::$app->request->queryParams;
        $params[$searchModel->getClassName()]['sid'] =  $schedulingId;
        $dataProvider = $searchModel->search($params);
        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupSchedulingTickets model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new MsupSchedulingTickets model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($schedulingId)
    {
        $ticketsModel = new MsupTickets;
        $model = new MsupSchedulingTickets();

        if ($ticketsModel->load(Yii::$app->request->post()) && $ticketsModel->save()) {
            $model->load(Yii::$app->request->post());
            $model->sid = $schedulingId;
            $model->tid = $ticketsModel->id;
            if ($model->save()) {
                return $this->redirect(['index', 'schedulingId' => $schedulingId]);
            }
        } else {

            return $this->render('create', [
                'model' => $model,
                'ticketsModel' => $ticketsModel,
            ]);
        }
    }

    /**
     * Updates an existing MsupSchedulingTickets model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    { 

        $ticketsModel = new MsupTickets;
        $model = $this->findModel($id);
        $ticketsModel = $ticketsModel->findOne($model->tid);
        if ($ticketsModel->load(Yii::$app->request->post()) && $ticketsModel->save()) {
            $model->load(Yii::$app->request->post());
            $model->sid = $schedulingId;
            $model->tid = $ticketsModel->id;
            if ($model->save()) {
                return $this->redirect(['index', 'schedulingId' => $schedulingId]);
            }
        } else {
            return $this->render('update', [
                'model' => $model,
                'ticketsModel' => $ticketsModel,
            ]);
        }
    }

    /**
     * Deletes an existing MsupSchedulingTickets model.
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
     * Finds the MsupSchedulingTickets model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupSchedulingTickets the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupSchedulingTickets::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
