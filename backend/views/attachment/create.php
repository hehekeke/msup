<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupAttachment */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Attachment',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Attachments'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-attachment-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
