<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_course_signup".
 *
 * @property integer $id
 * @property integer $appId
 * @property integer $sid
 *
 * @property Appoint $id0
 * @property Scheduling $s
 */
class MsupCourseSignup extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_course_signup';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appId', 'sid'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'appId' => Yii::t('app', '报名人'),
            'sid' => Yii::t('app', '报名课程'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getId0()
    {
        return $this->hasOne(Appoint::className(), ['id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getS()
    {
        return $this->hasOne(Scheduling::className(), ['id' => 'sid']);
    }
}
