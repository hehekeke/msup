<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model backend\models\MsupTodolist */

$this->title = '创建待办事项类型';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Todolists'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-todolist-create panel panel-default">
	
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
