<?php

namespace backend\models;

use Yii;
use yii\helpers\ArrayHelper;
/**
 * This is the model class for table "msup_model".
 *
 * @property integer $id
 * @property string $modelName
 * @property string $modelClass
 */
class MsupModel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_model';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['modelName', 'modelClass'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'modelName' => Yii::t('app', '模型名称'),
            'modelClass' => Yii::t('app', '模型类'),
        ];
    }
    public function getMsupSitesModelMap(){
        return $this->hasOne(MsupSitesModel::className(), ['id'=>'model']);
    }
    public static function modelDrpDownList(){
        $row = self::find()->all();
        $dropDownList = ArrayHelper::map($row, 'id', 'modelName');
        return $dropDownList;
    }

}
