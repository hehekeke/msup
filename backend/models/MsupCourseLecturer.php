<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_course_lecturer".
 *
 * @property integer $id
 * @property integer $cid
 * @property integer $lid
 */
class MsupCourseLecturer extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_course_lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['cid', 'lid'],'required'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'cid' => Yii::t('app', '课程ID'),
            'lid' => Yii::t('app', '教练ID'),
        ];
    }

    public function getLecturer($value='')
    {
        return $this->hasOne(MsupLecturer::className(), ['id' => 'lid']);
    }
    public function getCourse($value = ''){
        return $this->hasOne(MsupCourse::className(), ['courseid' => 'cid']);
    }
    public function getLecturerCourses(){
        return $this->hasMany(MsupCourseLecturer::className(), ['lid' => 'lid']);
    }
}
