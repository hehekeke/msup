<?php
?>

<table class="table table-striped table-bordered">
	<thead>
		<tr>
			<th width="100">课程名称</th>
			<th width="60">平均分</th>
			<th>1.您觉得本节课程分享的内容质量如何?</th>
			<th>2.您觉得本节课程讲师课堂气氛营造的如何?</th>
			<th>3.您觉得本节课程达到您的预期目标了吗?</th>
			<th>4.您希望将本节课程第一时间推荐给您的</th>
			<th>5. 您对以下哪些 msup 的课程感兴趣?</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach ($allCount as $key => $value): ?>
			<tr>
				<td><?= $value['title']?></td>
				<?php $questions = ['q2','q3','q4', 'q5', 'q6']?>
				<td>
					 <?= $value['rank']?>
				</td>
				<?php foreach ($questions as  $question): ?>
					<?php 
						$count = $value[$question]['count'];
						unset($value[$question]['count']);
					?>
					<td>总数：<?=$count?>;<br />
					<?php   
							foreach ($value[$question] as $typeKey => $typeCount): 
					?>
						选项<?= $typeKey ?>
						占比（<?= (round($typeCount/$count, 2))*100?>%);<br />
					<?php endforeach ?>
					</td>
				<?php endforeach ?>
			</tr>
		<?php endforeach ?>
	</tbody>
</table>
