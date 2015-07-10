<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_sites_field_map".
 *
 * @property integer $id
 * @property string $siteField
 * @property string $coreField
 * @property integer $mapId
 * @property string $siteFieldName
 * @property string $coreFieldName
 */
class MsupSitesFieldMap extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_sites_field_map';
    }

    public static function getDb() {
        return Yii::$app->getDb();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['mapId'], 'integer'],
            [['siteField', 'coreField'], 'string', 'max' => 20],
            [['siteFieldName', 'coreFieldName'], 'string', 'max' => 30]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'siteField' => Yii::t('app', '站点字段'),
            'coreField' => Yii::t('app', '系统字段'),
            'mapId' => Yii::t('app', '所属映射'),
            'siteFieldName' => Yii::t('app', '站点字段名'),
            'coreFieldName' => Yii::t('app', '系统字段名'),
        ];
    }
    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {

            if (!$this->mapId) {
                $this->mapId = Yii::$app->request->get('map');
            }
            return true;
        }
    }
}
