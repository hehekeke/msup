<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = '待办事项种类';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-todolist-index panel panel-default">
    
    <h3 class='panel-heading nmt'><?= Html::encode($this->title) ?></h3>
    <div class="panel-body">
        
        <p>
            <?= Html::a(Yii::t('app', 'Create {modelClass}', [
        'modelClass' => '待办事项种类',
    ]), ['create'], ['class' => 'btn btn-success floatBtn']) ?>
        </p>

        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                ['class' => 'yii\grid\CheckboxColumn'],

                'id',
                'listName',
                'listClass',

                ['class' => 'yii\grid\ActionColumn'],
            ],
        ]); ?>
            <div>
                <!-- Split button -->
                <div class="btn-group dropup eventAlll">
                  <button type="button" class="btn btn-danger">选中项批量操作</button>
                  <button type="button" class="btn btn-danger dropdown-toggle" data-toggle="dropdown">
                    <span class="caret"></span>
                    <span class="sr-only">选中项</span>
                  </button>
                  <ul class="dropdown-menu" role="menu">
                    <li><a href="javascript:void(0)" class="assignment_event"><i class="glyphicon glyphicon-paperclip"></i> <span> 分配给角色</span></a></li>
                    <li><a href="javascript:void(0)" class="assignment_event"><i class="glyphicon glyphicon-paperclip"></i> <span> 分配给用户</span></a></li>
                  </ul>
                </div>
            </div>
    </div>
</div>
