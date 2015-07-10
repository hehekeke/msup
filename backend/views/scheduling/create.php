<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupScheduling */

$this->title = '发布课程排期';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Schedulings'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-scheduling-create">
    <?= $this->render('_form', [
        'model' => $model,
        'title' => $this->title
    ]) ?>

</div>
