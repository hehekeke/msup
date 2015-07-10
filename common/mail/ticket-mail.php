

<table cellpadding="0" cellspacing="0" width="675" height="77" border="0" align="center">
	<tbody>
		<tr style="background:#000;color:#fff;">
			<td style="width: 100px;text-align: left;font-size: 36px;text-indent: 1em;">msup</td>
			<td style="text-align: right;padding-right: 24px;">专注于软件研发中心的快速成长</td>
		</tr>
	</tbody>
</table>
<table cellpadding="0" cellspacing="0" width="675"  border="0" align="center" style="background: #424243;">

	<tbody>
	<tr >
		<td width="154">&nbsp;</td>
		<td width="" style="width:676px;padding-top:45px;padding-bottom: 28px;text-align: center;color:#fff;font-size: 28px;width:368px;">
			<span style="display: block;text-align: center"><?= $scheduling->title ?>
			</span>
		</td>
		<td width="154">&nbsp;</td>
	</tr>

	</tbody>
</table>
<table cellpadding="0" cellspacing="0" width="675"  border="0" align="center" style="background: #424243;">
	<tr>
		<!-- <td style="width:265px;">&nbsp;</td> -->
		<td style="text-align: center;padding-bottom: 45px;">
			<a href="<?= $linkUrl?>" style="border-radius: 5px;background:#00a2e6;color:#fff;padding:12px 20px;width:144px;">	
				查看课程详细
			</a>
		</td>
		<!-- <td style="width:265px;">&nbsp;</td> -->

	</tr>
</table>
<table cellpadding="0" cellspacing="0" width="675"  style="border-left: solid 1px #7f7f7f;border-right: solid 1px #7f7f7f;" align="center">
	<tbody style="text-align: left;">
		<tr>
			<td style="height:65px;width: 30px;">&nbsp;</td>
			<td style="text-align: left; font-size: 16px;color:#7f7f7f;width:138px;border-bottom: dashed 1px #d2d2d2">参加者姓名</td>
			<td style="text-align: left; font-size: 20px;border-bottom: dashed 1px #d2d2d2;font-weight: bold">
				<b><?= $userName?></b>
			</td>
			<td style="width: 30px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:65px;width: 30px;">&nbsp;</td>
			<td style="text-align: left; font-size: 16px;color:#7f7f7f;width:138px;border-bottom: dashed 1px #d2d2d2">门票票号</td>
			<td style="text-align: left; font-size: 20px;border-bottom: dashed 1px #d2d2d2;font-weight: bold">
				<b><?= $bank ?></b>
			</td>
			<td style="width: 30px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:65px;width: 30px;">&nbsp;</td>
			<td style="text-align: left;font-size: 16px;color:#7f7f7f;width:138px;border-bottom: dashed 1px #d2d2d2">活动时间</td>
			<td style="text-align: left; font-size: 20px;border-bottom: dashed 1px #d2d2d2;font-weight: bold">
				<b><?= date('Y-m-d H:i', $scheduling->startTime)?> — <?= date('Y-m-d H:i', $scheduling->endTime)?></b>
			</td>
			<td style="width: 30px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:65px;width: 30px;">&nbsp;</td>
			<td style="text-align: left; font-size: 16px;color:#7f7f7f;width:138px;border-bottom: dashed 1px #d2d2d2">活动地址</td>
			<td style="text-align: left; font-size: 20px;border-bottom: dashed 1px #d2d2d2;font-weight: bold">
				<b><?= $scheduling->address?></b>
			</td>
			<td style="width: 30px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="height:65px;width: 30px;">&nbsp;</td>
			<td style="text-align: left; font-size: 16px;color:#7f7f7f;width:140px;border-bottom: dashed 1px #d2d2d2">主办方电话</td>
			<td style="text-align: left; font-size: 20px;border-bottom: dashed 1px #d2d2d2;font-weight: bold"><b>400-8128-020</b></td>
			<td style="width: 30px;">&nbsp;</td>
		</tr>
		<tr>
			<td style="width: 30px;">&nbsp;</td>
			<td colspan="3" style="text-align: left;padding-top:25px">
							请将此邮件留作记录。
			</td>
		</tr>
		<tr>
			<td style="height:65px;width: 30px;">&nbsp;</td>
			<td colspan="2" align="left">如需查看课程在线ppt ，请打开buzz app，请点击  www.buzz.cn  
				前往下载</td>
				<td></td>
		</tr>
	</tbody>
</table>
<table cellpaadding="0" cellspacing="0" width="675" border="0" align="center">
	<tbody> 
		<tr style="background:#000">
			<td style="color:#fff;font-size: 18px;padding: 20px 0px;text-align:center;">
				请勿直接回复邮件，需要帮助请拨打400-8128-020 ©2015 msup.Inc.
			</td>
		</tr>
	</tbody>
</table>