<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCategorys */

$this->title = $model->catName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Categorys'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-categorys-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'catName',
            'level',
            [
                'attribute' => 'type',
                'value' => $model->typeLabels[$model->type],
            ],
            [
                'attribute' => 'isRequired',
                'value' => $model->isRequiredLabels[$model->isRequired],
            ],
            // 'parentId',
            // 'childrenId',
        ],
    ]) ?>

</div>
