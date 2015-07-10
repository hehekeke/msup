<?php

namespace backend\models;

use Yii;
use yii\web\BadRequestHttpException;
/**
 * This is the model class for table "msup_sites".
 *
 * @property integer $id
 * @property string $siteName
 * @property string $siteUrl
 *
 * @property SitesFieldMap[] $sitesFieldMaps
 */
class MsupSites extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_sites';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['siteName'], 'string', 'max' => 50],
            [['siteUrl'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'siteName' => Yii::t('app', '站点名称'),
            'siteUrl' => Yii::t('app', '站点域名'),
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSitesFieldMaps()
    {
        return $this->hasMany(SitesFieldMap::className(), ['siteId' => 'id']);
    }

    public static function getSiteId($site = null) 
    {
        if (!$site && !$_SERVER[HTTP_REFERER]) {
            if(!$_SERVER[HTTP_REFERER]) throw new NotFoundHttpException("错误的请求，调用该方法必须传入站点域名");
        }
        $siteUrl = ($site == null) ? $_SERVER['HTTP_REFERER'] : $site;
        $site = self::find()->where(['siteUrl' =>  $siteUrl])->one();
        if (!$site->id) {
            $siteModel = new MsupSites;
            return $siteModel->createOnSite(['siteUrl' => $siteUrl]);
        } else {
            return $site->id;
        }
    }

    /**
     * 添加一个站点信息
     * @param  [type] $attributes [description]
     * @return [type]             [description]
     */
    public function createOnSite($attributes){
        $this->setAttributes($attributes);
        if($this->save()){
            return $this->id;
        }
    }
}
