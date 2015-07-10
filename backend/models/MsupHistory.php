<?php

namespace backend\models;

use Yii;
// use backend\models\MsupReview;
/**
 * This is the model class for table "msup_history".
 *
 * @property integer $id
 * @property integer $lastCommit
 * @property integer $commit
 * @property string  $fieldName
 * @property string  $fieldValue
 * @property string  $title
 * @property string  $comment
 */
class MsupHistory extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_history';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lastCommit', 'commit'], 'string'],
            [['fieldName'], 'string', 'max' => 100],
            // [['fieldValue'], 'unique']
        ];
    }

    public function beforeSave($insert) {
        if ( parent::beforeSave($insert) ) 
        {
            if ($this->fieldName && $this->fieldValue) {

                $row = $this->find()->where(['fieldName'=>$this->fieldName, 'fieldValue'=>$this->fieldValue])->orderBy('id desc')->one();

                if ($row) {
 
                    $this->lastCommit = $row->commit;

                } else {
                    $this->lastCommit = '';
                }
            }
        }   
        return true;
    }

    

    /**
     * 添加历史版本记录
     * @param [type] $model [description]
     */
    public function addHistory(ActiveRecord $model) {
        if ( $model instanceof ActiveRecord) {

        }
    }

    /**
     * 获得历史版本记录
     * 根据模型的主键和主键值
     * @param  [type] $model      模型
     * @param  [type] $lastCommit 上次提交版本 如果没有则获取所有的提交版本
     * @return [type]             [description]
     */
    public function getHistory($model, $lastCommit=null) {

    }

    public function getReview(){
        return $this->hasOne(MsupReview::className(), ['commit'=>'commit']);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lastCommit' => Yii::t('app', '上次提交版本'),
            'commit' => Yii::t('app', '当前版本'),
            'fieldName' => Yii::t('app', '模型主健字段名称'),
            'fieldValue' => Yii::t('app', '模型主键字段值'),
            'title' => Yii::t('app', '标题'),
            'comment' => Yii::t('app', '备注')
        ];
    }
}
