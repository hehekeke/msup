<?php

namespace backend\models;

use Yii;
use dektrium\user\models\User;
use backend\components\GlobalFunc;
/**
 * This is the model class for table "msup_lecturer".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $qq
 * @property string $wecat
 * @property string $company
 * @property string $position
 * @property string $referee
 * @property string $pen_name
 * @property string $leadSource
 * @property string $thumbs
 * @property string $signature
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $create_admin
 * @property integer $update_admin
 * @property integer $status
 * @property string  $idNumber
 * @property string  $content
 * @property string  $description
 * @property string  $remarks
 * @property string  $office
 * @property integer $hits
 * @property integer $collects
 */
class MsupLecturer extends \backend\models\MsupReview
{
    public $statusLabel = ['1'=>'正常', '2'=>'停止排课' , '3'=>'停止维护'];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'updated_at', 'create_admin', 'update_admin', 'status', 'hits', 'collects'],  'integer'],
            
            [['content', 'idNumber', 'referee', 'remarks', 'office'], 'string'],
            [['name', 'company', 'position', 'description', 'office', 'penName'], 'required'],
            [['name', 'company', 'position', 'penName', 'leadSource'], 'string', 'max' => 100],
            [['phone', 'qq'], 'string', 'max' => 20],
            [['email', 'wecat'], 'string', 'max' => 30],
            [['thumbs', 'description'], 'string', 'max' => 3000],
            [['signature'], 'string', 'max' => 1000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '真实姓名'),
            'phone' => Yii::t('app', '教练电话'),
            'email' => Yii::t('app', 'Email'),
            'qq' => Yii::t('app', '教练QQ'),
            'wecat' => Yii::t('app', '教练微信'),
            'company' => Yii::t('app', '现任公司'),
            'office' => Yii::t('app', '现任职部门'),
            'position' => Yii::t('app', '现任职位'),
            'referee' => Yii::t('app', '推荐人'),
            'penName' => Yii::t('app', '教练笔名'),
            'leadSource' => Yii::t('app', '资料来源'),
            'thumbs' => Yii::t('app', '头像'),
            'signature' => Yii::t('app', '签名'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '最后更新'),
            'create_admin' => Yii::t('app', '添加管理员'),
            'update_admin' => Yii::t('app', '更新管理员'),
            'status' => Yii::t('app', '教练状态'),
            'idNumber' => Yii::t('app', '身份证号'),
            'content' => Yii::t('app', '详细描述'),
            'description' => Yii::t('app', '教练简介（字数200 - 300字）'),
            'remarks' => Yii::t('app', '备注信息'),

        ];
    }

    public function beforeSave($insert) {
        // p($this);
        if (parent::beforeSave($insert)) {
            // 设置默认来源
            $this->setDefault('leadSource', Yii::$app->user->identity->role.'('.\yii\helpers\Html::tag("span",Yii::$app->user->identity->username,['style' => 'color:#ef5634']).')上传');
            $gfunc = new \backend\components\GlobalFunc;
            // 设置默认头像
            $this->setDefault('thumbs', $gfunc->uploadFormat([['fileUrl' => Yii::getAlias('@imagesPath').'/default_headpic.png', 'fileName' => '默认头像']]));
        }

        return true;

    }

    /**
     * [afterSave description]
     * @return [type] [description]
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
        if (Yii::$app->request->post())
        {
            $post = Yii::$app->request->post();
            // 添加关联关系表
            foreach(   $post as $key => $value) {
                
                if ( !in_array($key, $this->filter) ) {
                    $className = "\backend\models\\$key";
                    if (!class_exists($className)) continue;
                    $newModel = new $className;
                    $value['model'] = $this;
                    if (!empty($value)) {
                        $newModel->lecturerAdd($value);
                    }
                }

            }
           // 同上一个循环
            if ( isset($post['new']) ) {
                foreach ($post['new'] as $key => $value) {
                    $className = "\backend\models\\$key";
                    if (!class_exists($className)) continue;
                    foreach ($value as $m => $n) {
                        $n['model']  = $this;
                        $newModel = new $className;
                        $newModel->lecturerAdd($n);
                    }
                }
            }
            // 更新关联关系表数据
            if ( isset($post['update']) ) {
                foreach ($post['update'] as $key => $value) {
                    $className = "\backend\models\\$key";
                    if (!class_exists($className)) continue;
                    foreach ($value as $m =>$n) {
                        $n['id'] = $m;
                        $n['model'] = $this;
                        $newModel = new $className;
                        $newModel->lecturerUpdate($n);
                    }
                }
            }

            // 新记录时添加默认维护人为当前管理员
            $assignment = new MsupLecturerAssignment();
            $row = $assignment->findOne(['lecturer_id' => $this->primaryKey]);
            if (!$row->id) {
                $assignment->lecturer_id = $this->primaryKey;
                $assignment->status = 1;
                $assignment->user_id = Yii::$app->user->identity->id;
                $assignment->save();
            }

        }

        return true;
    }


    // post过滤
    public function getFilter() {
        return ['_csrf', 'MsupLecturer','update', 'new'];
    }

    // 获取联系方式（地址）
    public function getAddress(){
        return $this->hasMany(MsupAddress::className(), ['lecturer_id'=>'id']);
    }

    //获取联系方式（手机号码） 
    public function getDirectory() {
        return $this->hasMany(MsupDirectory::className(), ['lecturer_id'=>'id']);
    }
    // 获取联系方式（email）
    public function getEmail(){
        return $this->hasMany(MsupEmail::className(), ['lecturer_id'=>'id']);
    }

    /**
     * @see  $this->getLecturerAssingment()
     * @return [type] [description]
     */
    public function getAssignment() {
        return $this->getLecturerAssignment();
    }
    //获取关联教练分配给的用户
    public function getLecturerAssignment() {
        
        return $this->hasOne(MsupLecturerAssignment::className(),['lecturer_id'=>'id'])->onCondition([MsupLecturerAssignment::tableName().'.status' => 1]);
    }
    //获取教练出版物
    public function getPublication() {
        return $this->hasMany(MsupPublication::className(), ['lecturer_id' => 'id']);
    }

    //获取跟教练有关的课程
    public function getCourse() {
        return $this->hasMany(MsupCourse::className(), ['lecturer_id' => 'id']);
    }

    public function getLecturerCourse() {
        return $this->getCourseLecturer();
    }
    public function getCourseLecturer() {
        return $this->hasMany(MsupCourseLecturer::className(), ['lid' => 'id']);
    }
    public function getTagRelation() {
        // return MsupTags::tagRelation($this, $this->primaryKey()[]);
        return $this->hasMany(MsupTagRelation::className(), ['pkId'=>'id'])->onCondition(['modelId' => $this->modelId]);
    }


    public function getContactNotes() {
        return $this->hasMany(MsupContactNotes::className(), ['toId' => 'id'])->onCondition(['userid' => Yii::$app->user->identity->id, 'toModel' => $this->modelId]);
    }

    // 获取跟教练有关的排课
    public function getSchedulling() {

    }


    /**
     * 教练状态
     * @param  integer $status [description]
     * @return [type]         [description]
     */
    public function getStatusLabel($status){
        return $this->statusLabel[$status];
    }

}
