<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupContactNotes */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Msup Contact Notes',
]) . ' ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Contact Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="msup-contact-notes-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
