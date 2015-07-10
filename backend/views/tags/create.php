<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupTags */

$this->title = Yii::t('app', '添加标签');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Tags'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-tags-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'tagCates' => $tagCates,
    ]) ?>

</div>
