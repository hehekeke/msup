<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupUserMember */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup User Member',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup User Members'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-user-member-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
