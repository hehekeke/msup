<?php

namespace backend\models;

use Yii;
use frontend\models\Feedback;
/**
 * This is the model class for table "msup_scheduling_venue_course".
 *
 * @property integer $id
 * @property integer $sid
 * @property integer $snid
 * @property integer $courseid
 * @property string $startTime
 * @property string $endTime
 * @property string $date
 * @property string $hash
 */
class MsupSchedulingVenueCourse extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_scheduling_venue_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid', 'snid', 'courseid'], 'integer'],
            [['startTime', 'endTime', 'date'],'string', 'max' => 20 ],
            [['hash'], 'string', 'max' => 8]
        ];
    }
    public function beforeSave($insret) {
        parent::beforeSave($insert);
        $this->date = strtotime($this->date);
        return true;
    }

    /**
     * 检查有没有Scheduling的主键，如Scheduling是新建的话，那就赋值给hash
     * @param  [type] $model [要赋值的模型]
     * @param  [type] $sid   [id 或者是 hash]
     * @return [type] $model [模型]
     */
    public function getSidOrHash(&$model, $sid) {
        $reg = "/^\d$/";
        if ( preg_match($reg,intval($id)) ) {
            $model->sid = $sid;
        } else if(mb_strlen($sid, 'utf-8') == 8) {
            $model->hash = $sid;
            $model->sid  =  '';
        }
        return $model;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sid' => Yii::t('app', '排课'),
            'snid' => Yii::t('app', '分会场'),
            'courseid' => Yii::t('app', '课程'),
            'startTime' => Yii::t('app', '开始时间'),
            'endTime' => Yii::t('app', '结束时间'),
            'date' => Yii::t('app', '日期'),
            'hash' => Yii::t('app', '验证字符'),
        ];
    }
    // 获得相关联的课程信息
    public function getCourse() {
        return $this->hasOne(MsupCourse::className(), ['courseid' => 'courseid']);
    }
    // 获得相关联的排课信息
    public function getScheduling() {
        return $this->hasOne(MsupScheduling::className(), ['id' => 'sid']);
    }
    // 获取相关联的排课会场信息
    public function getSchedulingVenue($value='')
    {
        return $this->hasOne(MsupSchedulingVenue::className(), ['id' => 'snid']);
    }
    public function getCourseLecturer() {
        return $this->hasMany(MsupCourseLecturer::className(), ['cid' =>'courseid']);
    }
    
    /**
     * 获取反馈
     */
    public function getFeedback() {
        return $this->hasMany(MsupUserFeedback::className(), ['relationid'=>'id']);
    }
}
