<?php

namespace backend\models;

use Yii;
use backend\models\MsupBase;
/**
 * This is the model class for table "msup_case_submit".
 *
 * @property integer $id
 * @property string $courseTitle
 * @property string $lecturerName
 * @property string $lecturerDescription
 * @property string $lecturerThumbs
 * @property string $lecturerPosition
 * @property integer $courseTag
 * @property integer $courseDescription
 * @property string $courseContent
 * @property string $courseThumbs
 * @property string $companyThumbs
 * @property string $companyDescription
 * @property string $companyName
 * @property string $companySize
 * @property string $companyPosition
 * @property integer $user_id
 * @property integer $created_at
 * @property integer $updated_at
 */
class MsupCaseSubmit extends MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_case_submit';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturerDescription', 'courseContent', 'companyDescription','courseDescription'], 'string'],
            // [['courseTag', 'user_id'], 'required'],
            [['courseTag',  'user_id', 'created_at', 'updated_at','caseStatus'], 'integer'],
            [['courseTitle'], 'string', 'max' => 100],
            [['lecturerName', 'lecturerPosition', 'companyPosition'], 'string', 'max' => 30],
            [['lecturerThumbs', 'courseThumbs', 'companyThumbs','caseAdvice'], 'string', 'max' => 300],
            [['companyName'], 'string', 'max' => 50],
            [['companySize'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'courseTitle' => Yii::t('app', '案例提案名称'),
            'lecturerName' => Yii::t('app', '分享者姓名'),
            'lecturerDescription' => Yii::t('app', '分享者简介'),
            'lecturerThumbs' => Yii::t('app', '分享者照片'),
            'lecturerPosition' => Yii::t('app', '申请人职位'),
            'courseTag' => Yii::t('app', '案例方向'),
            'courseDescription' => Yii::t('app', '所在软件研发中心介绍'),
            'courseContent' => Yii::t('app', '课程大纲'),
            'courseThumbs' => Yii::t('app', '课程海报'),
            'companyThumbs' => Yii::t('app', '公司 LOGO'),
            'companyDescription' => Yii::t('app', '公司简介'),
            'companyName' => Yii::t('app', '公司名'),
            'companySize' => Yii::t('app', '公司规模'),
            'companyPosition' => Yii::t('app', '公司职能定位'),
            'user_id' => Yii::t('app', '提交人'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'caseStatus' => Yii::t('app', '审核状态'),
            'caseAdvice' => Yii::t('app', '案例意见'),
        ];
    }
     /* 创建案例提交数据
     * @param  [ array] $attributes [description]
     * @return [type]             [description]
     */
    public function create(array $attributes){ 

        $this->setAttributes($attributes);
        if ($this->save()) {
            return $this;
        } else {
            return $this;
        }
    }
    private function setCaseSubmitAdvice($caseAdvice) {
        $this->caseAdvice = $caseAdvice;
    }
     public function addCaseSubmitAdvice($caseAdvice){
        $this->setCaseSubmitAdvice($caseAdvice);
       $this->updateAll(['caseAdvice' =>  $this->caseAdvice,'caseStatus'=>'1'],['id' => $this->id]);
    }
    //根据id来更新casesubmit的相关数据
    public function caseSubmitUpdateById($data)
    {
        $this->updateAll($data,['id' => $this->id]);
    }
}
