<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_sites_model_map".
 *
 * @property integer $id
 * @property string $name
 * @property integer $model
 * @property string $table
 * @property integer $sitesId
 *
 * @property Sites $sites
 * @property Model $model0
 */
class MsupSitesModelMap extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_sites_model_map';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['model', 'sitesId'], 'integer'],
            [['name'], 'string', 'max' => 30],
            [['table'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '映射名称'),
            'model' => Yii::t('app', '系统模型'),
            'table' => Yii::t('app', '站点数据表'),
            'sitesId' => Yii::t('app', 'Sites ID'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSites()
    {
        return $this->hasOne(MsupSites::className(), ['id' => 'sitesId']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getModel0()
    {
        return $this->hasOne(MsupModel::className(), ['id' => 'model']);
    }
    
    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {

            if (!$this->sitesId) {
               $this->sitesId = Yii::$app->request->get('sitesId');
            }
            return true;
        }

    }

}
