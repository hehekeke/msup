<?php
namespace backend\widget; 
use yii;
use yii\base\InvalidCallException;
use yii\base\Widget;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\Json;

use backend\models\MsupTags;

class Tag extends widget {

	//调用标签的模型
	public $model;

	// 调用标签组件的记录主键值
	public $pkId;

	// 
	public $tags;

	//是否强制要求选择 
	public $isRequire = true;
 	
	// 标签栏目
	public $cate = 1;
	/**
	 * 容器ID 如果没有则随机生成
	 * @see run();
	 * @var string
	 */
	public $containerId = '';
	public function init() {
		if (!$this->model) {
			throw new InvalidCallException("缺少模型ID参数");
		} else {
			$model = \backend\models\MsupModel::findOne(['id' => $this->model]);

			if (!$model->id) {
				throw new InvalidCallException("该模型尚不允许使用 Tag（标签）组件");
			} else {
				$this->model = new $model['modelClass'];
			}
		}

		if ( empty($this->containerId) ) {
			$this->containerId = 'TAG_'.Yii::$app->security->generateRandomString(8);
		}
		$tagModel = new MsupTags;
		$this->tags = $tagModel->getTagsWidthCate($this->cate);
		parent::init();
	}
	public function run($value='')
	{

		
		$this->renderTags();
		// 强制要求必须要选择一个标签
		if ($this->isRequire) {

			$this->getView()->registerJs('
				$("#'.$this->containerId.'").parents("form").submit(function(event){
					
					var hasSelected = 0;
					$("#'.$this->containerId.' ul.panel.tags.requiredCheked").each(function(event){
						// 
						var thiTagHasSelected = 0;
						var tags = $(this);
						
						// 检查是否有被选择的标签
						tags.find("input").each(function() 
						{

								if ( $(this).prop("checked") == true ) {
									thiTagHasSelected = 1;
									return false;
								}
						})
						// 如果没有被选择的标签，则提示选择
						if( thiTagHasSelected  == 0 ) {
							hasSelected = 0;
							alert("必须选择一个"+tags.find("h5.panel-heading").find("span.tagTitle").text())
							return false;
						} else {
							hasSelected = 1;
						}

					})

					if (hasSelected  == 0) {
						event.stopImmediatePropagation(); 
						return false;
					}

				})
	
				');
		}
	}

	// 输出Form标签选项
	public function renderTags() {

		if (is_array($this->tags) && !empty($this->tags)) {
			// Tag容器
			echo '<div id="'.$this->containerId.'">'; 
			foreach ($this->tags as $value) {
				if (empty($value['tags'])) continue;
	           	echo '<ul class="panel panel-default tags';
				echo ($value[isRequired])? ' requiredCheked ' : '';
				echo ' np">';
	           	echo '<h5 class="panel-heading nmt">';
	           	echo '<span class="tagTitle">'.$value[catName].'</span>';
	           	if ($value[isRequired]) {
	           		echo '<span class="required">*</span>';
	           	}	
	           	echo '</h5><div class="panel-body">';
				$i = 0;
				$j = 0;
                foreach($value['tags'] as $k => $v){
                    echo ($i%4 == 0) ?  '<li '.$i.' class="row nm grid' : '';
                    // 第二行的时候设置背景为灰色
                    echo ($j%2 == 0 && $i%4 == 0) ? ' bg1' : '';
                    echo ($i%4 == 0) ? '">' : '';
                    echo '<span class="col-xs-1">'.$this->getInputType($value[type], $v).'</span>';

                    echo '<span class="col-xs-2 npl ';
                    echo (($i+1)%4 == 0) ? ' ': ' rightborder';
                    echo '">'.$v[tagName].'</span>';
                    if (($i+1)%4 == 0) {
                        echo "</li>";
                        $j++;
                    }
                    $i++;
                }
                echo '</div></ul>';
			}
			echo "</div>";


		} else {
			echo "<span class='alert alert-danger'>您的标签库中还没有标签，请添加</span>";
		}
	}

	private function getInputType($type, $tag) {
		switch($type) {
			case 1:
			return Html::checkbox("MsupTagRelation[tagId][]", $this->model->hasTag($tag[id], $this->pkId),["value"=>$tag[id]]);
			break;
			case 2:
			return Html::radio( "MsupTagRelation[tagId][]", $this->model->hasTag($tag[id], $this->pkId),["value"=>$tag[id]]);
			break;
		}

	}
}


?>