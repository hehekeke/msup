<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupAppoint */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Appoint',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Appoints'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-appoint-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
