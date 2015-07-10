<?php

namespace backend\models;

use Yii;

use dektrium\user\helpers\Password;
use yii\web\IdentityInterface;
/**
 * This is the model class for table "msup_user_member".
 *
 * @property integer $id
 * @property string $username
 * @property string $email
 * @property string $password_hash
 * @property string $auth_key
 * @property integer $confirmed_at
 * @property string $unconfirmed_email
 * @property integer $blocked_at
 * @property string $role
 * @property integer $registration_ip
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $flags
 * @property string  $phone
 * @property string $password_reset_token
 * @property string $sourceSite
 *
 * @property MemberInfo[] $memberInfos
 */
class MsupUserMember extends \backend\models\MsupBase implements IdentityInterface
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_user_member';
    }
    public function beforeSave($insert){
        if (parent::beforeSave($insert)) {
            if ($this->isNewRecord || (!$this->isNewRecord && !$this->auth_key)) {
                $this->setAttribute('auth_key', \Yii::$app->security->generateRandomString());
            }
            if (!$this->username && $this->phone) $this->username = $this->phone;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['confirmed_at', 'create_admin', 'update_admin', 'blocked_at', 'registration_ip', 'created_at', 'updated_at', 'flags', 'isVirtual', 'source_site'], 'integer'],
            // [['phone', 'email'], 'required'],
            [['phone'], 'string', 'max' => 15],
            [['username'], 'string', 'max' => 25],
            [['email', 'unconfirmed_email'], 'string', 'max' => 255],
            [['password_hash', 'password_reset_token'], 'string', 'max' => 60],
            [['auth_key'], 'string', 'max' => 32],
            [['role'], 'string', 'max' => 64],
        ];
    }
    // 创建一个会员
    public function create($attributes){
        $this->setAttributes($attributes);
        $this->setPassword($attributes['password']);
        if ($this->save()) {
            return $this;
        } else {
            return $this;
        }
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'phone' => '用户手机号',
            'username' => Yii::t('app', '用户帐号'),
            'email' => Yii::t('app', '用户邮箱'),
            'password_hash' => Yii::t('app', '用户密码'),
            'auth_key' => Yii::t('app', '验证口令'),
            'confirmed_at' => Yii::t('app', '确认时间'),
            'unconfirmed_email' => Yii::t('app', 'Unconfirmed Email'),
            'blocked_at' => Yii::t('app', '锁定时间'),
            'role' => Yii::t('app', '角色'),
            'registration_ip' => Yii::t('app', '注册Ip'),
            'created_at' => Yii::t('app', '注册时间'),
            'updated_at' => Yii::t('app', '更新时间'),
            'flags' => Yii::t('app', 'Flags'),
            'isVirtual' => Yii::t('app', '虚拟账户'),
            'password_reset_token' => Yii::t('app', 'Password Reset Token'),
            'source_site' => Yii::t('来源站点'),
        ];
    }

    // 验证密码是否正确
    public function validatePassword($password){
        if ($this->id === null || !Password::validate($password, $this->password_hash)) {
            $this->addError('password', '用户名、密码错误');
        } else {
            return true;
        }
    }
    // 实现接口方法
    public static function findIdentityByAccessToken($token, $type = null) {

    }

    // 通过会员 ID 找到该会员
    public static function findIdentity($id){
        return static::findOne($id);
    }

    // 获得用户 ID
    public function getId() {
        return $this->getAttribute('id');
    }

    public function getAuthKey() {
        return $this->getAttribute('auth_key');
    }

    public function validateAuthKey($authKey)
    {
        return $this->getAttribute('auth_key') == $authKey;
    }

    // 获取会员完整信息
    public function getMemeberFullInfo($condition){

        return $this->find()->where($condition)->with('memberInfo')->asArray()->one();
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMemberInfo()
    {
        return $this->hasOne(MsupMemberInfo::className(), ['userId' => 'id']);
    }
    public function getOneMemberByPhone($phone){
        return $this->find()->where(['phone' => $phone])->orWhere(['phone' => $phone])->one();
    }

    // 设置密码哈希。将用户密码加密
    private function setPassword($password) {
        $this->password_hash = Password::hash($password);
    }
    /**
     * 创建虚拟用户
     * @return [type] [description]
     */
    public function createVirtualMember(){
        $this->load(Yii::$app->request->post());
        $this->username = Yii::$app->security->generateRandomString(11);
        $this->isVirtual = 1;
        $this->save();
        return $this;
    }
    public function resetPassword($password){
        $this->setPassword($password);
        $this->updateAll(['password_hash' => $this->password_hash], ['id' => $this->id]);
    }
}
