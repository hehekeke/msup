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
class MsupCaseAdvice extends MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_case_advice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['case_id',  'user_id','advice_date'], 'integer'],
            [['content'], 'string', 'max' => 300],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'case_id' => Yii::t('app', '案例编号'),
            'user_id' => Yii::t('app', '用户编号'),
            'content' => Yii::t('app', '审批意见'),
            'advice_date' => Yii::t('app', '审批日期'),
           
        ];
    }
     /* 创建案例提交数据
     * @param  [ array] $attributes [description]
     * @return [type]             [description]
     */
    public function create(array $attributes){ 
        $this->setAttributes($attributes);
        if ($this->save()) {
          return $id=$this->attributes['id'];
        } else {
            return $this;
        }
    }

}
