<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_appoint_lecturer".
 *
 * @property integer $id
 * @property integer $appId
 * @property integer $lid
 *
 * @property Lecturer $l
 * @property Appoint $app
 */
class MsupAppointLecturer extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_appoint_lecturer';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['appId', 'lid'], 'required'],
            [['appId', 'lid'], 'integer']
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
            'lid' => Yii::t('app', '教练'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getL()
    {
        return $this->hasOne(Lecturer::className(), ['id' => 'lid']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getApp()
    {
        return $this->hasOne(Appoint::className(), ['id' => 'appId']);
    }
}
