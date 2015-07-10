<?php 
namespace components\api;
/**
 *
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
trait UserTrait{
	public function hit(){
		$this->updateCount('hits');
	}
	
	public function praise(){
		$this->updateCount('praises');
	}

	public function comment(){
		$this->updateCount('comments');
	}

	public function collect(){
		$this->updateCount('collects');
	}

	private function updateCount($fieldName, $num = 1){
		if ($this->model->hasAttribute($fieldName)) {
			$this->model->updateAllCounters([$fieldName => $num], [$this->model->primaryKey()[0] => $this->model->primaryKey]);
		}
	}

}

?>