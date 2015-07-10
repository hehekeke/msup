<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourseUsedtime */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Msup Course Usedtimes', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-usedtime-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('更新此课程时间', ['update', 'id' => $model->usedtimeid], ['class' => 'btn btn-primary']) ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'usedtimeid',
            'title',
            [
                'attribute' => 'hour',
                'value' => $model->times[$model->hour],
            ],

            'updated_at:datetime',
        ],
    ]) ?>

</div>
