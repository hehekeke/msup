<?php 
namespace components\api;

use Yii;
class Request {
	public function unFormatRequest($request) {
		if (!is_array($request)) {
			return false;
		} else {
			$request = $this->unFormatKeyMap($request);
			$request['model'] = $this->unFormatModel($request['model']);
			$request = $this->unFormatValue($request);
		}
		return $request;
	}

	public function unFormatValue($request)
	{
		foreach($request as $k => &$v) {

			if ($k != 'model' && $k !='relation') {
				$v = $this->unFormatField($v, $request['model']);
			} else if ($k == 'relation') {
				$v = $this->unFormatRelation($v);
			}
		}
		return $request;
	}

	public function unFormatRelation($relation){

		$relation = is_string($relation) ? [$relation => ['mm' => $relation]]:$relation;
		$realtions = [];
		foreach ($relation as $relationName => $value) {	
			if (is_string($value) || empty($value)) {
				$realtions[] =  $this->unFormatModel($relationName);
			} else {
				$value['mm'] = isset($value['mm']) ? $value['mm'] : $relationName;
				$realtions[] = $this->unFormatRequest($value);
			}
		}
		return $realtions;
	}


	/**
     * 字段名映射
     * 当传入的modelName为映射后的modelName时，先将其反转，再获取
     * @param  string  $modelName 模型名
     * @param  String  $field     字段
     * @param  boolean $flip      是否反转
     * @return [type]            [description]
     */
    private static function fieldMap($modelName, $field=null, $flip=false) {

        $map = Yii::$app->params['fieldMap'];
        $modelName = self::modelMap($modelName);

        if ($modelName && $field)
        {
            // 反转健名
            if ( !in_array( $field, array_keys( $map[$modelName] ) ) && in_array( $field, array_values($map[$modelName]) ) ) 
            {
                $map[$modelName] = array_flip($map[$modelName]);

            }else {
                return $field;
            }
            return $map[$modelName][$field];
        }  else if ($modelName)  {
            return $map[$modelName];
        } else { 
            return $model;
        }
    }

    /**
     *  模型名称映射
     *  如果传入的$name是$modelMap的值,则直接返回,否则$modelMap返回对应的值  
     * @param  String $name [description]
     * @return [type]       [description]
     */
    private static function modelMap($name) {

        $modelMap = Yii::$app->params['modelMap'];
        if ( !in_array( $name, array_keys( $modelMap ) ) && in_array( $name, array_values($modelMap) ) ) {
               return $name;
        }

        return $modelMap[$name];
    }

    private static function keyMap($keyName) {
    
        $keyMap = Yii::$app->params['keyMap'];
        return  in_array($keyName, array_keys($keyMap)) ? $keyMap[$keyName] : $keyName;
    }
    public function unFormatModel($modelName) {
    	return $this->modelMap($modelName);
    }
 	/**
     * 健名映射解析
     * @param  [type] $array [需要被解析的数组]
     * @return [type]        [解析之后的数组]
     */
    private function unFormatKeyMap($array) {

        if (is_array($array)) {
            // 健名映射
            foreach ($array as $key => $v) {
                $tkey = self::keyMap($key);
                $array[$tkey] = $array[$key];
                if ($tkey != $key) unset($array[$key]);
            }
        } else {
            $array = self::modelMap($array);
        }
        return $array;
    }

    /**
     * 健名解析
     * [unFormatField description]
     * @param  [string] $model [需要被解析的模型]
     * @param  [string] $where [需要被解析的语句]
     * @return [type]        [description]
     */
    protected function unFormatField($fields, $model = null){

        // 通过字段字典得到映射的真实字段名
        if (is_array($fields) && !empty($fields)) {
            foreach($fields as $key => $v) {
                $tkey = self::fieldMap($model, $key);
                $fields[$tkey] =  $fields[$key];
                unset($fields[$key]);
            }
        } else if (is_string($fields)){
            
            foreach(self::fieldMap($model) as $key => $v) {
                $fields = str_replace(trim($v),$key, $fields);

            }
        }
        return $fields;                       
    }
}

?>