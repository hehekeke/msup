<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupReview;
use backend\models\MsupReviewSearch;
use backend\models\MsupHistory;
use yii\web\Controller;

use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ReviewController implements the CRUD actions for MsupReview model.
 */
class ReviewController extends Controller
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
     * Lists all MsupReview models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsupReviewSearch();
        $params = Yii::$app->request->queryParams;
        $params["MsupReviewSearch"]['status'] = 1;

        // Yii::$app->request->queryParams[MsupReviewSearch['status']] = 1;

        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupReview model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = MsupReview::getModel($id);
        
        $controllerName = $model->getControllerName();
        

        return $this->render('../'.$controllerName.'/view', [
            'model' => $model,
        ]);

    }


    /**
     * Creates a new MsupReview model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupReview();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            throw new  NotFoundHttpException("请求的链接不存在");
            
        }
    }



    /**
     * Updates an existing MsupReview model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id,$status)
    {
        $reviewModel = $this->findModel($id);

        $model = $reviewModel->getModel($id);
        $reviewModel->status = $status;
        $pk = $model->primaryKey();
        $pk = $pk[0];

        // 将数据保存到对应的model中
        if ($status == 2) {
            $reviewModel->commit = Yii::$app->security->generateRandomString(15);
            // 添加到历史版本库中
            if ( $model->save() && $reviewModel->save() ) {

                // 获取主键的值，查询是否有记录
                $pkValue = $model->$pk;
                $history = new \backend\models\MsupHistory;
                $history->fieldName = $pk;
                $history->fieldValue = $pkValue;
                $history->commit = $reviewModel->commit;

                if ($history->save()) {
                    echo '<div class="alert alert-success" role="alert">审核成功</div>';
                }
            }
        } else if ($status == 3) {

            if ($reviewModel->updateAll(['status' => -1], 'id='.$reviewModel->id)) {
                echo '<div class="alert alert-success" role="alert">审核成功</div>';
            }
            
        }



        // if ($reviewModel->load(Yii::$app->request->post()) && $reviewModel->save()) {
        //     return $this->redirect(['view', 'id' => $model->id]);
        // } else {
        //     return $this->render('update', [
        //         'model' => $model,
        //     ]);
        // }
    }

    public function actionHistory() {
        $query = MsupReview::findBySql("SELECT * FROM (SELECT * FROM ".MsupReview::tableName()." ORDER BY id DESC) AS review  GROUP BY review.model, review.title ORDER BY review.id DESC");

        $dataProvider = (new \yii\data\ActiveDataProvider(['query'=>$query]));

        return $this->render('history', [
            'dataProvider' => $dataProvider,
        ]);
    }
    /**
     * Deletes an existing MsupReview model.
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
     * Finds the MsupReview model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupReview the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupReview::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }



}
