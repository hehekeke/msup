<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_requests".
 *
 * @property integer $id
 * @property string $ip
 * @property string $source
 * @property integer $numbers
 * @property string $firstTime
 */
class MsupRequest extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_requests';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['numbers'], 'integer'],
            [['ip'], 'string', 'max' => 20],
            [['source'], 'string', 'max' => 40],
            [['firstTime'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'ip' => Yii::t('app', '访问者Ip'),
            'source' => Yii::t('app', '来源站点'),
            'numbers' => Yii::t('app', '访问次数'),
            'firstTime' => Yii::t('app', '首次访问时间'),
        ];
    }


   

}
