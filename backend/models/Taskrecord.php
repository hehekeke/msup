<?php
namespace backend\models;
use yii\db\ActiveRecord;
/**
 * 任务详情模型
 */
class Taskrecord extends ActiveRecord{
    
    public static function tableName()
    {
        return 'msup_task_record';
    }
    
    public function scenarios()
    {
        return [
            'default' => ['recordid', 'taskid','lecturer_id'],
        ];
    }
    
}