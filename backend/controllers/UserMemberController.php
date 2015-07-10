<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupUserMember;
use backend\models\MsupUserMemberSearch;
use dektrium\user\controllers\AdminController;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * UserMemberController implements the CRUD actions for MsupUserMember model.
 */
class UserMemberController extends AdminController
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
     * Lists all MsupUserMember models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsupUserMemberSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupUserMember model.
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
     * Creates a new MsupUserMember model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupUserMember();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsupUserMember model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing MsupUserMember model.
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
     * 通过手机获取会员的详细信息
     * @param  [type] $phone [description]
     * @return [type]        [description]
     */
    public function actionGetMemberFullInfoByPhoneWithAjax($phone){
        $model = new MsupUserMember;
        $row = $model->getMemeberFullInfo(['phone' => $phone]);
        echo json_encode($row);
    }
    
    /**
     * 通过邮箱获取会员的详细信息
     * @param  [type] $phone [description]
     * @return [type]        [description]
     */
    public function actionGetMemberFullInfoByEmailWithAjax($email){
        $model = new MsupUserMember;
        $row = $model->getMemeberFullInfo(['email' => $email]);
        echo json_encode($row);
    }

    /**
     * Finds the MsupUserMember model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupUserMember the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupUserMember::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
