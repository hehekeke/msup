<?php 
namespace backend\widget;

/**
 * 附件处理
 * @author 410345759@qq.com
 */
use Yii;
use backend\widget\UploadFile;
use backend\components\GlobalFunc;
use backend\models\MsupAttachment;
use yii\helpers\Html;
use yii\base\InvalidCallException;
use yii\web\NotFoundHttpException;
use yii\helpers\Url;
// 数据通过modelID,modelPK,field 组合条件查询出结果

/**
 * explame
 * Attachment::widget(
 * 		[
 * 			'url'=>'attachment/upload',
 *          'modelPk' => $id,
 *          'modelId' => $model->modelId,
 *          'field' => 'thumbs',
 *          'number' => 11,
 * 		]
 * );
 * @see bacend\widgets\Uploadfile
 * @see MsupAttachment::getModelAttachment();
 */
class Attachment extends UploadFile{

	/**
	 * 使用widget的模型
	 */
	public $model;
	// 使用该组件时，必须指定绑定字段 如 [ 'field'=>'thumb', 'url', 'filedName'=>],
	public $field;
	


	public $hash = null;
	public function init() {

		if (!$this->url) {
			throw new NotFoundHttpException("缺少 `URL` 参数");
		} 

		if (!$this->field) {
			throw new NotFoundHttpException("缺少关联该控件的字段名");
			
		} else {
			$this->fieldName = $this->field;
		}

		if (!$this->model) {
			throw new NotFoundHttpException("您还不能使用上传组件，请先将该模型添加到数据库中");
			
		}

		// 如果是没有主键值则生成随机验证字符
		if (!$this->model->primaryKey)  {
			$session = new \yii\web\Session;
			if (!$session->get('hash')) {
				$session->set('hash', Yii::$app->getSecurity()->generateRandomString(8));
			}
			$this->hash = $session->get('hash');
		}

		$this->url = Yii::$app->urlManager->createAbsoluteUrl( [$this->url,
					'modelId' => $this->model->modelId, 'field' => $this->field, 'modelPk' => $this->model->primaryKey, 'hash' => $this->hash ] );
		parent::init();
	}
	public function run($value='')
	{

		if ($this->model->primaryKey) {
			$this->renderTable();
		}
		$this->getView()->registerJs('url="'.Yii::$app->urlManager->createAbsoluteUrl(['attachment/create-by-ajax', 'modelId' => $this->model->modelId, 'field' => $this->field, 'modelPk' => $this->model->primaryKey, 'hash' => $this->hash ]).'"');
		parent::run();

	}

	// 渲染附件数据表
	public function renderTable() {
		$attachmenModel = new \backend\models\MsupAttachment;
		$fieldName = $this->getRealyFieldName();
        if ( $this->model->primaryKey && !empty( $this->model->$fieldName) ) {
        	$globalFunc = new GlobalFunc;
			$html = '<table class="table text-left table-striped table-bordered dataTable no-footer attachmen uploadFiles">
					<thead> 
                        <tr>
                            <th>附件</th>
                            <th>大小</th>
                            <th>操作</th>     
                        </tr>
                        </thead>
						<tbody>
                        ';
         	$attachments = $globalFunc->uploadFormat($this->model->$fieldName);
         	$attachments = (count($attachments) === count($attachments, 1))? [$attachments] : $attachments;

        	foreach ( $attachments as $v) {
        		if (!empty($v)) {
		        	if ( !isset($v['fileUrl']) && !$v['fileUrl']) continue;

		        	// 计算文件实际大小
		        	$filePath = Yii::getAlias('@webroot').'/files/'.substr($v['fileUrl'],strlen(Yii::getAlias('@baseUrl').'/files/'));

		        	// 输出文字和文件链接
		        	$html.= '<tr fileUrl=' . $v['fileUrl'] . '>
							 <td>' . Html::a(
							 			$attachmenModel->showFileByImg($v['fileUrl']), 
										$v['fileUrl'], 
										['target' => '_blank']
									) . 
							 		Html::hiddenInput($this->field, 
							 		 	json_encode($v), 
							 		 	['class' => 'uploadPluginInput']
							 		) . '</td>

							<td>'.$globalFunc->getFileSize($filePath).'
							
							</td>
							<td>'.Html::a('删除', 'javascript:void(0)', [' class' => 'btn btn-danger remove-attachment', ]).'</td>
							</tr>
		        	';
        		}

        	}
        }
        
        $html .= '</tbody></table>';
        echo $html;
	}

	// 获得真正的字段名称 去除掉表单名中的模型名称
	public function getRealyFieldName() {
		if (method_exists($this->model, 'getRealyFieldName') ) {
			return $this->model->getRealyFieldName();
		} else {
			return substr(substr($this->fieldName,strlen($this->model->getClassName())+1),0,-1);
		}
	}
}


?>
