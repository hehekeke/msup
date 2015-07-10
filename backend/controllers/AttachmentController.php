<?php
/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
namespace backend\controllers;

use Yii;
use backend\models\MsupAttachment;
use backend\components\GlobalFunc;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * AttachmentController implements the CRUD actions for MsupAttachment model.
 */
class AttachmentController extends Controller
{

    public $enableCsrfValidation = false;

    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                    'createByajax' => ['post'],
                ],
            ],
        ];
    }

    /**
     * Lists all MsupAttachment models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => MsupAttachment::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single MsupAttachment model.
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
     * Creates a new MsupAttachment model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupAttachment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsupAttachment model.
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
     * Deletes an existing MsupAttachment model.
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
     * 移除掉某一记录中的一个文件
     * @param  [integer] $id [记录ID]
     * @param  [string]  $f  [文件名]
     * @return [type]     [description]
     */
    public function actionRemove($id, $f) {

        $row = $this->findModel($id);
        $files = GlobalFunc::uploadFormat( $row->attachment );
        foreach ( $files as $k =>$v) {

            if ($v['fileName'] ==  $f) {

                unset($files[$k]);
            }
        }

        $row->attachment = GlobalFunc::uploadFormat($files);
        $row->update();
        if (Yii::$app->request->get('ajax')) {

            echo json_encode(['error_code' => 1]);
            die();
        }

        $this->redirect(['index']);
    }
    public function actionUpload()
    {
        error_reporting(E_ALL | E_STRICT);
        $upload_handler = new \components\UploadHandler();
    }

    /**
     * 上传组件显示页面
     * @param  string $value [description]
     * @return [type]        [description]
     */
    public function actionUploadPluginView($value='')
    {
        $this->layout = 'blank';
        return $this->render('jqueryuploadpluginview');
    }


    // 由Post传值
    public function actionCreateByAjax($modelId, $modelPk = null, $field, $hash = null)
    {
        if (!Yii::$app->request->post()['attachment']) return false;

        $model = new MsupAttachment;

        if ( $modelPk) {

            $model->modelPk = $modelPk;
            $where = ['modelPk' => $modelPk];

        } else {
            $model->hash = $hash;
            $where = ['hash' => $hash];
        }

        $model->status = 1;
        $field = isset(Yii::$app->request->post()['field']) ? Yii::$app->request->post()['field'] : $field;
        $model->modelId = $modelId;
        $attachment = Yii::$app->request->post()['attachment'];
        $model->attachment = $attachment;
        $model->field = $field;
        $row = $model->find()->where($where)->andWhere(['modelId' => $modelId, 'field' => $field])->one();

        //有则更新该记录，无则新增
        if ($row->id ) {
            $row->attachment = $attachment; 
            $row->update();
            echo 1;
        } else if ( $model->save() ) {
            echo 1;
        } else { 
            echo 0;
        }

    }
    /**
     * Finds the MsupAttachment model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupAttachment the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupAttachment::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
