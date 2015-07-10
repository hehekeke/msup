<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "msup_crontab_notice".
 *
 * @property integer $id
 * @property string $title
 * @property integer $hasDo
 * @property string $created_at
 */
class MsupCrontabNotice extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_crontab_notice';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['hasDo'], 'integer'],
            [['title'], 'string', 'max' => 100],
            [['created_at'], 'string', 'max' => 20]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'title' => Yii::t('app', '定时任务描述'),
            'hasDo' => Yii::t('app', '是否触发'),
            'created_at' => Yii::t('app', '触发时间'),
        ];
    }
    public function create($title, $hasDo = 1)
    {
        $this->title = $title;
        $this->hasDo = $hasDo;
        $this->created_at = (String)time();
        $this->save();
        return $this->id;
    }
}
