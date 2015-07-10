<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_course_usedtime".
 *
 * @property integer $usedtimeid
 * @property string $title
 *
 * @property Course[] $courses
 */
class MsupCourseUsedtime extends MsupBase
{
    // 课程时间长度——以小时计算
    private $_times;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_course_usedtime';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title','desc'], 'string', 'max' => 255],
            [['usedtimeid','hour'], 'integer'],
            [['title','hour','desc'], 'required']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'usedtimeid' => 'ID',
            'title' => '课程时长名称',
            'hour' => '课程时长（单位：小时）',
            'desc' => '描述',
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '最后更新'),
            'create_admin' => Yii::t('app', '添加管理员'),
            'update_admin' => Yii::t('app', '更新管理员'),
        ];
    }
    public function getTimes($value='') 
    {
        if (!$this->times) {
            $this->times = [ 1 => '1小时', 2 => '2小时', 3 => '3小时', 24 => '1天', 48 => '2天', 72 => '3天', 96 => '4天',120 => '5天'];
        }
        return $this->times;
    }
    public function setTimes($time) {
        if ($time) {
            $this->times = $time;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourses()
    {
        return $this->hasMany(Course::className(), ['usedtimeid' => 'usedtimeid']);
    }
}
