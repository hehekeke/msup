<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model backend\models\MsupHistory */

$this->title = '当前版本';
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Msup Histories'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-history-view">

    <h1>
        <?= Html::encode($this->title) ?>
        <small class="btn"><a href="#historys" class="btn btn-success">历史版本</a></small>
    </h1>


    <?= DetailView::widget([
        'model' => $model,
        'attributes' => $columns,
    ]) ?>
    
    <div id="historys">
        <h1>历史版本</h1>   
        <table class="table table-striped table-bordered">
        <tr>
            <th>版本号</th>
            <th>备注</th>
            <th>操作</th>
        </tr>
        <tbody>
            <?php foreach($historys as $key => $v):?>
            <tr>
                <td><?= $v['commit']?></td>
                <td><?= $v['review']['comment']?></td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['history/detail', 'id'=>$v['id'], 'iframe'=>1])?>" data-pjax="0" data-toggle="modal" data-target="#viewModal" class="btn btn-info">
                    查看<i class="glyphicon glyphicon-chevron-down"></i>
                    </a>
                </td>
            </tr>

            <?php endforeach; ?>
        </tbody>
        </table>
    </div>
            <div class="modal fade" id="viewModal"  tabindex="-1"  >
                <div class="modal-dialog modal-lg">
                    <div class="modal-content" >


                    </div>
                </div>
            </div>
</div>
<?= $this->registerJs(
            '$("#myModal").on("hidden.bs.modal",function(){
                $(this).removeData();
                window.location.reload();
            })'

        );

?>