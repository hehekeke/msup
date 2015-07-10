<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupSchedulingVenue;
use backend\models\MsupSchedulingVenueSearch;
use backend\models\MsupSchedulingVenueCourse;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
/**
 * SchedulingVenueController implements the CRUD actions for MsupSchedulingVenue model.
 */
class SchedulingVenueController extends Controller
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
     * Lists all MsupSchedulingVenue models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsupSchedulingVenueSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupSchedulingVenue model.
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
     * Creates a new MsupSchedulingVenue model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupSchedulingVenue();


        if ( $model->load(Yii::$app->request->post()) && $model->save() ) {
            

            if (Yii::$app->request->get('ajax')) {
             
                $json = [ 'error_code' => 1, 'id' => $model->id];
                echo json_encode($json);
                die();
            } else {
                return $this->redirect(['view', 'id' => $model->id]);

            }


        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsupSchedulingVenue model.
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
     * Deletes an existing MsupSchedulingVenue model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {

        $this->findModel($id)->delete();
        
        if ( Yii::$app->request->get('ajax') ) {
                die(json_encode(['error_code'=>1]));
        }

        return $this->redirect(['index']);
    }


    /**
     * Finds the MsupSchedulingVenue model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupSchedulingVenue the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupSchedulingVenue::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
