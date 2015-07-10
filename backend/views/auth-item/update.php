<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupAuthItem */

$this->title = Yii::t('app', '更新{modelClass}: ', [
    'modelClass' => Yii::t('app', 'Msup Auth Item'),
]) . ' ' . $model->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Auth Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-auth-item-update">

    <?= $this->render('_form', [
        'model' => $model,
        'ruleName' => $ruleName,
        'title' => Yii::t('app', '更新{modelClass}: ', [
    'modelClass' => Yii::t('app', 'Msup Auth Item'),
]) . ' ' . Html::tag('small',$model->description)
    ]) ?>

</div>
