<?php 
namespace components\todolist;


interface TodoListInterface {
	// 必须指定userId
	// public $userId;
	/**
	 *要求返回二维数组，返回的第二维数组中必须有一个key msg用于显示该项未办事项 
 	*/
	public function getTodoList();
}

?>