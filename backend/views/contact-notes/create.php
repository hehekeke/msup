<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupContactNotes */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Contact Notes',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Contact Notes'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-contact-notes-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
