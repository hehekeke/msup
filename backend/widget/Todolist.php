<?php 

/**
 *
 * @link   www.msup.com
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
namespace backend\widget;
use Yii;
use yii\base\Widget;
use yii\helpers\Html;
use yii\web\BadRequestHttpException;
use backend\models\MsupTodolist;
use components\todolist\TodolistInterface;
class Todolist extends widget {

	public $template = '';
	// 用户的Id
	public $userId;
	public function init($value='')
	{
		$this->userId = empty($this->userId) ? Yii::$app->user->identity->id : $this->userId;

		if (!$this->userId) {
			throw new BadRequestHttpException("请重新登录！");
		}
		parent::init();
	}

	public function run($value='')
	{
		$modelTodolist = new MsupTodolist;
		$row = $modelTodolist->find()
							->innerJoinWith([ 	
											'todolistRelation' => function ($query) {

									$query->where('userId = '.$this->userId )
										->orWhere(['itemName' =>Yii::$app->user->identity->role]);
												}

												])
							->orderBy('id asc')
							->asArray()
							->all();
		$todolists = $this->getTodolists($row);
		if (!empty($todolists)) {
			$this->renderTempalte($todolists);
		}
	}

	/**
	 * 
	 * 渲染页面
	 * 
	 * @param   array  需要用户处理的事项       
	 * @return [type] [description]
	 */
	public function renderTempalte(array $todolists){
		if (!empty($todolists)) {
			$html = '<div class="list-group">';
			foreach ( $todolists as $k => $v) {
				if ( is_array($v) && !empty($v) ) {
					foreach($v as $todolist) {
						$html .= Html::a($todolist['msg'], $todolist['url'], ['class' => 'list-group-item']);

					}
				}
			}
		}

		echo $html.'</div>';
	}

	/**
	 * 获取用户需要处理的事项
	 * @param  array  $tololistCates 需要用户处理的种类
	 * @return [type]      [description]
	 */
	public function getTodolists(array $todolistCates) {
		$todolists = [];
		foreach ($todolistCates as $key => $v) {
			$className = $v['listClass'];

			if (class_exists($className)) {
				$class = new $className($this->userId);
			} else {
				continue;
			}
			// 使用反射、检查是否继承于待办事项接口
			$reflectionClass = new \ReflectionClass($className);
			if ( $reflectionClass->implementsInterface('components\todolist\TodolistInterface')  ) {

				$todolist = $class->getTodolist();
				if (!empty($todolist)) {
					$todolists[] = $todolist;
				}
			}

		}
		
		return $todolists;
	}
}


?>