<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupModel */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Model',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Models'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-model-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
