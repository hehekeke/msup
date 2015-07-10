<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/**
 * @var yii\web\View $this
 * @var dektrium\user\models\User $model
 */

$this->title = Yii::t('user', 'Create a user account');
$this->params['breadcrumbs'][] = ['label' => Yii::t('user', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<?php echo $this->render('flash') ?>
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= Html::encode($this->title)?></h1>
            </div>
        </div>
           
        <div class="row">
            <div class="col-lg-12">
                <div class="panel panel-default">
                    <div class="panel-heading">基本信息</div>
                    <div class="panel-body">
                        <div class="alert alert-info">
                            <?= Yii::t('user', 'Password and username will be sent to user by email') ?>.
                            <?= Yii::t('user', 'If you want password to be generated automatically leave its field empty') ?>.
                        </div>
                        <?php $form = ActiveForm::begin(); ?>

                        <?= $form->field($model, 'username')->textInput(['maxlength' => 25, 'autofocus' => true]) ?>
                        <?= $form->field($model, 'descriptions')->textInput(['maxlength' => 100]) ?>
                        <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>

                        <?= $form->field($model, 'password')->passwordInput() ?>
                        <?= $form->field($model, 'role')->dropDownList($authItems)?>
                        <div class="form-group">
                            <?= Html::submitButton(Yii::t('user', 'Save'), ['class' => 'btn btn-success']) ?>
                        </div>

                        <?php ActiveForm::end(); ?>
                    </div>
                </div>
            </div>
        </div>
</div>
