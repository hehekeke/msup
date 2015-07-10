<?php

namespace backend\modules\Ticket\models;

use Yii;
use yii\helpers\ArrayHelper;
use backend\models\MsupScheduling;
/**
 * This is the model class for table "msup_scheduling_tickets".
 * 门票种类与排课关联模型
 * @property integer $id
 * @property integer $tid
 * @property integer $sid
 * @property integer $uper
 * @property integer $create_admin
 * @property integer $sold
 */
class MsupSchedulingTickets extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_scheduling_tickets';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tid', 'sid', 'uper', 'create_admin', 'sold'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'tid' => Yii::t('app', '门票的种类'),
            'sid' => Yii::t('app', '排课'),
            'uper' => Yii::t('app', '门票数量'),
            'create_admin' => Yii::t('app', '添加人'),
            'sold' => Yii::t('app', '已售门票'),
        ];
    }
    /**
     * 获取排课的门票种类
     * @param  [type] $schedulingId [description]
     * @return [type]               [description]
     */
    public function getTicketsBySchedulingId($schedulingId){
        $tickets = $this->find()->select('*,'.$this->tableName().'.id as id')->where([$this->tableName().'.sid' => $schedulingId])->innerJoin(MsupTickets::tableName(), $this->tableName().'.tid = '. MsupTickets::tableName().'.id')->asArray()->all();
        $tickets = ArrayHelper::map($tickets, 'id', 'title');
        return $tickets;
    }   
    public function getTickets(){
        return $this->hasOne(MsupTickets::className(),['id' => 'tid']);
    }
    public function getScheduling($value='')
    {
        return $this->hasOne(MsupScheduling::className(), ['id' => 'sid']);
    }
}
