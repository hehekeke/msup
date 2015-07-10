<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_lecturer_assignment".
 *
 * @property integer $id
 * @property integer $lecturer_id
 * @property integer $user_id
 * @property integer $status 维护状态 0:取消维护，1:正在维护
 */
class MsupLecturerAssignment extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_lecturer_assignment';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['lecturer_id', 'user_id', 'status'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'lecturer_id' => Yii::t('app', '教练ID'),
            'user_id' => Yii::t('app', '用户ID'),
            'status' => Yii::t('app', '维护状态'),
        ];
    }

    // public function beforeSave($insert) {
    //     if (parent::beforeSave($insert)) {
    //         $lid     = $this->lecturer_id;
    //         $user_id = $this->user_id;
    //         $this->updateAll(["status"=>0],["lecturer_id" => $lid]);
    //     }
    //     return true;
    // }

    public function getUser(){
        return $this->hasOne(\dektrium\user\models\User::className(), ['id' => 'user_id']);
    }

    public function afterSave($insert,$changedAttributes) {
        parent::afterSave($insert, $changedAttributes);
        $this->setStatusOnly('id='.$this->id, 'lecturer_id = '.$this->lecturer_id);
    }
}
