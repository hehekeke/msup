<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\grid\CheckboxColumn;
use yii\widgets\ActiveForm;
?>


<?php ActiveForm::begin();?>
<div class="panel panel-default assignment">
	<h3 class="panel-heading nmt">
		分配教练
	</h3>
	<div class="panel-body">
		<table class="table text-left table-striped table-bordered dataTable no-footer">
			<thead>
				<tr>
					<th>真实姓名</th>
					<th>笔名</th>
					<th>任职公司</th>

					<th>当前维护</th>
					<th>维护时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				
			<?php 

			foreach($row as $k => $v) {
			?>
			<tr>
				<td><?= $v['name']?><?= Html::hiddenInput("lids[]", $v['id'])?></td>
				<td><?= $v['penName']?></td>
				<td><?= $v['company']?></td>

				<td><?= $v->assignment->user->username;?></td>
				<td><?= date('Y-m-d',$v->updated_at)?></td>
				<td>
					<a href="javascript:void(0)" class="remove  btn btn-xs btn-danger" title="移出"><i class="glyphicon glyphicon-remove"></i></a>
				</td>
			</tr>

			<?php }?>

			</tbody>
			
		</table>
	
		<div class="form-group">
			<h4 for="">将以上教练分配给</h4>

			<?= Html::dropDownList('user_id', null ,$users, ['class'=>'user_id form-control ']);?>
		</div>
	</div>


	<div class="panel-footer text-right">
		<div class="alert alert-danger text-center">教练分配给该用户后，其他用户将不能维护该教练</div>
	
		<button  class="btn  btn-default"  data-dismiss="modal">取消</button>
		<input type="button" class="btn  btn-success submit-assign" value="确定"/>
	</div>
</div>
<?php ActiveForm::end();?>
<?php 

$this->registerJs(
		'
		$(".remove").click(function(){
			$(this).parent().parent().remove();
		});
		$(".submit-assign").click(function(){
			if (confirm("确定把选中的教练分配给这个用户吗?") == true ) {

				var data = "{";
				var lids = \'"lids":[{\',
					user_id = $(".user_id").val();
				var i = 0;
				$("input[name=\'lids[]\']").each(function(){
					lids += \'"\'+i+\'":\'+\'"\'+$(this).val()+\'",\';
					i++;
				})
				data += lids.substring(0, lids.length-1)+"}],";
				data += \'"user_id":\'+\'"\'+user_id+\'"}\';	
				$.post(
					"'. Yii::$app->urlManager->createAbsoluteUrl("lecturer/assignment").'",
					{data:data},
					function(data){
						if (parseInt(data) == 1) {
							alert("教练分配成功");
							$(".modal").modal("hide").removeData();

						} else {
							console.log(data);
						}
					}
				);
			}


		})
		'
	);

?>