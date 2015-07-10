<?php

namespace backend\models;

use Yii;

/**
 * This is the model class for table "{{%auth_item}}".
 *
 * @property string $name
 * @property integer $type
 * @property string $description
 * @property string $rule_name
 * @property string $data
 * @property integer $created_at
 * @property integer $updated_at
 *
 * @property AuthAssignment[] $authAssignments
 * @property AuthRule $ruleName
 * @property AuthItemChild[] $authItemChildren
 */
class MsupAuthItem extends \backend\models\MsupBase
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%auth_item}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'type', 'description'], 'required'],
            [['type', 'created_at', 'updated_at'], 'integer'],
            [['description', 'data'], 'string'],
            [['name', 'rule_name'], 'string', 'max' => 64]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'name' => '访问权限',
            'type' => '类型',
            'description' => '描述',
            'rule_name' => '应用规则',
            'data' => '参数',
            'created_at' => '添加人',
            'updated_at' => '最后更新',
        ];
    }
    
    // 删除权限
    public function deleteItem(){

        $auth = Yii::$app->authManager;
        if ( $auth->removePermissions($this->name, $this->type) ) {
            return true;
        }
    }

    //更新角色权限
    public function updateItem(){
        $auth = Yii::$app->authManager;
        $pre  = (object) $this->attributes;
        return $auth->updatePermesiion($this->oldAttributes['name'], $pre);

    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthAssignments()
    {
        return $this->hasMany(MsupAuthAssignment::className(), ['item_name' => 'name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRuleName()
    {
        return $this->hasOne(MsupAuthRule::className(), ['name' => 'rule_name']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthItemChildren()
    {
        return $this->hasMany(MsupAuthItemChild::className(), ['parent' => 'name']);
    }

}
