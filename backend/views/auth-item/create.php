<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupAuthItem */

$this->title = Yii::t('app', '添加角色/权限');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Auth Items'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-auth-item-create">

    <?= $this->render('_form', [
        'model' => $model,
        'ruleName' => $ruleName,
        'title' => $this->title,
    ]) ?>

</div>
