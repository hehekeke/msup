<?php 
/**
 * 标签视图
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
namespace backend\widget;
use backend\widget\Tag;
use yii;
use yii\helpers\Html;
class TagView extends Tag {

	// 输出Html标签选项
	public function renderTags() {
		if (is_array($this->tags) && !empty($this->tags)) {
			// Tag容器
			echo '<div id="'.$this->containerId.'">'; 
			foreach ($this->tags as $key => $value) {
				// 初始化每个栏目的标签Html;
				$tagCatesHtml  = '<ul class="panel panel-default tags np">';
				$tagCatesHtml .= '<h5 class="panel-heading nmt">';
				$tagCatesHtml .= '<span class="tagTitle">'.$value[catName].'</span>';
	           	$tagCatesHtml .= '</h5><div class="panel-body">';
				$i = 0;

				// 初始化标签集合显示Html
				$tagsHtml = null;
                foreach($value[tags] as $k => $v){

                	if (!$this->model->hasTag($v[id], $this->pkId)) continue;
                	$tagsHtml .= ($i%2 == 0) ?  '<li class="row nm grid' : '';
                	$tagsHtml .= ($i%4 == 0) ? ' bg1' : '';
                	$tagsHtml .= ($i%2 == 0) ? '">' : '';
                	$tagsHtml .= '<span class="col-xs-6 npl ';
                	$tagsHtml .= ($i%2 == 0) ? ' rightborder': '';
                	$tagsHtml .= '">'.$v[tagName].'</span>';

                    if ($i%2 == 1) {
                       $tagsHtml .= "</li>";
                    }
                    $i++;
                }
                if ($tagsHtml) {
                	echo $tagCatesHtml . $tagsHtml .'</div></ul>';
                }
			}
			echo "</div>";


		} else {
			echo "<span class='alert alert-danger'>您的标签库中还没有标签，请添加</span>";
		}
	}
}