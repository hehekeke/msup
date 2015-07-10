<?php
namespace backend\models;
use yii\db\ActiveRecord;
/**
 * 任务模型
 */
class Task extends ActiveRecord{
    
    public static function tableName()
    {
        return 'msup_task';
    }
    
    public function scenarios()
    {
        return [
            'default' => ['taskid', 'taskname'],
        ];
    }
    
}