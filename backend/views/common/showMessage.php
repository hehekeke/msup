<?php
use backend\assets\AppAsset;
use yii\helpers\Html;
AppAsset::register($this);
?>

<div class="common-showMessage">
	<div class="alert alert-info">
		<p><a href='#'><?= Yii::$app->getSession()->getFlash('msg.success')?></p>
		<a href="javascript:void(0)">返回上一页</a>	
	</div>
	
</div>
