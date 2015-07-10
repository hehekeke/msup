<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupAppointLecturer */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Appoint Lecturer',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Appoint Lecturers'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-appoint-lecturer-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
