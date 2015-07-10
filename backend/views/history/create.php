<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupHistory */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup History',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-history-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
