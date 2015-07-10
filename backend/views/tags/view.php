<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupTags */

$this->title = $model->tagName;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-tags-view panel panel-default">

    <h2 class="panel-heading nmt nmb"><?= Html::encode($this->title) ?></h2>
    
    <div class="panel-body">
        <p>
        <?= Html::a('修改标签信息', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
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
                'tagName',
                'level',
                'catid',
                'hits',
            ],
        ]) ?>
    </div>
</div>
