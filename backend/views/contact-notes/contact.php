<?php 

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
?>

<div class="panel panel-default">
	<div class="panel-heading">添加联系记录</div>
	<div class="panel-body">
		<div class="row nm">

		<?php $form = ActiveForm::begin();?>
			<div class="col-xs-4">
				
				<?= $form->field($model, 'contactType')->dropDownList(Yii::$app->params['contactTypes']) ?>
			</div>
			<div class="col-xs-8">
				<?= $form->field($model, 'notes')->dropDownList(Yii::$app->params['contactNotes']) ?>
			</div>
			<div class="col-xs-12">
				<?= $form->field($model, 'remarks')->textarea();?>
			</div>
			<?php if (Yii::$app->request->get('toModel')) {
					echo Html::hiddenInput("MsupContactNotes[toModel]", Yii::$app->request->get('toModel'));
				} else {
					echo $form->field($model, 'toModel')->dropDownList($models);
				}
			?>

			<?php if (Yii::$app->request->get('toId')) {
					echo Html::hiddenInput("MsupContactNotes[toId]", Yii::$app->request->get('toId'));
				} else {
					echo $form->field($model, 'toId')->textInput();
				}
			?>
			<div class="col-xs-12">
				<div class="form-group">
		        	<?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success col-xs-2' : 'btn btn-primary col-xs-2']) ?>
		   		</div>
	   		</div>
		</div>
		<?php ActiveForm::end();?>
	</div>
</div>