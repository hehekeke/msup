<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupCourse;
use backend\models\MsupCourseUsedtime;
use backend\models\MsupTags;
use backend\models\MsupCourseSearch;
use backend\models\MsupReview;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Json;
/**
 * CourseController implements the CRUD actions for MsupCourse model.
 */
class CourseController extends CommonController
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
     * 课程列表
     * @param $create_admin int 添加人的ID
     * @return mixed
     */
    public function actionIndex($create_admin = null)
    {
        $searchModel = new MsupCourseSearch;
        $params = Yii::$app->request->queryParams;
        $title = Yii::t('app', '课程管理');

        // 如果有传入添加人ID，则只显示该添加人ID
        if ($create_admin) { 
            $title = Yii::t('app', '我上传的课程');
            $params[$searchModel->formName()]['create_admin'] = $create_admin;
        }
        $courseUsedtime = MsupCourseUsedtime::find()->asArray()->all();
        $courseUsedtimeFilter = ArrayHelper::map($courseUsedtime,'usedtimeid', 'title');
        $dataProvider = $searchModel->search($params);
        if(!Yii::$app->request->get('sort')) {
            $dataProvider->query->orderBy('courseid desc');
        }      
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'title' => $title,
            'courseUsedtimeFilter' => $courseUsedtimeFilter
        ]);
    }

    public function actionMy()
    {
        if (!Yii::$app->user->identity->id) {
            throw new BadRequestHttpException('请登录');
        }
        //先检查是否传入添加人没有就传入当前用户
        $create_admin = empty($create_admin) ? empty(Yii::$app->request->get('create_admin')) ? Yii::$app->user->identity->id : Yii::$app->request->get('create_admin') : $create_admin;

        $this->redirect(['index', 'create_admin' => $create_admin]);
    }
    
    /**
     * Displays a single MsupCourse model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);

        $model->lecturer_id = $model->lecturer->name;
        $model->usedtimeid = $model->courseUsedtime->hour.'小时';
        $globalFunc = new \backend\components\GlobalFunc();
        $model->file = $globalFunc->uploadFormat($model->file);
        // 培训内容Json格式
        // $model->training = json_decode($model->training, true);

        $attachment = new \backend\models\MsupAttachment;
        $html = '<div class="renderFile row nm">';
        // 将File字段格式化成HTml后输出
        foreach ( (array)$model->file as $key => $v) {

             if (!empty($v)) {
                $html .= '<div class="col-xs-6 col-md-3">';
                $html .= '<li href="'.$v['fileUrl'].'" class="thumbnail">';
                // 格式化文件的图片显示
                $html .= $attachment->showFileByImg($v['fileUrl']);
                $html .= '<a href="'.$v['fileUrl'].'" ><p class="np nm">'.$v['fileName'].'</p></a></li>';
                $html .= '</div>';
            }

        }
        $html .= "</div>";
        $model->file = $html;

        return $this->redirect('index');

    }

    /**
     * Creates a new MsupCourse model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupCourse();
        $msupcourseusedtime = new MsupCourseUsedtime();
        if ($model->load(Yii::$app->request->post())) {
            if ($this->isUseReview && $reviewModel->addReview($model->name, $model->getModelId(), Yii::$app->request->post())) {
                header('Content-type:text/html;charset=utf8');
                echo "<script>alert('添加成功，请等待审核完成');window.history.go(-2);</script>";
                exit;
            } else if ($model->save()) {
                return $this->redirect('my');
            } else {
                 echo "<script>alert('您发送的表单请求有误')</script>";
            }
            
        } else {
            $model->usedtimeid = 5;

            $courseusedtime = ArrayHelper::map($msupcourseusedtime::find()->asArray()->all(), 'usedtimeid', 'title');
            return $this->render('create', [
                'model' => $model,
                'courseusedtime' => $courseusedtime,
                'coursetag' => $tags,
            ]);
        }
    }

    /**
     * Updates an existing MsupCourse model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect('my');
        } else {

            // 获取课程时长列表
            $msupcourseusedtime = new MsupCourseUsedtime();
            $courseusedtime = $msupcourseusedtime::find()->where('usedtimeid > 1')->all();
            $courseusedtime = ArrayHelper::map($courseusedtime, 'usedtimeid', 'title');
            // p(json_decode(stripslashes($model->training), true));

            // p(json_decode($model->training, true));
            // 格式化培训内容
            $model->training = json_decode(stripslashes($model->training), true);
            $model->training = $model->training['training'];
            $model->priceDesc = json_decode(stripslashes($model->priceDesc), true);
            
            $model->priceDesc = $model->priceDesc['priceDesc'];

            return $this->render('update', [
                'model' => $model,
                'courseusedtime' => $courseusedtime,
                'coursetag' => $tags,
            ]);
        }
    }

    /**
     * Deletes an existing MsupCourse model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }


    // 按标题搜索课程
    public function actionSearchByTitle() {

        $model = new MsupCourse;
        $_GET['data'] = str_replace("'", "", $_GET['data']);
        $row = $model->find()->with('courseUsedtime')->where("title like '%$_GET[data]%'")->asArray()->all();

        if (!empty($row)) {
            $html = '<table class="table table-striped table-bordered nmb"><thead><tr><th>课程序号</th><th>课程标题</th><th>主办方</th><th>教练</th><th>课程时长</th><th>课程价格</th><th></th></tr></thead><tbody>';

        }

        foreach ($row as $key => $value) {
            $html .= '<tr data-key="'.$value['courseid'].'">';
            $html .= '<td>'.$value['courseid'].'</td>';
            $html .= '<td>'.$value['title'].'</td>';
            $html .= '<td>'.$value['sponsor'].'</td>';
            $html .= '<td>'.$value['lecturer_id'].'</td>';
            $html .= '<td>'.$value['courseUsedtime']['hour'].'<input type="hidden" class="courseHour" value=""></td>';
            $html .= '<td>'.$value['price'].'</td>';
            $html .='<td><a class="doChoseCourse btn btn-xs btn-primary" hour="'.$value['courseUsedtime']['hour'].'">选择此课程</a></td></tr>';
        }

        $row['onwerHtml'] = $html;
        echo json_encode($row);
    }
    /**
     * Finds the MsupCourse model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupCourse the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = MsupCourse::find()->with('courseLecturer')->with('courseUsedtime')->where([MsupCourse::primaryKey()[0] => $id])->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
    
    
}
