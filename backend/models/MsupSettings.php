<?php

namespace backend\models;

use Yii;
use  yii\base\ErrorException;
/**
 * This is the model class for table "msup_settings".
 *
 * @property integer $id
 * @property string $emailSMTP
 * @property string $copyRight
 * @property string $address
 * @property string $tel
 */
class MsupSettings extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_settings';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['emailSMTP', 'tel'], 'string', 'max' => 100],
            [['copyRight'], 'string', 'max' => 200],
            [['address'], 'string', 'max' => 300]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'emailSMTP' => Yii::t('app', '邮箱代理'),
            'copyRight' => Yii::t('app', '版权信息'),
            'address' => Yii::t('app', '公司地址'),
            'tel' => Yii::t('app', '联系方式'),
        ];
    }
    public function getConnectionInfo($siteId = 1){
        $connection = $this->find()->select('id,emailSMTP')->where('id = '.$siteId)->one();

        if (!$connection->id) {
            throw new ErrorException('您尚未配置您的邮箱 SMTP 信息，请配置后再使用邮箱功能');
        } 
        return json_decode($connection['emailSMTP'], true);

    }
}
