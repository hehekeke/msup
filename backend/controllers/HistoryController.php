<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupHistory;
use backend\models\MsupHistorySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\MsupReview;
use backend\models\MsupModel;
/**
 * HistoryController implements the CRUD actions for MsupHistory model.
 */
class HistoryController extends Controller
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
     * Lists all MsupHistory models.
     * @return mixed
     */
    public function actionIndex()
    {
        // $searchModel = new MsupHistorySearch();
        // $historyModel = new MsupHistory();
        // $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $query = MsupHistory::find()->orderBy("id DESC")->groupBy(['fieldName', 'fieldValue'])->with('review');

        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);


        return $this->render('index', [

            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * 显示单个记录和历史版本号
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $reviewModel = new MsupReview;
        $row   = $this->findModel($id);
        $review = $row->getReview()->one();

        if ( $review ) {

            // 历史版本
            $historys = $row->find()->where(["fieldName"=>$row->fieldName, "fieldValue"=>$row->fieldValue ])->orderBy("id desc")->with('review')->asArray()->all();

            $columns  =  [];

            $model        =  MsupModel::findOne(["id"=>$review->model]);
            $modelClass   =  $model->modelClass;
            $model = new $modelClass;
            $model->attributes = unserialize($review->data);

            foreach ($model->attributes as $key => $v){
                $columns[] = $key;
            }

            $reviewCommit = $review->commit;
            return $this->render('view', [
                'model' => $model,
                'historys' => $historys,
                'columns' => $columns,
                'reviewCommit' => $reviewCommit
            ]);
        } else {
            throw new  NotFoundHttpException("该版本记录不存在");
            // echo "该版本记录不存在";
        }

    }

    public function actionDetail($id){

        $reviewModel  = new MsupReview;
        $row          = $this->findModel($id);
        $review       = $row->getReview()->one();

        $model        =  MsupModel::findOne(["id"=>$review->model]);
        $modelClass   =  $model->modelClass;
        $model        = new $modelClass;
        $model->attributes = unserialize($review->data);

        return $this->renderPartial('../'.$model->getControllerName().'/view', ['iframe'=>1,'model'=>$model, 'hideButtons'=>1]);
    }

    /**
     * Creates a new MsupHistory model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupHistory();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsupHistory model.
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
     * Deletes an existing MsupHistory model.
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
     * Finds the MsupHistory model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupHistory the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupHistory::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
