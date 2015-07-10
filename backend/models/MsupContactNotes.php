<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_contact_notes".
 *
 * @property integer $id
 * @property integer $toId
 * @property integer $userid
 * @property integer $toModel
 * @property string $notes
 * @property string $remarks
 * @property integer $created_at
 * @property string $contactType
 */
class MsupContactNotes extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_contact_notes';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['toId', 'userid', 'toModel', 'created_at'], 'integer'],
            [['notes', 'remarks'], 'string', 'max' => 255],
            [['contactType'], 'string', 'max' => 30 ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'toId' => Yii::t('app', '接收消息的记录'),
            'userid' => Yii::t('app', '发送消息的用户'),
            'toModel' => Yii::t('app', '接收消息的模型'),
            'notes' => Yii::t('app', '联系目的'),
            'remarks' => Yii::t('app', '备注'),
            'created_at' => Yii::t('app', '创建时间'),
            'contactType' => Yii::t('app', '联系方式'),
        ];
    }
    public function beforeSave($insert) {

        if (parent::beforeSave($insert)) {
            $this->userid  = Yii::$app->user->identity->id;
            $this->toModel = Yii::$app->request->post()['toModel'] ? Yii::$app->request->post()['toModel'] : Yii::$app->request->get('toModel');
            $this->toId = $this->toId ? $this->toId : Yii::$app->request->get('toId');
            $this->setCreateInfo();

            if ( $this->isNewRecord && !$this->lastContact ) {
                $this->lastContact = 1;
            }
            $this->updateAll(['lastContact' => 0], 'toId = '.$this->toId.' AND toModel='.$this->toModel); 

        }

        return true;
    }

    public function afterSave($insert, $changedAttributes) {

        parent::afterSave($insert, $changedAttributes);
        $model = new MsupModel;
        $row = $model->findOne( ['id' => $this->toModel] );
        $className = $row->modelClass;

        // 接收联系信息的模型
        $toModel = new $className;

        // 查找对应的记录，并更新时间和用户
        $toModelRow = $toModel->findOne( [ $toModel->primaryKey()[0] => $this->toId ] );

        if($toModel->hasAttribute('updated_at')) $toModelRow->updated_at = time();

        if ( $toModel->hasAttribute('update_admin') ) $toModelRow->update_admin = Yii::$app->user->identity->id;
        Yii::$app->request->setBodyParams('');
        $toModelRow->update();

    }
}
