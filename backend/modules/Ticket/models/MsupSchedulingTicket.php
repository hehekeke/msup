<?php

namespace backend\modules\Ticket\models;

use Yii;
use backend\models\MsupUserMember;
use backend\models\MsupMemberInfo;
use backend\models\MsupScheduling;
use backend\models\MsupSettings;
use backend\modules\Ticket\models\MsupTickets;
use backend\modules\Ticket\components\TicketShortMessage;
use backend\modules\Ticket\components\TicketMail;
/**
 * This is the model class for table "msup_scheduling_ticket".
 *
 * @property integer $id
 * @property integer $stid
 * @property string $bank
 * @property integer $isSelled
 * @property integer $isActivation
 * @property string $verifyPassword
 * @property string $purchase
 * @property string $owner
 * @property integer $sid
 * @property integer $create_admin
 * @property integer $update_admin
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $actived_admin
 * @property string  $linkUrl 原文地址
 * @property string  $sendType 发送状态
 */ 
class MsupSchedulingTicket extends \backend\models\MsupBase
{
    private $_selledLabel;
    private $_activiedLabel;
    private $_redirctUrl;
    //readOnly
    public function getSelledLabel($isSelled = 0){
        $selledLabel = ['0' => '否', '1' => '已售'];
        return $selledLabel;
    }
    //readOnly
    public function getActiviedLabel($isActivation = 0) {
        $activedLabel = ['0' => '未签到', '1' => '已签到'];
        return $activedLabel;
    }

    public function getRedirctUrl(){
        if (!$this->redirctUrl) {
            $this->setRedirctUrl('http://api.buzz.cn/index.php/Wap/index/');
        }
        return $this->redirctUrl;
    }

    public function setRedirctUrl($redirctUrl){
        if ($redirctUrl) {
            $this->redirctUrl = $redirctUrl;
        }
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_scheduling_ticket';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['sid'], 'required'],
            [['linkUrl'], 'string', 'max' => 300],
            [['stid', 'isSelled', 'isActivation', 'sid', 'create_admin', 'update_admin', 'created_at', 'updated_at', 'actived_admin'], 'integer'],
            [['bank', 'verifyPassword'], 'string', 'max' => 20],
            [['purchase', 'owner'], 'integer']
        ];
    }
    public function beforeSave($insert)
    {
        if ( parent::beforeSave($insert) ) {
            $this->isSelled = 1;
        }
        return true;
    }
    public function afterSave($insert, $changeAttributes){
        parent::afterSave($insert, $changeAttributes);
        $userMember = new MsupUserMember;
        $post = Yii::$app->request->post();
        if ($post[$userMember->formName()]['phone']) {            
                $shortMessage = new TicketShortMessage($this);
                $shortMessage->sendSuccessMessage($post[$userMember->formName()]['phone']);
        } 
        if ($post[$userMember->formName()]['email']) {
            $mail = new TicketMail($this, $post[$userMember->formName()]['email']);
            $mail->sendEmail();
        }

        \backend\models\MsupScheduling::updateAllCounters(['applicans' => 1], ['id' => $this->sid]);
    }

    // public function sendSortMessage($phone){
    //     $shortMessage = Yii::$app->ShortMessageManager;
    //     $shortUrl = $this->getShortUrl();
    //     $schedulingTickets = $this->getSchedulingTickets()->one();
    //     $scheduling = $schedulingTickets->getScheduling()->one();
    //     // $message = '感谢您的参加我们的 XXX 课程，您的门票号为：'.$this->bank.'。点击 '.$shortUrl['shortUrl'].' 查看详细信息。【麦思博】';
    //     $message = '出票成功！《'.$scheduling->title.'》将于'.date('Y年m月d日 H点i分', $scheduling->startTime).'开始，请凭票号'.$this->bank.'提前30分钟至会场签到。 '.$shortUrl['shortUrl'].' 点击链接查看活动详细信息。【麦思博】';
    //     $res = $shortMessage->sendShortMessage($phone, $message);
    //     if ($res['error'] == 0) {
    //         return true;
    //     } else {
    //         $this->errors = $res['message'];
    //         return false;
    //     }
    // }

    public function setErrors($error){
        $this->errors = $error;
    }
    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'stid' => Yii::t('app', '排课的门票类型'),
            'bank' => Yii::t('app', '票号'),
            'isSelled' => Yii::t('app', '是否出售'),
            'isActivation' => Yii::t('app', '是否签到'),
            'verifyPassword' => Yii::t('app', '验证密码'),
            'purchase' => Yii::t('app', '购买人'),
            'owner' => Yii::t('app', '门票的拥有者'),
            'sid' => Yii::t('app', '排课的 ID'),
            'create_admin' => Yii::t('app', '出票人'),
            'update_admin' => Yii::t('app', 'Update Admin'),
            'created_at' => Yii::t('app', '出票时间'),
            'updated_at' => Yii::t('app', '资料更新时间'),
            'actived_at' => Yii::t('app', '激活时间'),
            'linkUrl' => Yii::t('app', '原文链接'),
        ];
    }

    /**
     * 生成随机票号
     * @param  integer $len [description]
     * @return [type]       [description]
     */
    public function createBank($len=8){
        $bank = rand(str_pad(1, $len, 0, STR_PAD_RIGHT), str_pad(1, $len+1,0,STR_PAD_RIGHT));
        $model = $this->find()->where(['bank' => $bank])->one();
        if ($model->id) {
            $this->createBank($len);
        } else {
            return (string)$bank;
        }

    }
    // 保存用户信息，如果没有该用户的信息则会新建一个
    public function saveOwnerInfo(){
        $userModel = new MsupUserMember;
        $memberInfoModel = new MsupMemberInfo;
        if(!empty(Yii::$app->request->post()[$userModel->formName()]['phone'])) {

            $user = $userModel->ifNotExistsThenCreateOne(['phone' => Yii::$app->request->post()[$userModel->formName()]['phone']]);
        } else {
            $user = $userModel->createVirtualMember();
        }
        if (!empty($user->id)) {
            $member = $memberInfoModel->ifNotExistsThenCreateOne(['userId' => $user->id], ['userId'=>$user->id]);
        } else if (!empty(Yii::$app->request->post()[$memberInfoModel->formName()]['name'])) {
            $memberInfoModel->load(Yii::$app->request->post());
            $memberInfoModel->save();
        }
        // 设置门票的购买者和拥有者
        $this->purchase = $this->owner = !empty($user->id) ? $user->id : 0;
        return true;

    }
    /**
     *  通过更新拥有者信息
     * @param  string $bank  [description]
     * @return [type]        [description]
     */
    public function updateOwnerInfo($info)
    {   

        $userModel = new MsupUserMember;
        $memberInfoModel = new MsupMemberInfo;
        $user = $userModel->findOne($this->owner);
        if (!$user->id) $user = $userModel;
        if ($this->checkPhoneExsits($info['phone'],$user) ){
            $user = $userModel->find()->where(['phone' => $phone])->orWhere()->one();
        }
        
        if (!empty($info['phone'])) {
            if (strpos($info['phone'], '*') && $user->phone) {
                if (substr($info['phone'], 7) == substr($user->phone, 7)) {
                    $info['phone'] = $user->phone;
                } else {
                    $this->echoError(4,'错误的手机号码');
                }
            } else if (!preg_match('/^1{1}\d{10}$/', $info['phone'])) {
                $this->echoError(4,'错误的手机号码');
            }
        }
        // 用户不存在时将新增一个用户
        $user->setAttributes($info);
        if ($user->save()){
            $member = $memberInfoModel->findOne(['userId' => $user->id]);
            if (!$member) $member = $memberInfoModel;
            if (!$member->id) {
                $member->userId = $user->id;
            }
            $member->setAttributes($info);
            $member->save();
        }

        $return['errno'] = 0;
        $return['userId'] = $user->id;
        return $return;
    }
    public function echoError($errno, $errmsg){
        echo json_encode([ 'errno' => $errno, 'errmsg' => $errmsg]);exit;
    }
    /**
     * 检查手机号码是否存在，如果存在，但并不归用户$user 所有则提示已存在
     * @param  [type] $infoPhone 手机号
     * @param  [type] $user      用户
     * @return [type]            [description]
     */
    public function checkPhoneExsits($infoPhone, $user) {
        $userModel = new MsupUserMember;
        $hasOne = $userModel->find()->where(['phone' => $infoPhone])->orWhere(['username' => $infoPhone])->one();
        if (($user->id && $hasOne->id && ($hasOne->id != $user->id)) || (!$user->id && $hasOne->id)) {
            return true;
        } else {
            return false;
        }
    }
    public function afterDelete(){
        parent::afterDelete();
        $owner = $this->owner;
        $schedulingModel =  new \backend\models\MsupScheduling;
        $schedulingModel->updateAllCounters(['applicans' => '-1'], ['id' => $this->sid]);
        $userMemberModel = new MsupUserMember;
        $member = $userMemberModel->findOne($owner);
        if ($member->id) {
            if ($member->phone) {
                $shortMessage = new TicketShortMessage($this);
                if(Yii::$app->controller->action->id == 'move-ticket')$shortMessage->sendMoveTicketMessage($member->phone);
            }
            // if ($member->email) {
            //     $email = new TicketMail($this, $member->email);
            //     $email->sendMoveTicketEmail();
            // }
        }
    }

    /**
     * 获得门票的拥有者相关信息
     * @param  [type] $bank [description]
     * @return [type]       [description]
     */
    public function getTicketInfo($bank){
        $ticketInfo = $this->find()->where(['bank' => $bank])->with('scheduling')->with('schedulingTickets')->asArray()->one();
        if ($ticketInfo['id']) {
            $userMember = new MsupUserMember;
            $ticketInfo['userInfo'] = $userMember->getMemeberFullInfo(['id' => $ticketInfo['owner']]);
            $ticketModel = new MsupTickets;

            if (!preg_match('/^1{1}\d{10}$/', $ticketInfo['userInfo']['phone'])) {
                $ticketInfo['userInfo']['phone'] = '';
            }
            // 剔除掉不要的数据
            if(isset($ticketInfo['userInfo']['memberInfo']['phone']) && !empty($ticketInfo['userInfo']['memberInfo']['phone'])) unset($ticketInfo['userInfo']['memberInfo']['phone']);
            $ticketInfo['tickets'] = $ticketModel->find()->where(['id' => $ticketInfo['schedulingTickets']['tid']])->asArray()->one();
            return $ticketInfo;
        } else {
            return '';
        }
    }

    public function getScheduling(){
        return $this->hasOne(MsupScheduling::className(), ['id' => 'sid']);
    }
    public function getUserMember(){
        return $this->hasOne(MsupUserMember::className(), ['id' => 'owner']);
    }
    public function getSchedulingTickets(){
        return $this->hasOne(MsupSchedulingTickets::className(), ['id' => 'stid']);
    }

    public function getUserMemberInfo(){
        return $this->hasOne(MsupMemberInfo::className(), ['userId' => 'owner']);
    }
}
