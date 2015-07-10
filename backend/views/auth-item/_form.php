<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupAuthItem */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="msup-auth-item-form">
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
                    
                    <?= $form->field($model, 'description')->textInput(['rows' => 6]) ?>
                	<?php if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>
                	<?php endif; ?>
                    <?= $form->field($model, 'type')->dropDownList(['1'=>'角色', 2=>'权限']) ?>


                    <?= $form->field($model, 'rule_name')->dropDownList($ruleName) ?>
                


                    <div class="form-group">
                        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php ActiveForm::end(); ?>

</div>
