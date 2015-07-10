<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourseUsedtime */

$this->title = Yii::t('app', 'Create Msup Course Usedtime');
$this->params['breadcrumbs'][] = ['label' => 'Msup Course Usedtimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-usedtime-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
