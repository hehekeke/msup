<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\Taskrecord;
use yii\data\Pagination;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use backend\models\MsupLecturer;
use backend\models\Task;
use backend\components\GlobalFunc;
/**
 * 任务详情管理
 */
class TaskrecordController extends CommonController
{
    /**
     * @inheritdoc
     */
    // public function behaviors()
    // {
    //     return [
    //         'access' => [
    //             'class' => AccessControl::className(),
    //             'rules' => [
    //                 [
    //                     'actions' => ['login', 'error'],
    //                     'allow' => true,
    //                 ],
    //                 [
    //                     'actions' => ['logout', 'index'],
    //                     'allow' => true,
    //                     'roles' => ['@'],
    //                 ],
    //             ],
    //         ],
    //         'verbs' => [
    //             'class' => VerbFilter::className(),
    //             'actions' => [
    //                 'logout' => ['post'],
    //             ],
    //         ],
    //     ];
    // }


    /**
     * 显示任务列表信息
     * @return string
     */
    public function actionIndex()
    {
//         new GridView();
        //查询条件 
        $map = array();
//         $search = $_GET['search'];
        $taskid = intval($_GET['taskid']);
        
        $TaskrecordModel = new Taskrecord();
        
        $data = $TaskrecordModel::find()->andWhere(['taskid' => $taskid]);
        
        //搜索查询
//         if(!empty($search)){
// //             $data = $data->andWhere('`Taskrecordname` like "%'.$search.'%"');
//         }
        
        $count = $data->count();
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' => '20']);
        $list = $data->offset($pages->offset)->orderBy(array('recordid'=>SORT_DESC))->limit($pages->limit)->leftJoin('`'.MsupLecturer::tableName().'` l ','l.id = lecturer_id')->asArray()->select([Taskrecord::tableName().'.*','l.id as lecturerid','l.name as lecturername'])->all();
        
        //获取教练信息
//         echo '<pre>';
//         print_r($list);
//         exit;

        //获取任务信息
        $TaskModel = new Task();
        
        $task = $TaskModel::find()->andWhere(['taskid' => $taskid])->asArray()->select(['taskid','taskname'])->one();
        
        
        $data = array(
            'list' => $list,
            'task' => $task,
            'pages' => $pages,
            'taskid' => $taskid,
        );
        return $this->render('index',$data);
    }
    
    /**
     * 编辑任务信息
     * @return string
     */
    public function actionEdit()
    {
        //查询条件
        $map = array();
        $recordid = intval($_GET['recordid']);
        $taskid = intval($_GET['taskid']);
        
        $TaskrecordModel = new Taskrecord();
        
        //如果Taskrecordid大于0就是编辑，否则是新增
        if($recordid > 0){
            
            
            $info = $TaskrecordModel::find()->andWhere(['recordid' => $recordid])->asArray()->one();
            
            //获取任务信息
            $TaskModel = new Task();
            
            $task = $TaskModel::find()->andWhere(['taskid' => $info['taskid']])->asArray()->select(['taskid','taskname'])->one();
            
            $info['task'] = $task;
            
        }else{
            $info = array(
                'taskid'=>$taskid
            );
            
            //获取任务信息
            $TaskModel = new Task();
            
            $task = $TaskModel::find()->andWhere(['taskid' => $taskid])->asArray()->select(['taskid','taskname'])->one();
            
            $info['task'] = $task;
            
        }
    
        
        $data = array(
            'info' => $info,
            'TaskrecordModel'=>$TaskrecordModel
        );
        
        
//         $this->
        
        return $this->render('edit',$data);
    }
    
    /**
     * 保存任务信息
     * @return string
     */
    public function actionEditdo()
    {
        //查询条件
        $recordid = intval($_POST['recordid']);
        $taskid = intval($_POST['taskid']);
        
        
        
//         $this->printr($TaskrecordModel->load(Yii::$app->request->post(),''));
        
        if($recordid > 0){
            
            $TaskrecordModel = new Taskrecord();
            $TaskrecordModel->setOldAttribute('recordid', $recordid);
            if($TaskrecordModel->load(Yii::$app->request->post(),'') && $TaskrecordModel->save()){
                $this->json(array('status'=>'1','jumpurl'=>Yii::$app->urlManager->createAbsoluteUrl(['taskrecord/index','taskid'=>$taskid])));
            }else {
                $this->json(array('status'=>'0','errmsg'=>'更新错误'));
            }
                
        }else{
            
            $TaskrecordModel = new Taskrecord();
            
            $TaskrecordModel->setAttribute('time', time());
            
            if($TaskrecordModel->load(Yii::$app->request->post(),'')  && $TaskrecordModel->save())
            {
//                 $this->printr($TaskrecordModel->getAttributes());
                $this->json(array('status'=>'1','jumpurl'=>Yii::$app->urlManager->createAbsoluteUrl(['taskrecord/index','taskid'=>$taskid])));
            }
            else
            {
                $this->json(array('status'=>'0','errmsg'=>'添加错误'));
            }
            
        }
        
        $this->json(array('status'=>'0','errmsg'=>'信息错误'));
        
        
        
    
    
//         $data = array(
//             'info' => $info,
//         );
    
//         //         $this->
    
//         return $this->render('edit',$data);
    }
    
    /**
     * 删除一条记录信息
     */
    public function actionDel(){
        //需要删除的Taskrecordid
        $recordid = intval($_GET['recordid']);
        
        $TaskrecordModel = new Taskrecord();
        
        //如果Taskrecordid大于0就是编辑，否则是新增
        if($recordid > 0){
        
        
            $res = $TaskrecordModel->deleteAll(['recordid'=>$recordid]);
        
            //搜索查询
            if($res > 0){
                $this->redirect(['index','taskid'=>intval($_GET['taskid'])]);
            }else{
                
            }
        }
        
        
        $this->redirect(['index','taskid'=>intval($_GET['taskid'])]);
        
    }
    
    /**
     * 管理的教练列表
     * @return string
     */
    public function actionRelationteacher()
    {
        
        $this->layout = 'relation';
        
        //查询条件
        $map = array();
        $search = $_GET['q'];
        $lecturer_id = intval($_GET['lecturer_id']);
    
        $MsupLecturerModel = new MsupLecturer();
    
        $data = $MsupLecturerModel::find();
    
        //搜索查询
        if(!empty($search)){
            $data = $data->andWhere('`name` like "%'.$search.'%"');
        }
    
        $count = $data->count();
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' => '20']);
        $list = $data->offset($pages->offset)->orderBy(array('id'=>SORT_DESC))->limit($pages->limit)->asArray()->all();
        // 处理讲师的缩略图
        $list = $this->unFormatThumbs($list);

        $data = array(
            'list' => $list,
            'pages' => $pages,
            'lecturer_id' => $lecturer_id,
            'roleTags' => $this->getRoleTags(),
        );
        return $this->render('relationapp',$data);
    }

    private function getRoleTags(){
        $tagModel = new \backend\models\MsupTags;
        $tags = $tagModel->getTagsWidthCate(5);
        return ArrayHelper::map($tags[0]['tags'], 'id', 'tagName');
    }
    private function unFormatThumbs($lists){
        array_walk($lists, function(&$row){
            $row['thumbs'] = GlobalFunc::uploadFormat($row['thumbs']);
            if (!empty($row['thumbs'])) {
                $row['thumbs'] = $row['thumbs'][0]['thumbnailUrl'];
            }
        });
        return $lists;
    }
    /**
     * 按标签搜索教练
     * @param  [type] $roleId [description]
     * @return [type]         [description]
     */
    public function actionSelectLecturerByTag($tagId)
    {
        $this->layout = 'relation';
        $tagRelationModel = new \backend\models\MsupTagRelation;

        $lecturers = $tagRelationModel->find()->with('lecturer')->where(['tagId' => $tagId, 'modelId'=>1]);

        $count = $lecturers->count();
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' => '20']);
        $lecturers = $lecturers->offset($pages->offset)->orderBy('id desc')->limit($pages->limit)->asArray()->all();

        $lecturers = ArrayHelper::map($lecturers, 'id', 'lecturer');
        $lists = $this->unFormatThumbs($lecturers);
        $roleTags = $this->getRoleTags();
        return $this->render('relationapp', [
                'list' => $lists,
                'pages' => $pages,
                'lecturer_id' => $lecturer_id,
                'roleTags' => $this->getRoleTags(),
            ]);
    }

   
}
