<?php

namespace backend\controllers;

use Yii;
use backend\models\MsupScheduling;
use backend\models\MsupSchedulingSearch;
use backend\models\MsupSchedulingVenueCourse;
use backend\controllers\CommonController;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\ArrayHelper;

/**
 * SchedulingController implements the CRUD actions for MsupScheduling model.
 */
class SchedulingController extends CommonController
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
     * Lists all MsupScheduling models.
     * @return mixed
     */
    public function actionIndex($create_admin = null)
    {
        $searchModel = new MsupSchedulingSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    // 个人上传的排课信息
    public function actionMy($create_admin = null) 
    {
        //先检查是否传入添加人没有就传入当前用户
        $create_admin = empty($create_admin) ? empty(Yii::$app->request->get('create_admin')) ? Yii::$app->user->identity->id : Yii::$app->request->get('create_admin') : $create_admin;

        $this->redirect(['index', 'create_admin' => Yii::$app->user->identity->Id]);
    }
    /**
     * Displays a single MsupScheduling model.
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
     * Creates a new MsupScheduling model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupScheduling();
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['index', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Updates an existing MsupScheduling model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {

            $_POST['hash'] = $id;
            return $this->redirect([ 'show-message/chose-message', 
                    'message' => '排课添加成功，您可以跳转到门票种类管理界面添加门票信息', 
                    'okUrl' => Yii::$app->urlManager->createAbsoluteUrl(['Ticket/scheduling-tickets/create', 'schedulingId' => $model->id]),
                    'cancelUrl' =>  Yii::$app->urlManager->createAbsoluteUrl(['scheduling/index', 'schedulingId' => $model->id])
                ]);
            // return $this->redirect(['index', 'id' => $model->id]);
        } else {

            // 根据日期显示分会场和课程并按开始时间顺排
            $venues = $model->getSchedulingVenue()->asArray()->all();
            $venueCourses = $model->getSchedulingVenueCourses()->orderBy(' date asc, startTime asc')->asArray()->all();

            //缓存数组 以日期为健名重组数组
            $venueCoursesTemp = []; 
            foreach ($venueCourses as $key => $value) {
                if ( !array_key_exists($value['date'], $venueCoursesTemp) ){
                    $venueCoursesTemp[$value['date']] = '';
                }
                     $venueCoursesTemp[$value['date']][] = $value;

            }

            $venueCourses = $venueCoursesTemp;
            unset($venueCoursesTemp);

            return $this->render('update', [
                'model' => $model,
                'venues' => $venues,
                'venueCourses' => $venueCourses,
            ]);
        }
    }

    /**
     * Deletes an existing MsupScheduling model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionCourses($id)
    {
        $scheduling = $this->findModel($id);
        $schedulingCourseModel = new MsupSchedulingVenueCourse;
        $courses = $scheduling->getSchedulingVenueCourse()->asArray()->all();
        $courseIds = implode(',',ArrayHelper::map($courses,'id', 'courseid'));
        $courseModel = new \backend\models\MsupCourse;
        $searchModel = new \backend\models\MsupCourseSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
        if ($courseIds) { 
            $dataProvider->query->andWhere('courseid in ('.$courseIds.')');
            return $this->render('courses', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
                'schedulingTitle' => $scheduling->title,
            ]);
        } else {
            $tips = "该排课暂时没有课程，请联系相关工作人员进行添加";
            return $this->render('courses',[
                'tips' => $tips,
                'schedulingTitle' => $scheduling->title,
                ]);
        }
        
    }
    
    public function actionFeedback($id){
        $scheduling = $this->findModel($id);
        $searchModel = new \backend\models\MsupSchedulingVenueCourseSearch;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        $dataProvider->query->with('course', 'feedback')->where(['sid' => $id])->orderBy('date asc, startTime asc');
        return $this->render('feedback', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
            'schedulingTitle' => $scheduling->title,
        ]);
    }
    
    //统计课程反馈情况
    public function actionFeedbackCount($id) {
        $scheduling = $this->findModel($id);
        $venueCourseModel = new MsupSchedulingVenueCourse;
        $schedulingFeedback = $venueCourseModel->find()->with('feedback', 'course')->where(['sid' => $id])->orderBy('date asc, startTime asc')->asArray()->all();
        // 需要同统计的题目字段名
        $questionFieldNames = ['q2', 'q3', 'q4', 'q5', 'q6'];
        $allCount = [];

        // 
        foreach($schedulingFeedback as $key => $courseFeedback) {
            // 获取问题1的平均分数
            //  打分人数
            $rank =  ArrayHelper:: getColumn($courseFeedback['feedback'], 'q1');
            $rankNum = count($rank);
            $rankSum = array_sum($rank);
            $rank = ($rankNum && $rankNum)? round($rankSum/$rankNum) :0;
            $count = [];
            $count['title'] = $courseFeedback['course']['title'];
            $count['rank'] = $rank;
            // 计算每道题的总回答人数和每个选项的人数
            foreach($questionFieldNames as $k => $v) {
                $questionFeedbacks = ArrayHelper::getColumn($courseFeedback['feedback'], $v);
                if (!$count[$v]['count']) {
                    $count[$v]['count'] = count($questionFeedbacks);
                }
                foreach($questionFeedbacks as $type) {
                    if ($type) $count[$v][$type] +=1;
                }
            }
            $allCount[$courseFeedback['id']] = $count;
        }
        return $this->render( 'feedback-count',
                             [ 'allCount' => $allCount ]
                );
    }

    /**
     * Finds the MsupScheduling model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupScheduling the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = MsupScheduling::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
 