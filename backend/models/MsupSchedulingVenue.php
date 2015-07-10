<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_scheduling_venue".
 *
 * @property integer $id
 * @property integer $sid
 * @property string $venueName
 * @property string $hash
 */
class MsupSchedulingVenue extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_scheduling_venue';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'integer'],
            [['venueName'], 'string', 'max' => 100],
            [['hash'], 'string', 'max' => 8]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'sid' => Yii::t('app', '排课'),
            'venueName' => Yii::t('app', '会场名称'),
            'hash' => Yii::t('app', '验证字符'),
        ];
    }

    public function getSchedulingVenueCourse() {

        return $this->hasMany( MsupSchedulingVenueCourse::className(), ['snid' => "id"] );
    }
}
