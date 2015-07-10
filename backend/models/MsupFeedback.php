<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_feedback".
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property integer $created_at
 * @property integer $create_admin
 * @property integer $updated_at
 * @property integer $isAdopt
 * @property integer $isSolve
 * @property integer $praise
 * @property integer $modelId
 */
class MsupFeedback extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['created_at', 'create_admin', 'updated_at', 'isAdopt', 'isSolve', 'praise', 'modelId'], 'integer'],
            [['title'], 'string', 'max' => 200],
            [['description'], 'string', 'max' => 1000]
        ];
    }

    public function modelDropDownList() {
        $model = new MsupModel;
        $modelDrpDownList = $model->modelDrpDownList();
        return $modelDrpDownList;
    }

    public function getUser(){
        return $this->hasOne(\dektrium\user\models\User::className(), ['id' => 'create_admin' ]);
    }
    public function getModel(){
        return $this->hasOne(MsupModel::className(), ['id' => 'modelId' ]);
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '标题'),
            'description' => Yii::t('app', '描述'),
            'created_at' => Yii::t('app', '添加时间'),
            'create_admin' => Yii::t('app', '提交人'),
            'updated_at' => Yii::t('app', '更新时间'),
            'isAdopt' => Yii::t('app', '意见是否采纳'),
            'isSolve' => Yii::t('app', '问题是否解决'),
            'praise' => Yii::t('app', '赞同人数'),
            'modelId' => Yii::t('app', '模块'),
        ];
    }

    /**
     * 枚举值反转
     * example
     * enumMap('是');return 1;
     * @param  $value
     * @return [type] [description]
     */
    public function enumMap($value) {
        $enums = [ '是' => 1, '否' => 2];
        return $enums[$value];
    }
}
