<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupTags;
use backend\models\MsupTagsSearch;
use backend\models\MsupCategorys;
use backend\models\MsupCourse;
use backend\models\MsupLecturer;
use backend\models\MsupTagRelation;
use backend\controllers\CommonController;

use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * TagsController implements the CRUD actions for MsupTags model.
 */
class TagsController extends CommonController
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
     * Lists all MsupTags models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new MsupTagsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupTags model.
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
     * Creates a new MsupTags model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupTags();
        $cateModel = new MsupCategorys;
        $tagCates = $cateModel->categoryList();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index']);
        } else {
            if (Yii::$app->request->get('pid')) {
                $model->catid = Yii::$app->request->get('pid');
            }
            return $this->render('create', [
                'model' => $model,
                'tagCates' => $tagCates
            ]);
        }
    }

    /**
     * Updates an existing MsupTags model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $cateModel = new MsupCategorys;
        $tagCates = $cateModel->categoryList();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'tagCates' => $tagCates,
            ]);
        }
    }

    /**
     * Deletes an existing MsupTags model.
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
     * 自动为课程添加标签角色关联
     * @return [type] [description]
     */
    public function actionAutoRelationTagRoleOfCourse($catid = 5){
        $model = new MsupCourse;
        $this->autoRelationTag($model);
    }
    public function actionAutoRelationTagRoleOfLecturer(){
        $model = new MsupLecturer;
        $this->autoRelationTag($model);
    }
    /**
     * 自动关联标签
     * @return [type] [description]
     */
    public function autoRelationTag($model){
        $tagRelation = new MsupTagRelation;
        $tagRelation->autoRelationRoleTag($model);
    }   

    /**
     * Finds the MsupTags model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupTags the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupTags::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
