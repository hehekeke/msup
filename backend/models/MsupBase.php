<?php 
namespace backend\models;
use Yii;
use dektrium\user\models\User;
use backend\models\MsupModel;
use backend\models\MsupAttachment;

use yii\web\NotFoundHttpException;
use yii\helpers\ArrayHelper;
use yii\web\Session;

/**
 * 模型基础父类
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
class MsupBase extends \yii\db\ActiveRecord
{
	private $_modelId;    

    public function getModelId() {

        if (!$this->_modelId) {
            $model = MsupModel::findOne([ 'modelClass' => $this::className() ]);
            $this->_modelId = $model->id;
        }
        return $this->_modelId;

    }


    public function setModelId($modelId) {
        if (!$modelId) {
            $model = MsupModel::findOne([ 'modelClass' => $this::className() ]);
            $this->_modelId = $model->id;
        } else {
            $this->_modelId = $modelId;
        }
    }
	public function beforeSave($insert)
    {	

        $session = new Session;

    	if ( $this->isNewRecord )
    	{
            $this->setCreateInfo();
    	}

    	if($this->hasAttribute('updated_at') && !$this->updated_at) $this->updated_at = time();

    	if ( $this->hasAttribute('update_admin')  && !$this->update_admin) {
    		$this->update_admin = Yii::$app->user->identity->id;
    	}

    	return true;

    } 

    
    public function afterSave($insert, $changedAttributes) {
        
        parent::afterSave($insert, $changedAttributes);
       
        $attachment = new  MsupAttachment;
        $session = new Session;
        // 添加完成后更新附件表
        $attachment->updateAll([ 'modelPk' => $this->primaryKey], ['modelId' => $this->modelId, 'hash' => $session->get('hash')]);  
        $attachment->updateAll([ 'hash' => ''], ['modelPk' => $this->primaryKey]);  


        // 处理有标签的模型的记录添加情况
        if ( isset( Yii::$app->request->post()['MsupTagRelation'] ) && !empty(Yii::$app->request->post()['MsupTagRelation']) ) {

            $msupTagRelation = new MsupTagRelation;
            $msupTagRelation->tagRelationAddByPost($this);
        }
        $session->remove('hash');
    
    }
    
    /**
     * 设置表中某个字段值唯一
     * @param Array  $param 字段
     * @param mixed  $value 设置的值 
     * @param Array  $condition  匹配条件。$condition[0] 设置唯一值的条件，$condition[1]搜索其他条件。
     * @param mixed  $change 其他记录的值
     */
    public function setOnly(Array $condition,Array $param){

        $this->updateAll($param[1], $condition[1]);
        $this->updateAll($param[0], $condition[0]);
    }

    /**
     * 设置status字段值唯一
     * @param [type] $condition  设置条件 如 id = 5;
     * @param [type] $pramaryKey 匹配主健名称和值 如： lecturer_id = 1;
     * @see setOnly();
     */
    public function setStatusOnly($condition,$primaryKey)
    {
        $con[0] = $condition;
        $con[1] = $primaryKey;
        $param[0] = ['status'=>1];
        $param[1] = ['status'=>0];
        $this->setOnly($con, $param);
    }

    public function setCreateInfo() {

        if ($this->hasAttribute('created_at') && !$this->created_at) $this->created_at = time();
        if ($this->hasAttribute('create_admin') && !$this->create_admin) $this->create_admin = Yii::$app->user->identity->id;
             
    }

    // 获得model的namespaceName
    public function getNamespace(){

        $reClass = new \ReflectionClass($this);
        $namespace = $reClass->getNamespaceName();
        return $namespace;
    }

    /**
     * 获取不带命名空间的类名
     * @return [type] [description]
     */
    public function getClassName(){
        $reClass = new \ReflectionClass($this);
        return $reClass->getShortName();
    }
    public function getControllerName() {
      
       return  strtolower(  substr( $this->className(), strlen($this->getNamespace()) + strlen(Yii::$app->db->tablePrefix )) );
    }   

    /**
     * 检查记录是否存在，如果没有则新建一个
     * @param  [type]  $condition   [description]
     * @param  [array] $setValue    [需要为字段设置的值]
     * @return [type]            [description]
     */
    public function ifNotExistsThenCreateOne($condition, array $setValue = []){
        $row = $this->find()->where($condition)->one();
        $params = Yii::$app->request->post();

        if (!empty($setValue)) {
           $params[$this->formName()] =  empty($params)? $setValue : array_merge($setValue,$params[$this->formName()]);
        }

        if (!$row->primaryKey) {
            $this->load($params);
            $this->save();
            $row = clone $this;
        } 
        $row->load($params);
        $row->save();
        return $row;
    }   

    /**
     * 检查是否有主键在参数字符串或者字段数组中，如果没有则将当前模型的主键合并进去
     * @param  mixed  $field 需要被合并的字段
     * @return [type] $field [description]
     */
    public function mergePrimary($field = []) {
        if (empty($field)) return '*';
        //字符串形式 
        if (is_string($field)) {
            if (!strpos($field, $this->primaryKey()[0])) {
                $field .= ','.$this->primaryKey()[0];
            }
            $field = explode(',', $field);
        } else {
            if (!in_array($this->primaryKey()[0], $field)) {
                $field[] = $this->primaryKey()[0];
            }
        }

        return $field;
    }

    /**
     * 合并关联字段
     * @param  [type] $relationName [description]
     * @param  array  $field        [description]
     * @return [type]               [description]
     */
    public function mergeLinkField($relationName, $field = []){

        $method = 'get'.ucfirst($relationName);
        $link  =   call_user_func(array($this, $method));
        if (!is_array($field) || empty($field)) $field = [];
        foreach($link->link   as $foreignKey => $modelKey ) { 

            if (!in_array($modelKey, $field)) {
                $field[] = $modelKey;
            }

        }
        if ($field[0] == '') unset($field[0]);
        return $field;
    }
    /**
     * 获得附件表中的记录
     * @param  [string] $field [需要获取的附件字段名]
     * @return [type]        [description]
     */
    public function getAttachment($field = null) {
        return $this->hasMany(MsupAttachment::className(), [ 'modelId' => $this->_modelId, 'modelPk' => $this->primaryKey, 'field'=> $field]);
        return null;
    }
    /**
     * 设置默认属性值
     * @param [type] $name  [description]
     * @param [type] $value [description]
     */
    public function setDefault($name, $value) {

        if (in_array($name, $this->attributes()) && empty($this->$name) && !empty($value)) {
            $this->$name = $value;
        }
    }
    // 检查该模型是否拥有某个标签
    public function hasTag($tagId, $pkId = 0) {
        $model = MsupModel::findOne( ['modelClass' => $this->getNamespace()] );

        $pkId  = ($pkId) ? $pkId : $this->primaryKey;
        $row = MsupTagRelation::findOne( ['tagId'=>$tagId, 'modelId' =>$this->modelId, 'pkId'=> $pkId] );
        return $row->id>0 ? true : false;
    }
    public function getUser() {
        if ($this->hasAttribute('create_admin')) {
            return $this->hasOne(\dektrium\user\models\User::className(), ['id' => 'create_admin']);
        } else {
            throw NotFoundHttpException('该模型没有 {create_admin} 字段');
        }
    }

}


?>