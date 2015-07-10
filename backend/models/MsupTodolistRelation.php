<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_todolist_relation".
 *
 * @property integer $id
 */
class MsupTodolistRelation extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_todolist_relation';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
        ];
    }
}
