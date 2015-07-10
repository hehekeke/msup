<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupDirectory */

$this->title = Yii::t('app', 'Update') . ': ' . $model->name.'的信息';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Lecturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-lecturer-update">
    <?= $this->render('_form', [
        'model' => $model,
        'address' => $address,
        'directory' => $directory,
        'email' => $email,
        'tags' => $tags,
        'publication' => $publication,
        'title' => $this->title
    ]) ?>
</div>
