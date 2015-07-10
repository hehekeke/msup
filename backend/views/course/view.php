<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupCourse */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Msup Courses', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-course-view">

    <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header"><?= Html::encode($this->title)?></h1>
                    <p>
                        <?= Html::a('修改课程信息', ['update', 'id' => $model->courseid], ['class' => 'btn btn-primary']) ?>
                    </p>
            </div>
    </div>
       
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">课程信息</div>

                <div class="panel-body">
    
<style type="text/css">
    td{width:700px;}
</style>
                    <?= DetailView::widget([
                        'model' => $model,
                        'attributes' => [
                            'courseid',
                            // 'sponsor',
                            'lecturer_id',
                            'usedtimeid',
                            'price',
                            'num',
                            'desc',
                            'character',
                            [
                                'label' => '培训内容',
                                'value' => $model->training,
                            ],
                            [
                                'label' => '文件',
                                'format' => 'html',
                                'value' => $model->file,
                                'contentOptions' => ['style' => 'width:700px;'],
                            ],
                            // 'content:ntext',
                        ],
                    ]) ?>
                </div>
            </div>
        </div>
    </div>

</div>
