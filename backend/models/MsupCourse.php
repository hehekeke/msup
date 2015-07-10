<?php

namespace backend\models;

use Yii;
use backend\components\GlobalFunc;

/**
 * This is the model class for table "msup_course".
 *
 * @property integer $courseid
 * @property integer $num
 * @property integer $lecturer_id
 * @property integer $usedtimeid
 * @property string $created_at
 * @property string $updated_at
 * @property string $sponsor
 * @property string $price
 * @property string $desc
 * @property string $character
 * @property string $target
 * @property string $trainees
 * @property string $file
 * @property string $media
 * @property string $thumbs
 * @property string $content
 * @property string $title
 * @property string $course_title
 * @property string $course_content
 * @property string $training
 * @property string $other
 * @property string $praises
 * @property string $collects
 * @property string $comments
 * @property string $level
 * @property string $hits;
 * @property string $appointmentTime
 * @property string $priceDesc
 * @property string $content
 * @property string $speech
 * @property string $lead_source
 * @property string $courseNumber
 * @property integer $type
 * @property integer $appointment
 * @property integer $assignToTop100
 * @property integer $assignToMpd
 * @property integer $assignToOready
 * @property integer $assignToMsup
 * @property integer $assignToSalon
 * @property CourseTag[] $courseTags
 * 
 */
class MsupCourse extends MsupBase
{
    private $content;
    private $_appointments;
    public function getAppointments(){
        if (!$this->appointments) {
            $this->appointments = ['1' => '周一到周日', 2 => '周一到周五', 3 => '周六日'];
        }
        return $this->appointments;
    }
    public function setAppointments($appointment = null){
        if ($appointment) { 
            $this->appointments = $appointment;
        }
    }
    
    public $levelLabel = ['100' => '初级', '200' => '中级', '300' => '高级'];
    public $typeLabel = ['0' => '资料更新中', '1' => '上线',  '2' => '下线'];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [[ 'usedtimeid', 'num', 'collects', 'praises', 'comments', 'level', 'hits', 'appointment', 'type'], 'integer'],
            [['lecturer_id'], 'required'],
            [['assignToMpd','assignToTop100','assignToMsup','assignToSalon','assignToOready'], 'integer'],
            // [['title','price', 'usedtimeid', 'num'], 'required'],
            [['price'], 'number'],
            [['training', 'courseNumber', 'target', 'trainees', 'teacher', 'appointmentTime', 'profit', 'lead_source', 'level', 'content'], 'string'],
            [['file','created_at', 'updated_at', 'lecturer_id', 'speech', 'media', 'thumbs','title', 'other', 'priceDesc'], 'string'],
            [['sponsor', 'desc', 'character'], 'string']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'title' => Yii::t('app', '标题'),
            'created_at' => Yii::t('app', '添加时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'content' => Yii::t('app', '课程内容'),
            'courseid' =>  Yii::t('app', '课程id'),
            'title' =>  Yii::t('app', '课程标题'),
            'level' => Yii::t('app', '难度等级'),
            'type' => Yii::t('app', '课程状态'),
            'sponsor' =>  Yii::t('app', '主办方'),
            'lecturer_id' =>  Yii::t('app', '课程教练'),
            'usedtimeid' =>  Yii::t('app', '课程时长'),
            'price' =>  Yii::t('app', '公开课价格：（用于网站展示）'),
            'priceDesc' => Yii::t('app', '价格信息'),
            'num' =>  Yii::t('app', '课程预计人数'),
            'desc' =>  Yii::t('app', '课程简介：（请用简短的语句描述该课程，字数：200-300字）'),
            'character' =>  Yii::t('app', '一、培训特色（用200-300字描绘课程特色，请参阅范文）'),
            'profit' =>  Yii::t('app', '二、目标收益（用100-200字描绘目标收益，请参阅范文）'),
            'target' =>  Yii::t('app', '三、培训对象（准确描述培训适合群体，明确客户群）'),
            'trainees' =>  Yii::t('app', '四、学员基础（请参阅范文）'),
            'teacher' =>  Yii::t('app', '六、教练简介'),
            'relation' =>  Yii::t('app', '七、相关课程'),
            'appointment' =>  Yii::t('app', '六、可预约时间'),
            'appointmentTime' => Yii::t('app', '七、需要提前多久预约'),
            'file' =>  Yii::t('app', '课程附件（随堂PPT）'),
            'media' =>  Yii::t('app', '课程媒体'),
            'thumbs' =>  Yii::t('app', '课程宣传图片（网站banner展示，分辨率：878*514）'),
            'other' =>  Yii::t('app', '其他（教练授课的特殊习惯及制定教具要求 ）'),
            'auditionvideo' =>  Yii::t('app', '适配版试听视频代码'),
            'auditiondesc' =>  Yii::t('app', '文字版试听'),
            'praises' => Yii::t('app', '被赞的次数'),
            'collects' => Yii::t('app', '被收藏的次数'),
            'comments' => Yii::t('app', '被评论的次数'),
            'hits' => Yii::t('app', '浏览量'),
            'speech' => Yii::t('app', '演讲文稿(教练的演讲文稿)'),
            'courseNumber' => Yii::t('app', '课程编号'),
            'assignToMpd' => Yii::t('app', 'MPD'),
            'assignToTop100' => Yii::t('app', 'Top100'),
            'assignToOready' => Yii::t('app', 'Oready'),
            'assignToMsup' => Yii::t('app', 'Msup'),
            'assignToSalon' => Yii::t('app', '沙龙活动'),

        ];
    }
    public function beforeSave($insert)
    {   

        parent::beforeSave($insert);
        $this->training = empty( $this->training ) ? '' :preg_replace('/\r\n/', '<br/>', addslashes($this->training));
        $this->priceDesc = empty( $this->priceDesc ) ? '' : addslashes($this->priceDesc);
        return true;
    }

    public function addcslashesAttrbuite($str) {

    }
    public function afterSave($insert, $changedAttributes){
        parent::afterSave($insert, $changedAttributes);
        $lecturer = new MsupLecturer;
        $courseLecturer = new MsupCourseLecturer;
        if ( !empty($changedAttributes['lecturer_id']) || preg_match('/^\d*,?\d+$/', $this->lecturer_id) ) {
            $row = $lecturer->find()->select('name, id')->where(" id in(".$this->lecturer_id.") ")->asArray()->all();

                $courseLecturer->deleteAll(['cid' => $this->courseid]);
                $lecturer = '';
            foreach ($row as $k => $v) {
                $lecturer .= ','.$v[name];
                $courseLecturer = new MsupCourseLecturer;
                $courseLecturer->attributes = [];
                $courseLecturer->lid = $v[id];
                $courseLecturer->cid = $this->courseid;
                $courseLecturer->save();
            }
            $this->updateAll(['lecturer_id' => trim($lecturer, ',')], [ 'courseid' => $this->courseid ]);
        }

        return true;
    }
    public function getContent() {
        return $this->content;
    }
    public function setContent() {
    }
    
    // 获得课程难度等级
    public function getLevel($level) {
        if ($level) {
            return $this->levelLabel[$level];
        }
    }
    // post过滤
    public function getFilter() {
        return ['_csrf','course_title','course_content', 'MsupCourse','update', 'new'];
    }
    
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCourseTags()
    {
        return $this->hasMany(CourseTag::className(), ['courseid' => 'courseid']);
    }

    public function getTagRelation(){
        return $this->hasMany(MsupTagRelation::className(), ['pkId' => 'courseid'])->onCondition(['modelId' => 4]);
    }

    /**
     * 获得课程时长
     * @return \yii\db\ActiveQuery
     */
    public function getCourseUsedtime(){
        return $this->hasOne(MsupCourseUsedtime::className(), ['usedtimeid'=>'usedtimeid']);
    }


    public function getCourseLecturer() {
        return $this->hasMany(MsupCourseLecturer::className(), ['cid' =>'courseid']);
    }
}
