<?php

namespace backend\models;

use Yii;
use yii\caching\DummyCache;

/**
 * This is the model class for table "msup_user_feedback".
 *
 * @property integer $feedid
 * @property integer $relationid
 * @property string $relationtype
 * @property integer $uid
 * @property integer $q8
 * @property integer $q7
 * @property integer $q6
 * @property integer $q5
 * @property integer $q4
 * @property integer $q3
 * @property integer $q1
 * @property integer $q2
 */
class MsupUserFeedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_user_feedback';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['relationid', 'uid', 'q8', 'q7', 'q6', 'q5', 'q4', 'q3', 'q1', 'q2'], 'integer'],
            [['relationtype'], 'string', 'max' => 50],
            [['relationid', 'relationtype', 'uid'], 'unique', 'targetAttribute' => ['relationid', 'relationtype', 'uid'], 'message' => '您已经反馈过了！'],
            [['q1','q2','q3','q4','q5','q6','q7'], 'ansisright','message'=>'反馈信息填写错误'],//答案检查
            [['relationtype', 'uid','q1','q2','q3','q4','q5'], 'required','message'=>'反馈填写不完整'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'feedid' => 'Feedid',
            'relationid' => 'Relationid',
            'relationtype' => 'Relationtype',
            'uid' => 'Uid',
            'q8' => 'Q8',
            'q7' => 'Q7',
            'q6' => 'Q6',
            'q5' => 'Q5',
            'q4' => 'Q4',
            'q3' => 'Q3',
            'q1' => 'Q1',
            'q2' => 'Q2',
        ];
    }
    
    /**
     * 判断是不是指定的值得范围
     */
    public function ansisright($attribute,$params) {
        $value = $this->$attribute;
//         var_dump($value);exit;
        if(empty($value)){
            return true;
        }
        if(in_array($value, array('1','2','3','4'))){
            return true;
        }else{
            $this->addError($attribute, '答案格式错误');
            return false;
        }
    }
}
