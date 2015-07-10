<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCategorys */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-categorys-form">
		<div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= $title?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">基本信息</div>
                    <div class="panel-body">
                    	
					    <?php $form = ActiveForm::begin(); ?>

					    <?= $form->field($model, 'catName')->textInput() ?>

					    <?= $form->field($model, 'level')->textInput() ?>
					    <?= $form->field($model, 'listOrder')->textInput() ?>
				    	<?= $form->field($model, 'parentId')->dropDownList($model->categoryList()) ?>
					    <?= $form->field($model, 'isRequired')->dropDownList($model->isRequiredLabels) ?>
						<?= $form->field($model, 'type')->dropDownList($model->typeLabels)?>

					    <div class="form-group">
					        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
					    </div>
					</div>
				</div>
			</div>
		</div>
					
    <?php ActiveForm::end(); ?>

</div>
