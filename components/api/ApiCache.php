<?php
namespace components\api;
use Yii;
class ApiCache {

	public function checkCache($key)
	{
		$return = Yii::$app->cache->getValue($key);
		if (!empty($return)) {
			return $return;
		}
		return false;
	}

	public function setCache($key, $value, $duration=60) {
		if(!empty($value))Yii::$app->cache->setValue($key, $value, $duration);
	}
}


?> 