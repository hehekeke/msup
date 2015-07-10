<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_todolist".
 *
 * @property integer $id
 * @property string $listName
 * @property string $listClass
 */
class MsupTodolist extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_todolist';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['listName', 'listClass'], 'required'],
            [['listName'], 'string', 'max' => 50],
            [['listClass'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'listName' => Yii::t('app', '待办事项名称'),
            'listClass' => Yii::t('app', '待办事项绑定类'),
        ];
    }
    public function getTodolistRelation()
    {
        return $this->hasMany(MsupTodolistRelation::className(), ['listId' => 'id']);
    }
}
