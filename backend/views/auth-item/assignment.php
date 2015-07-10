<?php 
use yii\helpers\Html;
use yii\widgets\ActiveForm;
/* @var $this yii\web\View */
/* @var $model backend\models\MsupAuthItem */
/* @var $form yii\widgets\ActiveForm */

?>
<h1>修改权限</h1>
<br>
<div class="msup-auth-item-form">

    <?php $form = ActiveForm::begin(["action"=>'assignment?name='.$name]); ?>

    <?= $form->field($authItemChild, 'parent')->textInput(['maxlength' => 64]) ?>
    <label>更改权限</label> <br/>
    <div class="row">
    	
   
    <?php
    	
    	foreach ($dropDownList as $key => $value) {
    		
    		$input = '<div class="col-xs-4"> <input type="checkbox" name="child[]" value="'.$value['name'];
    		
    		if (isset($value['checked'])) {
    			
    			$input .= '"  checked="checked"';
    		
    		}
    		
    		$input .= '" />&nbsp;<span>'.$value['description'].'</span></div>';
    		
    		echo $input;
    	
    	}
    ?>
  	 </div>
  	<br/>
    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>