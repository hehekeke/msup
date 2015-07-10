<?php 
namespace backend\components;

use yii;
use yii\db\IntegrityException;
class Integrity {


	/**
	 * 获得该记录在该模型的数组的信息完整
	 * @param  [type] $model [description]
	 * @param  [type] $row   [description]
	 * @return [type]        [description]
	 */
	public function getIntegrity($model, $row) {
		
		$IntegrityWeights = Yii::$app->params['integrityWeights'];
		if (!array_key_exists($model, $IntegrityWeights)) throw new IntegrityException("该模型信息尚未配置，无法获取完整度信息");
		$allWeight = array_sum($IntegrityWeights[$model]);
		$weight = 0;
		// 循环获取记录中存在值并且在配置中已配置权重的相关字段的权重，并相加，获得该记录的权重总和
		// 尚余问题 附表中的数据怎么获取并计算
		foreach ($row as $k => $v) {

			if (array_key_exists($k, $IntegrityWeights[$model]) && !empty($v)) {
				$weight += $IntegrityWeights[$model][$k];
			}
		}
		return $this->calculation($weight, $allWeight);	
	}

	public function getIntegrityByObj($object) {

		$row = $object->attributes;
		$modelName = $object->getClassName();
		return $this->getIntegrity($modelName, $row);
	}

	/**
	 * 计算出百分比
	 * @param  [type] $weight    [权重]
	 * @param  [type] $allWeight [总权重]
	 * @param  [type] $ratio     [补充系数]
	 * @return [type]            [最后得出信息完整度百分比]
	 */
	private function calculation($weight, $allWeight, $ratio = 1)
	{
		return round( ( ($weight/$allWeight) * $ratio) * 100).'%';
	}

	/**
	 * 将完善度用html格式输出
	 * 低于80%将输出红色，高于则输出绿色
	 * @param  integer $interity [description]
	 * @return [type]            [description]
	 */
	public function toHtml($interity = 0){
		if ( intval($interity) < 80 ) {
			return '<span style="color:#d9534e">'.$interity.'</span>';
		} else {
			return '<span style="color:#2A9E46">'.$interity.'</span>';
		}
		return $interity;	
	}

} 

?>