<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourseSignup */

$this->title = Yii::t('app', 'Create {modelClass}', [
    'modelClass' => 'Msup Course Signup',
]);
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Course Signups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-signup-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
