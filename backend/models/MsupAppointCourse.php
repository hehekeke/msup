<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_appoint_course".
 *
 * @property integer $id
 * @property integer $appId
 * @property string $time
 * @property string $address
 *
 * @property Appoint $app
 */
class MsupAppointCourse extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_appoint_course';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appId'], 'required'],
            [['appId'], 'integer'],
            [['time'], 'string', 'max' => 20],
            [['address'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'appId' => Yii::t('app', '预约人'),
            'time' => Yii::t('app', '预约上课时间'),
            'address' => Yii::t('app', '预约内训地点'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApp()
    {
        return $this->hasOne(Appoint::className(), ['id' => 'appId']);
    }
}
