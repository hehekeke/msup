<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', '数据同步');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="msup-auth-item-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <!-- Form Begin -->
    <?php $form =  ActiveForm::begin(
                    ['action'=>'import',
                    'method'=>'post']
                   );
    ?>
    
    <input type="hidden" value="<?= $map ?>" name="map">
    <table class="table table-striped table-bordered">
        <!-- 输出字段名 -->
        <thead>
            <tr>
            <th>
                <input type="checkBox" class="checkAll">
            </th>
            <?php 
                foreach ($fields as $key => $value) {
                    echo "<th>".$value->coreFieldName."</th>";
                }
            ?>
            </tr>
        </thead>
        <!-- 输出实际数据 -->
        <tbody>

            <?php 
                foreach ($rows as $key => $value) {

                    echo "<tr><td><input type='checkbox' value='".$value['pk']."' name='pk[]'></td>";
                    foreach ($fields as $n => $m) {
                        echo "<td>".strip_tags(mb_substr($value[$m->coreField], "0","24", "utf-8"))."</td>";
                    }
                    echo "</tr>";
                }

            ?>
        </tbody>
    </table>

    <div class="form-group">
        <?= Html::submitButton(Yii::t('app', 'Create'), ['class'=>'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end();?>
    <!-- Form End -->
</div>
<?php 
    $this->registerJs('
            $(".checkAll").click(function(){

                $("table tbody input[type=\'checkbox\']").each(function(){

                   if ($(this).prop("checked") == true)  { 

                        $(this).prop("checked",false);

                    } else {

                        $(this).prop("checked",true)

                    }

                })
            })
        ');

?>