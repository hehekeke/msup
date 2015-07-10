<?php 
namespace components;
use yii\caching\MemCache as Mem;

class MemCache extends Mem {

	public function setValues($data, $duration){
		parent::setVales($$data, $duration);
	}

	public function setValue($key, $value, $duration=0)
	{
		return parent::setValue($key, $value, $duration);
	}

	public function getValue($key)
	{
		return parent::getValue($key);
	}
}


?>	