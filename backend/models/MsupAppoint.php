<?php

namespace backend\models;

use Yii;
use \backend\components\AppointFactory;
/**
 * This is the model class for table "msup_appoint".
 *
 * @property integer $id
 * @property string $name
 * @property string $phone
 * @property string $email
 * @property string $company
 * @property string $position
 * @property string $address
 * @property string $description
 * @property integer $type
 * @property integer $state
 * @property string company_address
 * 
 * @property AppointCourse[] $appointCourses
 * @property AppointLecturer[] $appointLecturers
 * @property CourseSignup $courseSignup
 */
class MsupAppoint extends \backend\models\MsupBase
{
    public $typesLabelAndModelName= [  
            ['label' => '联系教练', 'model'  =>  'AppointLecturer'],
            ['label' => '预约内训', 'model'  =>  'AppointCourse'],
            ['label' => '课程报名', 'model'  =>  'CourseSignup'],
            ];
    public $requestData;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
            return 'msup_appoint';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['type', 'state'], 'integer'],

            [['name', 'phone', 'email', 'created_at'], 'string', 'max' => 20],
            [['company', 'position'], 'string', 'max' => 50],
            [['address'], 'string', 'max' => 80],
            [['company_address', 'string', 'max' => 100]],
            [['description'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '姓名'),
            'phone' => Yii::t('app', '联系电话'),
            'email' => Yii::t('app', '电子邮箱'),
            'company' => Yii::t('app', '公司名'),
            'position' => Yii::t('app', '职位'),
            'address' => Yii::t('app', '公司地址'),
            'description' => Yii::t('app', '个人介绍'),
            'type' => Yii::t('app', '预约类型0:联系教练,1:预约内训。2:课程报名'),
            'state' => Yii::t('app', '预约状态0:未处理，1：已处理'),
            'created_at' => Yii::t('app', '申请时间'),
            'company_address' => Yii::t('app', '
                公司地址'),
        ];
    }

    // 添加一个预约
    public function createOneAppoint(array $attributes){
        if (empty($attributes)) {
            return 0;
        }
        $factory = new AppointFactory(); 
        $model = $factory->create(substr($this->getClassName(),4), $attributes);
        $model->requestData = $attributes;
        if ($model->save()) {
            return $model->id;
        }
    }
    public function beforeSave($insert) {
        parent::beforeSave($insert);
        return true;
    }

    public function afterSave($insert, $changedAttribute){
        $factory = new AppointFactory;
        $relationModel = $factory->create($this->typesLabelAndModelName[$this->requestData['type']]['model'], $this->requestData);
        if (!$relationModel->hasAttribute('appId')) {
            return 0;
        } 
        $relationModel->appId = $this->id;
        if ($relationModel->save()) {
            return 1; 
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointCourses()
    {
        return $this->hasMany(AppointCourse::className(), ['appId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAppointLecturers()
    {
        return $this->hasMany(AppointLecturer::className(), ['appId' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseSignup()
    {
        return $this->hasOne(CourseSignup::className(), ['id' => 'id']);
    }
}
