<?php 
$this->title = '跳转至指定页面';
?>
<div class="common-showMessage">
	<div class="alert alert-info">
		<h2><?= Yii::$app->getSession()->getFlash('msg.success')?></h2>
		<h4>是否跳转到指定页面:</h4>
		<div class="buttons">
			<a href="<?= $okUrl?>" class="btn btn-success">是，立即跳转</a>
			<a href="<?= $cancelUrl ?>" class="btn btn-danger">否</a>

		</div>
	</div>
</div>