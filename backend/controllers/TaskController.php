<?php
namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use common\models\LoginForm;
use yii\filters\VerbFilter;
use backend\models\Task;
use yii\data\Pagination;
use yii\grid\GridView;
use backend\models\Taskrecord;
use backend\models\MsupLecturer;
use backend\models\MsupAddress;
use backend\models\MsupDirectory;

/**
 * 任务管理
 */
class TaskController extends CommonController
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
        $search = $_GET['search'];
        
        $TaskModel = new Task();
        
        $data = $TaskModel::find()->andWhere(['userid' => UID]);
        
        //搜索查询
        if(!empty($search)){
            $data = $data->andWhere('`taskname` like "%'.$search.'%"');
        }
        
        $count = $data->count();
        $pages = new Pagination(['totalCount' =>$count, 'pageSize' => '20']);
        $list = $data->offset($pages->offset)->orderBy(array('taskid'=>SORT_DESC))->limit($pages->limit)->asArray()->all();
//         echo '<pre>';
//         print_r($list);
//         exit;
        
        $data = array(
            'list' => $list,
            'pages' => $pages,
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
        $taskid = intval($_GET['taskid']);
        
        $TaskModel = new Task();
        
        //如果taskid大于0就是编辑，否则是新增
        if($taskid > 0){
            
            
            $info = $TaskModel::find()->andWhere(['taskid' => $taskid])->asArray()->one();
            
            //搜索查询
            if(!empty($info)){
            
            }
        }else{
            $info = array();
        }
    
        
        $data = array(
            'info' => $info,
            'TaskModel'=>$TaskModel
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
        $taskid = intval($_POST['taskid']);
        
        
        
//         $this->printr($TaskModel->load(Yii::$app->request->post(),''));
        
        if($taskid > 0){
            
            $TaskModel = new Task();
            $TaskModel->setOldAttribute('taskid', $taskid);
            if($TaskModel->load(Yii::$app->request->post(),'') && $TaskModel->save()){
                $this->json(array('status'=>'1','jumpurl'=>Yii::$app->urlManager->createAbsoluteUrl(['task/index'])));
            }else {
                $this->json(array('status'=>'0','errmsg'=>'更新错误'));
            }
                
        }else{
            
            $TaskModel = new Task();
            
            $TaskModel->setAttribute('time', time());
            $TaskModel->setAttribute('userid', UID);
            
            if($TaskModel->load(Yii::$app->request->post(),'')  && $TaskModel->save())
            {
//                 $this->printr($TaskModel->getAttributes());
                $this->json(array('status'=>'1','jumpurl'=>Yii::$app->urlManager->createAbsoluteUrl(['task/index'])));
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
        //需要删除的taskid
        $taskid = intval($_GET['taskid']);
        
        $TaskModel = new Task();
        
        //如果taskid大于0就是编辑，否则是新增
        if($taskid > 0){
        
        
            $res = $TaskModel->deleteAll(['taskid'=>$taskid]);
        
            //搜索查询
            if($res > 0){
                $this->redirect('index');
            }else{
                
            }
        }
        
        
        $this->redirect('index');
        
    }
    
    /**
     * 打印
     */
    public function actionPrint(){
        
        $this->layout = 'print';
        
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
        
        $list = $data->orderBy(array('recordid'=>SORT_DESC))->leftJoin('`'.MsupLecturer::tableName().'` l ','l.id = `'.Taskrecord::tableName().'`.lecturer_id ')->leftJoin('`'.MsupAddress::tableName().'` a ','a.lecturer_id = l.id AND a.status = 1')->leftJoin('`'.MsupDirectory::tableName().'` d ','d.lecturer_id = l.id AND d.status = 1')->asArray()->select([Taskrecord::tableName().'.*','l.id as lecturerid','l.company as lecturercompany','l.name as lecturername','a.address as lectureraddress','a.detail as lecturerdetail','d.phone as lecturerphone'])->all();
        
        foreach ($list as &$v){
            $address = explode(' ', $v['lectureraddress']);
            if (count($address) == 2){
                array_unshift($address,'');
            }
            
            $v['lectureraddress'] = $address;
        }
        
        
        
        
        //获取教练信息
        //         echo '<pre>';
        //         print_r($list);
        //         exit;
        
        //获取任务信息
        $TaskModel = new Task();
        
        $task = $TaskModel::find()->andWhere(['taskid' => $taskid])->asArray()->select(['taskid','taskname'])->one();
        
//         $this->printr($list);
        
        $data = array(
            'list' => $list,
            'task' => $task,
            'pages' => $pages,
            'taskid' => $taskid,
        );
        return $this->render('print',$data);
        
    }

   
}
