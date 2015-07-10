<?php

namespace backend\models;

use Yii;
use backend\models\MsupSchedulingVenue;
use backend\models\MsupSchedulingVenueCourse;
use backend\models\MsupAttachment;

/**
 * This is the model class for table "msup_scheduling".
 *
 * @property integer $id
 * @property string $title
 * @property string $startTime
 * @property string $endTime
 * @property integer $price
 * @property string $video
 * @property string $address
 * @property integer $catid
 * @property integer $created_at  
 * @property integer $create_admin
 * @property integer $updated_at
 * @property integer $update_admin
 * @property integer $ceiling
 * @property string  $attachment
 * @property string  $poster
 * @property string  $applicans
 * @property interger $type
 * @property string  $content
 * @property integer $recommendToBuzz
 */
class MsupScheduling extends \backend\models\MsupBase
{

    /**
     * 排课类型
     * @see Yii::$app->params['schedulingType']
     * @var [type]
     */
    private $_types;
    public function getTypes(){
        if (!$this->types) $this->types = Yii::$app->params['schedulingType'];
        return $this->types;
    }
    public function setTypes($type = null){
        if ($type) $this->types = $type;
    }
    public function init($value='')
    {   
        parent::init();
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_scheduling';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'startTime', 'endTime',  'address'], 'required'],
            [['price', 'created_at', 'recommendToBuzz', 'updated_at', 'create_admin', 'update_admin', 'catid', 'applicans', 'clicks', 'collects', 'praises', 'comments', 'type'], 'integer'],
            [['title', 'address'], 'string', 'max' => 200],
            [['startTime', 'endTime'], 'string', 'max' => 18],
            [['video'], 'string', 'max' => 300],
            [['poster', 'attachment'], 'string', 'max' => 2000],
            [['content'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '课程排期名称'),
            'startTime' => Yii::t('app', '开始时间'),
            'endTime' => Yii::t('app', '结束时间'),
            'type' => Yii::t('app', '课程排期类型'),
            'price' => Yii::t('app', '本课价格'),
            'video' => Yii::t('app', '视频'),
            'address' => Yii::t('app', '会场地址'),
            'catid' => Yii::t('app', '栏目'),
            'ceiling' => Yii::t('app', '报名人数上限'),
            'created_at' => Yii::t('app', '创建时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'create_admin' => Yii::t('app', '创建人'),
            'update_admin' => Yii::t('app', '更新人'),
            'Attachment["poster"]' => Yii::t('app', '海报'),
            'Attachment["attachment"]' => Yii::t('app', '附件'),
            'applicans' => Yii::t('app', '报名人数'),
            'clicks' => Yii::t('app', '点击数'),
            'comments' => Yii::t('app', '评论数'),
            'praises' => Yii::t('app', '点赞数'),
            'collects' => Yii::t('app', '收藏数'),
            'content' => Yii::t('app', '排课介绍'),
            'recommendToBuzz' => Yii::t('app', '推送到BUZZ'),
        ];
    }
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) { 
            $this->startTime = strtotime($this->startTime);
            $this->endTime = strtotime($this->endTime);
            return true;
        }
    }

    public function afterSave($insert, $changedAttributes){

        parent::afterSave($insert, $changedAttributes);
        $venueModel = new MsupSchedulingVenue;
        $venueCourseModel = new MsupSchedulingVenueCourse;
        // 更新附属表
        $venueModel->updateAll(['sid' => $this->id, 'hash' => ''], ['hash' => Yii::$app->request->post()['hash']]);
        $venueCourseModel->updateAll(['sid' => $this->id, 'hash' => ''], [ 'hash' => Yii::$app->request->post()['hash'] ] );
        $controller = Yii::$app->controller;
        $controller->redirect(['common/s']);
        return true;   

    }
    /**
     * 根据排课的类型不同获取不同的默认链接
     * @return string url
     */
    public function getLinkUrl(){
        if (!$this->id) return '';
        switch ($this->type) {
            case 1: case 2:
            $course = $this->getSchedulingVenueCourse()->orderBy('id desc')->one();
                return Yii::getAlias('@baseUrl').'/index.php?m=content&c=index&a=course&courseid='.$course->courseid;
            case '3':
            return 'http://www.mpd.org.cn/';
                break;
            case 4:
            return 'http://www.top100summit.com';
                break;
            case 5:
            return 'http://2015.top100summit.com';
                break;
            default:
                return 'http://www.msup.com.cn';
                break;
        }
    }

    public function getAttahchMent($field) {
        return $this->hasMany( MsupAttachment::className(), ['modelPk' => 'id', 'modelId' => $this->modelId, 'field' => $field ] );
    }

    public function getSchedulingVenue() {
        return $this->hasMany(MsupSchedulingVenue::className(), ['sid' => 'id']);
    }
    //获取排课的所有关联课程
    public function getSchedulingVenueCourse() {
        return $this->hasMany( MsupSchedulingVenueCourse::className(), ['sid' => 'id']);

    }
    // 获取排课的所有关联课程和会场详细信息
    public function getSchedulingVenueCourses() {
        return $this->hasMany( MsupSchedulingVenueCourse::className(), ['sid' => 'id'])->select('msup_scheduling_venue_course.*, c.title as title,v.venueName as venueName')->leftJoin('msup_course c', 'c.courseid = msup_scheduling_venue_course.courseid')->leftJoin('msup_scheduling_venue v', 'v.id = msup_scheduling_venue_course.snid' );

    }
}
