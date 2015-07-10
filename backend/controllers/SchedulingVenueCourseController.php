<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupSchedulingVenueCourse;
use backend\models\MsupSchedulingVenueCourseSearch;
use backend\models\MsupSchedulingVenue;
use backend\models\MsupCourse;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\data\ActiveDataProvider;
/**
 * SchedulingVenueCourseController implements the CRUD actions for MsupSchedulingVenueCourse model.
 */
class SchedulingVenueCourseController extends Controller
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
     * Lists all MsupSchedulingVenueCourse models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsupSchedulingVenueCourseSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupSchedulingVenueCourse model.
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
     * Creates a new MsupSchedulingVenueCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupSchedulingVenueCourse();

        if ( $model->load(Yii::$app->request->post())) {

            $model->save();

            echo json_encode(['id' => $model->id]);
            // return $this->redirect(['view', 'id' => $model->id]);
        } else {

            $venues  = new MsupSchedulingVenue; 
            if (!Yii::$app->request->get('s')) throw new NotFoundHttpException("错误的请求");
            $condition[Yii::$app->request->get('k')] = Yii::$app->request->get('s');
            $row = $venues->find()->where($condition)->asArray()->all();
            $row = ArrayHelper::map($row, 'id', 'venueName');
            return $this->render('create', [
                'model' => $model,
                'row'   => $row,
                'venues'   => $venues,
            ]);
        }
    }

    /**
     * Updates an existing MsupSchedulingVenueCourse model.
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
                'row' => $row
            ]);
        }
    }


    public function actionChoseCourse()
    {

        $dataProvider = new ActiveDataProvider([
            'query' => MsupCourse::find()->with('lecturer','courseUsedtime'),
        ]);

        return $this->render('choseCourse', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Deletes an existing MsupSchedulingVenueCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();
        if (Yii::$app->request->get('ajax')) {
            echo json_encode( [ 'error_code' => 1 ] );
            die();
        }
        return $this->redirect(['index']);
    }

    /**
     * Finds the MsupSchedulingVenueCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupSchedulingVenueCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupSchedulingVenueCourse::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
