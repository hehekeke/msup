<?php 
namespace backend\components;
use yii\base\UnknownClassException;
class AppointFactory {
	public function create($modelName, $attributes)
	{
		$modelName = 'backend\models\Msup'.ucfirst($modelName);
		if (class_exists($modelName)) {
			$model = new $modelName;
		} else {
			throw new UnknownClassException($modelName);
		}
		return $this->filterAttributes($model, $attributes);
	}

	private function  filterAttributes(\yii\db\ActiveRecord $model, array $attributes) 
	{
		$modelAttributes = $model->attributes();
		foreach ($attributes as $k => $v) {
			if (in_array($k, $modelAttributes)) {
				$model->$k = $v;
			}
		}
		return $model;
	}

}

?>