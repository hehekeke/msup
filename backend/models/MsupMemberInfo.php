<?php

namespace backend\models;

use Yii;
/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
/**
 * This is the model class for table "msup_member_info".
 *
 * @property integer $id
 * @property string $name
 * @property string $company
 * @property string $position
 * @property string $thumbs
 * @property string $birthday
 * @property integer $level
 * @property string $sex
 * @property string $role
 * @property integer $siteId
 * @property string $email
 * @property string $phone
 * @property integer $userId
 * @property string $lastLoginTime
 *
 * @property UserMember $user
 */
class MsupMemberInfo extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'msup_member_info';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['birthday', 'lastLoginTime'], 'safe'],
            [['level', 'siteId', 'userId'], 'integer'],
            [['sex'], 'string'],
            // [['userId', 'company', 'position', 'name'], 'required'],
            [['name', 'position'], 'string', 'max' => 40],
            [['company'], 'string', 'max' => 100],
            [['thumbs'], 'string', 'max' => 300],
            [['role'], 'string', 'max' => 11],
            [['email'], 'string', 'max' => 50],
            [['phone'], 'string', 'max' => 20]
        ];
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('app', 'ID'),
            'name' => Yii::t('app', '姓名'),
            'company' => Yii::t('app', '公司'),
            'position' => Yii::t('app', '职位'),
            'thumbs' => Yii::t('app', '头像'),
            'birthday' => Yii::t('app', '生日'),
            'level' => Yii::t('app', '会员等级'),
            'sex' => Yii::t('app', '性别'),
            'role' => Yii::t('app', '角色'),
            'siteId' => Yii::t('app', '来源站点'),
            'email' => Yii::t('app', '邮箱'),
            'phone' => Yii::t('app', '手机'),
            'userId' => Yii::t('app', '用户ID'),
            'lastLoginTime' => Yii::t('app', '最后登录时间'),
        ];
    }
    /**
     * 创建一个用户资料
     * @param  [ array] $attributes [description]
     * @return [type]             [description]
     */
    public function create(array $attributes){
        $this->setAttributes($attributes);
        if ($this->save()) {
            return $this;
        } else {
            return $this;
        }
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(UserMember::className(), ['id' => 'userId']);
    }
}
