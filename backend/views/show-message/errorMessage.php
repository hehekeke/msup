<?php 
$this->title = Yii::$app->getSession()->getFlash('msg.error');
?>
<div class="common-showMessage">
	<div class="alert alert-danger">
		<h2><?= Yii::$app->getSession()->getFlash('msg.error')?></h2>
		<h4><span id='time-out'><?= $timeOut/1000 ?>秒</span> 后将自动跳转到指定页面:</h4>
		<div class="buttons">
			<a href="<?= $okUrl?>" class="btn btn-info">立即跳转</a>
		</div>
	</div>
</div>
<script type="text/javascript">
	var time = <?= $timeOut ?>;
	var url  = '<?= $backUrl?>';
	var interval = setInterval(function(){
		
		time -= 1000;
		var ele = document.getElementById("time-out");
		ele.innerText = time/1000+'秒';
		if ( !(time > 0) ) {
			window.location.href = url;
		}

	}, 1000)
</script>