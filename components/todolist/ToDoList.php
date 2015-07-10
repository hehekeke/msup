<?php 
namespace components\todolist;

use yii\web\NotFoundHttpException;
class ToDoList implements TodoListInterface {

	// 子类都依赖于该Id
	public $userId;
	public function __construct($userId) {
		if (!$userId) {
			throw new NotFoundHttpException('您访问的页面不存在', 404);
		}
		$this->userId = $userId;

	}
	public function getToDoList (){

	}
}

?>