<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupAppointCourse */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Appoint Course',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Appoint Courses'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-appoint-course-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
