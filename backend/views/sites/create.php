<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupSites */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => Yii::t('app','Sites'),
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Sites'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-sites-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
