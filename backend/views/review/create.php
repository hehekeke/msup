<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupReview */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Review',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Reviews'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-review-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
