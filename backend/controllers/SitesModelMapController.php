<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupSitesModelMap;
use backend\models\MsupSitesModelMapSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;
use backend\models\MsupModel;

/**
 * SitesModelMapController implements the CRUD actions for MsupSitesModelMap model.
 */
class SitesModelMapController extends Controller
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
     * Lists all MsupSitesModelMap models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsupSitesModelMapSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupSitesModelMap model.
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
     * Creates a new MsupSitesModelMap model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupSitesModelMap();


        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            

            $models = MsupModel::find()->asArray()->all();
            $models = ArrayHelper::map($models, 'id', 'modelName');
            // 获得所有模型
            return $this->render('create', [
                'model' => $model,
                'models' => $models,
            ]);
        }
    }

    /**
     * Updates an existing MsupSitesModelMap model.
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
            $models = MsupModel::find()->asArray()->all();
            $models = ArrayHelper::map($models, 'id', 'modelName');
            return $this->render('update', [
                'model' => $model,
                'models' => $models
            ]);
        }
    }

    /**
     * Deletes an existing MsupSitesModelMap model.
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
     * Finds the MsupSitesModelMap model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupSitesModelMap the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupSitesModelMap::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
