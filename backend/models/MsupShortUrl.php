<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_short_url".
 *
 * @property integer $id
 * @property string $longUrl
 * @property string $shortUrl
 */
class MsupShortUrl extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_short_url';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['longUrl'], 'string', 'max' => 200],
            [['shortUrl'], 'string', 'max' => 30]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'longUrl' => Yii::t('app', '原链接'),
            'shortUrl' => Yii::t('app', '短链接'),
        ];
    }
}
