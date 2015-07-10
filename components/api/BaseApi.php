<?php 
namespace components\api;

use Yii;
use yii\base\Object;
use yii\base\InvalidValueException;
use components\api\BaseErrorHandler;
/**
 * 基础Api类用于处理API请求及返回数据
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
class BaseApi  extends Object{
    // 错误处理的类
    private $_errorHandler;
    // 处理request的类
    private $_request;

    // 生成请求 HASH
    public function generateRequestHash($request){
        return md5($request.Yii::$app->request->pathInfo);
    }

    public function getRequest()
    {
        if (!$this->request) {
            $this->request = new \components\api\Request;
        }
        return $this->request;
    }
    public function setRequest($request = null)
    {
        if ($request) {
            $this->request = $request;
        }
    }
   /**
     * 设置错误处理的类
     * @param [type] $handler 将类的错误处理方法交给$handler来处理
     */
    public function setErrorHandler($handler){

        if (empty($handler)) {
            throw new InvalidValueException("不能传入空的API错误处理类,你可以传入错误处理类的类名或者直接传入类的实例");
            
        } else if (is_string($handler)) {
            if (class_exists($handler)) {
                $this->errorHandler = new $handler;
            } else if ( class_exists('\components\api\\'.ucfirst($handler)) ){
                $class = '\components\api\\'.$handler;
                $this->errorHandler = $class;
            } 
        } else {
            $this->errorHandler = $handler;
        }

    }

    //获得错误处理的类
    public function getErrorHandler(){
        

        if (empty($this->errorHandler)) {
            $this->errorHandler = new \components\api\BaseErrorHandler;

        } else if (is_string($this->errorHandler)) {

            $errorHandler = '\components\api\\'.ucfirst($this->errorHandler);
            $this->errorHandler = new $errorHandler;

        }
        return $this->errorHandler;

    }

    /**
     * 格式化API的查询语句
     * 如果参数存在关联查询，则递归调用本函数
     * @param  [array] $request 
     * @return [type] [description]
     */
    public function queryInit($request) {


        // 如果传入的参数不是数组或者传入的数组中没有指定模型则不执行此函数
        if (!is_array($request) || !$request['mm']) {
            return false;
        } 
       

        $request = $this->request->unFormatRequest($request);
        // 将传入的api健名格式化为框架对应的健名
        // 实例化模型
        $model = $this->getModel($request['model']);
       
        $query = $this->model->find();

        $query = $this->prepareQuery($query, $request);
        return $query;

    }
    
    public function getModel($modelName){
        $modelClass = '\backend\models\Msup'.ucfirst($modelName);
        $this->model = $this->checkModel($modelClass);
        return $this->model; 
    }

    public function setModel($modelName){
        if ($modelName) {
            $this->model = $modelName;
        }
    }
    /**
     * 将请求中的语句格式化成符合框架所用
     * @param  [Query]  $query  一个Query对象
     * 需要被格式化的数组
     * 格式如:
     * [
     *   'mw' => [],
     *   'ms' => [],
     * ]
     * @param  [array]  $request
     * @return [type]          [description]
     */
    private function prepareQuery($query, $request)
    {
        #todo
        if (empty($request)) return $query;
        // 判断该关联模型是否存在
        $model  = $this->getModel($request['model']);
        $select = $this->select($request['select']);
        $select = $this->mergeRelationField($select, $request['relation']);
        if ($request['relation']) {
            $relation = $this->relations($request['relation']);
            $query->with($relation);
        }
        
        unset($request['select']);
        unset($request['model']);
        unset($request['relation']);
        // 设置$query的where,select等参数
        foreach($request as $key => $value) {
           if (!empty($value))$query->$key($value);
        }

        if (!$request['orderBy']) {
            $query->orderBy($model->primaryKey()[0].' desc');
        }

        $query->select($select);
        return $query;
    }

    private function relations($relations){
        if (!$relations) return false;
        $relations = (is_string($relations)) ? [ 'model' => $relations]: $relations;
        $return = [];
        foreach($relations as $key => $v) {
            $return[$v['model']] = function($query) use ($v) {
                $query = $this->prepareQuery($query, $v);
            };
        }
        return $return;
    }

    private function select($select){
        if (empty($select)) $select = '*';
        if (is_string($select)) {
            $select = (strpos($select, ',')) ? explode(',', $select) : [$select];
        }
        return  $this->model->mergePrimary($select); 
    }

    // 自动合并关联关键
    private function mergeRelationField($select, $relations) {

        if (!empty($relations) && is_array($relations)){
            foreach($relations as $k => $relation) {   
                $select = $this->model->mergeLinkField($relation['model'], $select);
            } 
        }
        return $select;
    }

    /**
     * 检查模型是否存在
     * 如果存在就直接实例该模型否则直接输出错误
     * @return [type] [description]
     */
    public function checkModel($modelName) {
        if (empty($modelName) || !class_exists($modelName)){
            $errorHandler = $this->errorHandler;
            $errorHandler->setErrorCode($errorHandler::ERROR_CODE_3, $errorHandler::ERROR_MESSAGE_3);
        } else {
            return new $modelName;
        }
    }
  
}
?>