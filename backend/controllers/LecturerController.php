<?php

namespace backend\controllers;

use Yii;

use \dektrium\user\models\User;

use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;

use backend\models\MsupLecturer;
use backend\models\MsupLecturerAssignment;
use backend\models\MsupReview;
use backend\models\MsupTags;
use backend\models\MsupLecturerSearch;

use backend\controllers\CommonController;
use backend\components\GlobalFunc;
/**
 * LecturerController implements the CRUD actions for MsupLecturer model.
 */
class LecturerController extends CommonController
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
     * 给没有笔名的教练自动设置笔名
     * @return [type] [description]
     */
    public function actionSetPenName(){
        $names =[
                    'Aaron','Abbott','Abel','Abner','Abraham','Adair','Adam','Addison','Adolph','Adonis','Adrian','Ahern','Alan','Albert','Aldrich','Alexander','Alfred','Alger','Algernon','Allen','Alston','Alva','Alvin','Alvis','Amos','Andre','Andrew','Andy','Angelo','Augus','Ansel','Antony','Antoine','Antonio','Archer','Archibald','Aries','Arlen','Armand','Armstrong','Arno','Arnold','Arthur','Arvin','Asa','Ashbur','Atwood','Aubrey','August','Augustine','Avery','Baird','Baldwin','Bancroft','Bard','Barlow','Barnett','Baron','Barret','Barry','Bartholomew','Bart','Barton','Bartley','Basil','Beacher','Beau','Beck','Ben','Benedict','Benjamin','Bennett','Benson','Berg','Berger','Bernard','Bernie','Bert','Berton','Bertram','Bevis','Bill','Bing','Bishop','Blair','Blake','Blithe','Bob','Booth','Borg','Boris','Bowen','Boyce','Boyd','Bradley','Brady','Brandon','Brian','Broderick','Brook','Bruce','Bruno','Buck','Burgess','Burke','Burnell','Burton','Byron','Caesar','Calvin','Carey','Carl','Carr','Carter','Cash','Cecil','Cedric','Chad','Channing','Chapman','Charles','Chasel','Chester','Christ','Christian','Christopher','Clare','Clarence','Clark','Claude','Clement','Cleveland','Cliff','Clifford','Clyde','Colbert','Colby','Colin','Conrad','Corey','Cornelius','Cornell','Craig','Curitis','Cyril','Dana','Daniel','Darcy','Darnell','Darren','Dave','David','Dean','Dempsey','Dennis','Derrick','Devin','Dick','Dominic','Don','Donahue','Donald','Douglas','Drew','Duke','Duncan','Dunn','Dwight','Dylan','Earl','Ed','Eden','Edgar','Edmund','Edison','Edward','Edwiin','Egbert','Eli','Elijah','Elliot','Ellis','Elmer','Elroy','Elton','Elvis','Emmanuel','Enoch','Eric','Ernest','Eugene','Evan','Everley','Fabian','Felix','Ferdinand','Fitch','Fitzgerald','Ford','Francis','Frank','Franklin','Frederic','Gabriel','Gale','Gary','Gavin','Gene','Geoffrey','Geoff','George','Gerald','Gilbert','Giles','Glenn','Goddard','Godfery','Gordon','Greg','Gregary','Griffith','Grover','Gustave','Guy','Hale','Haley','Hamiltion','Hardy','Harlan','Harley','Harold','Harriet','Harry','Harvey','Hayden','Heather','Henry','Herbert','Herman','Hilary','Hiram','Hobart','Hogan','Horace','Howar','Hubery','Hugh','Hugo','Humphrey','Hunter','Hyman','Ian','Ingemar','Ingram','Ira','Isaac','Isidore','Ivan','Ives','Jack','Jacob','James','Jared','Jason','Jay','Jeff','Jeffrey','Jeremy','Jerome','Jerry','Jesse','Jim','Jo','John','Jonas','Jonathan','Joseph','Joshua','Joyce','Julian','Julius','Justin','Keith','Kelly','Ken','Kennedy','Kenneth','Kent','Kerr','Kerwin','Kevin','Kim','King','Kirk','Kyle','Lambert','Lance','Larry','Lawrence','Leif','Len','Lennon','Leo','Leonard','Leopold','Les','Lester','Levi','Lewis','Lionel','Lou','Louis','Lucien','Luther','Lyle','Lyndon','Lynn','Magee','Malcolm','Mandel','Marcus','Marico','Mark','Marlon','Marsh','Marshall','Martin','Marvin','Matt','Matthew','Maurice','Max','Maximilian','Maxwell','Meredith','Merle','Merlin','Michael','Michell','Mick','Mike','Miles','Milo','Monroe','Montague','Moore','Morgan','Mortimer','Morton','Moses','Murphy','Murray','Myron','Nat','Nathan','Nathaniel','Neil','Nelson','Newman','Nicholas','Nick','Nigel','Noah','Noel','Norman','Norton','Ogden','Oliver','Omar','Orville','Osborn','Oscar','Osmond','Oswald','Otis','Otto','Owen','Page','Parker','Paddy','Patrick','Paul','Payne','Perry','Pete','Peter','Phil','Philip','Porter','Prescott','Primo','Quentin','Quennel','Quincy','Quinn','Quintion','Rachel','Ralap','Randolph','Raymond','Reg','Regan','Reginald','Reuben','Rex','Richard','Robert','Robin','Rock','Rod','Roderick','Rodney','Ron','Ronald','Rory','Roy','Rudolf','Rupert','Ryan','Sam','Sampson','Samuel','Sandy','Saxon','Scott','Sean','Sebastian','Sidon','Sidney','Silvester','Simon','Solomon','Spencer','Stan','Stanford','Stanley','Steven','Stev','Steward','Tab','Taylor','Ted','Ternence','Theobald','Theodore','Thomas','Tiffany','Tim','Timothy','Tobias','Toby','Todd','Tom','Tony','Tracy','Troy','Truman','Tyler','Tyrone','Ulysses','Upton','Uriah','Valentine','Valentine','Verne','Vic','Victor','Vincent','Virgil','Vito','Vivian','Wade','Walker','Walter','Ward','Warner','Wayne','Webb','Webster','Wendell','Werner','Wilbur','Will','William','Willie','Winfred','Winston','Woodrow','Wordsworth','Wright','Wythe','Xavier','Yale','Yehudi','York','Yves','Zachary','Zebulon','Ziv'
        ];
        $model = new MsupLecturer;
        $row = $model->find()->where('isnull(penName) or penName = \'\'')->all();
        $penNames = $model->find()->select('id,penName')->where('!isnull(penName) && penName!=\'\'')->asArray()->all();
        $penNames = ArrayHelper::map($penNames, 'id','penName');
        $names = array_diff($names, $penNames);
        foreach($row as $key => $value){
            $nl = count($names);
            $rand = round(rand(0, $nl-1));
            $name = $names[$rand];
            unset($names[$rand]);
            shuffle($names);
            $value->penName = $name;
            $value->updateAll(['penName' => $name], ['id' => $value->id]);
        }

    }
    /**
     * Lists all MsupLecturer models.
     * @return mixed
     */
    public function actionIndex($create_admin = null)
    {

        $searchModel = new MsupLecturerSearch();

        $model = new MsupLecturer;

        if ($create_admin) {

            $title = '我维护的教练';
             
        } else {
            
            $title = '教练管理';

        }
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 

        // 获取当前用户所维护的教练，用于判断是否显示联系按钮
        $lecturerAssignment = ArrayHelper::map(MsupLecturerAssignment::find()->select('lecturer_id, id')->where(['user_id' => Yii::$app->user->identity->id, 'status' => 1])->asArray()->all(), 'id', 'lecturer_id');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'title' => $title,
            'model' => $model,
            'searchModel' => $searchModel,
            'test' => 1,
            'lecturerAssignment' => $lecturerAssignment
        ]);
    }

    public function actionMy()
    {
        if (!Yii::$app->user->identity->id) {
            throw new BadRequestHttpException('请登录');
        }
        //先检查是否传入添加人没有就传入当前用户
        $create_admin = empty($create_admin) ? empty(Yii::$app->request->get('create_admin')) ? Yii::$app->user->identity->id : Yii::$app->request->get('create_admin') : $create_admin;

        $searchModel = new MsupLecturerSearch();
        $model = new MsupLecturer;
        $title = '我维护的教练';
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams); 

        // 获取当前用户所维护的教练，用于判断是否显示联系按钮
        $lecturerAssignment = ArrayHelper::map(MsupLecturerAssignment::find()->select('lecturer_id, id')->where(['user_id' => Yii::$app->user->identity->id, 'status' => 1])->asArray()->all(), 'id', 'lecturer_id');
        $dataProvider->query->andWhere(['user_id' => $create_admin]);
        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'title' => $title,
            'model' => $model,
            'searchModel' => $searchModel,
            'test' => 1,
            'lecturerAssignment' => $lecturerAssignment
        ]);

         return $this->render('index', [
            'dataProvider' => $dataProvider,
            'title' => $title,
            'model' => $model,
            'searchModel' => $searchModel,
            'test' => 1,
            'lecturerAssignment' => $lecturerAssignment
        ]);
    }
    
    /**
     * Displays a single MsupLecturer model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {

        $model = $this->findModel($id);
        $address     = $model->getAddress()->all();
        $directory   = $model->getDirectory()->all();
        $email       = $model->getEmail()->all();
        $publication = $model->getPublication()->all();
        $tags = $model->find()->innerJoinWith('tagRelation')->innerJoinWith('tagRelation.tags')->where(['pkid' => $model->id])->all();

        $globalFunc = new GlobalFunc;

        $model->thumbs = $globalFunc->uploadFormat($model->thumbs);
        $assignment = $model->getLecturerAssignment()->one();
        return $this->render('view', [
            'address' => $address,
            'email' => $email,
            'directory' => $directory,
            'model' => $model,
            'tags' => $tags,
            'assignment' => $assignment,
            'publication' => $publication,
        ]);

    }

    /**
     * Creates a new MsupLecturer model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new MsupLecturer();

        $reviewModel = new MsupReview;

        if ( $model->load(Yii::$app->request->post()) ) {
            
            if ($this->isUseReview && $reviewModel->addReview($model->name, $model->getModelId(), Yii::$app->request->post())) {
                header('Content-type:text/html;charset=utf8');
                echo "<script>alert('添加成功，请等待审核完成');window.history.go(-2);</script>";
                exit;
            } else if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw New BadRequestHttpException('发送的表单请求错误');
            }
        } else {

            if ($this->isUseReview) $model->modelId = $reviewModel->modelId;
            return $this->render('create', [
                    'model' => $model,
            ]);
        }
    }

    /**
     * s an existing MsupLecturer model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);
        $reviewModel = new MsupReview;

        if ( $model->load(Yii::$app->request->post()) ) {
            $post = Yii::$app->request->post();
            $post[$model->getClassName()]['id'] = $model->id;

            if ($this->isUseReview && $reviewModel->addReview($model->name, $model->getModelId(),$post)) {
                echo "<script>alert('更新成功，请等待审核完成');window.history.go(-2);</script>";
                exit;
            } else if ($model->save()) {
                return $this->redirect(['view', 'id' => $model->id]);
            } else {
                throw New BadRequestHttpException('发送的表单请求错误');
            }

        } else {   


            $address     = $model->getAddress()->all();
            $directory   = $model->getDirectory()->all();
            $email       = $model->getEmail()->all();
            $publication = $model->getPublication()->all(); //教练出版物
            $tagModel = new MsupTags;
            if ($this->isUseReview) $model->modelId = $reviewModel->modelId;
            return $this->render('update', [
                'address' => $address,
                'email' => $email,
                'directory' => $directory,
                'model' => $model,
                'publication' => $publication,
            ]);
        }
    }

    public function actionAssignment() {

        $model = new MsupLecturer;


        if ( Yii::$app->request->get("lids") && !Yii::$app->request->post()) {

            //列出当前教练的维护人与维护时间。
            $row = $model->find()->all();
            $lids = trim(Yii::$app->request->get("lids"), ",");
            $row = $model->find()->with('lecturerAssignment')->with('lecturerAssignment.user')->where('id in('.$lids.')')->all();
            $users = ArrayHelper::map(User::find()->asArray()->all(), 'id', 'username');
            return $this->render('assignment', [
                                            'row' => $row,
                                            'users' => $users
                                            ]
                            );

        } else if ( Yii::$app->request->post() ) {

            // 更新教练当前维护人
            $post =  Yii::$app->request->post();

            $data = json_decode($post['data'],1);

            if ( !empty($data['lids']) && $data['user_id'] ) {

                foreach ($data['lids'][0] as $value) {
                    $model = new \backend\models\MsupLecturerAssignment;
                    $model->lecturer_id = $value;
                    $model->user_id     = $data['user_id'];
                    $model->status      = 1;
                    $row = $model->findOne(['lecturer_id' => $value, 'user_id' => $data['user_id'] ]);

                    // 该用户之前是否维护过该教练，如果维护过，则只更新记录，否则新增一条
                    if ($row->id) {

                        $model->updateAll(['status'=>0], ['lecturer_id'=>$value]);
                        $model->updateAll(['status' =>1], ['lecturer_id'=>$value, 'user_id' => $data['user_id'] ]);
                        
                    } else {
                        $model->save();
                    }
                }
                echo 1;
            }

        }
    }



    /**
     * Deletes an existing MsupLecturer model.
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
     * 按名字搜索教练
     * @return [type] [description]
     */
    public function actionSearchByName() {
        
        $model = new MsupLecturer;
        $row = $model->find()->where("name like '%$_GET[data]%'")->asArray()->all();
        foreach ($row as $key => $value) {
            $row[$key]['name'] = Html::a($value['name'],Yii::$app->urlManager->createAbsoluteUrl(['lecturer/view', 'id'=>$value['id'], 'target'=>'_blank'])); 
        }
        echo json_encode($row);
    }

    /**
     * Finds the MsupLecturer model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MsupLecturer the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {   
        $model = MsupLecturer::find()->where(['id' => $id])->with('assignment', 'assignment.user')->one();
        if ($model !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
