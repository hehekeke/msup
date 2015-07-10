<?php
namespace backend\controllers;

use Yii;
use backend\models\MsupSitesModelMap;
use backend\models\MsupSitesFieldMap;
use backend\models\MsupSites;
use yii\helpers\ArrayHelper;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use backend\models\MsupSync;
use yii\web\NotFoundHttpException;

class SyncController extends Controller {


	public function actionIndex( $map ) {

		$fieldMap  = new MsupSitesFieldMap;
		$fields    = $fieldMap->find()->where(["mapId"=>$map])->all();

		$sync 	   = new MsupSync;
		$sync->setBaseInfo($map);


		$pk  = $sync->primaryKey();
		$pk  = $pk[0];

		if (!$pk) {

			throw new Exception("您站点中的表没有主键", 1);

		}

		$rows  =  $sync->find()->asArray()->all(); 
		$data  = []; 

		foreach ($fields as $key => $v) {

			foreach ($rows as $n=>$m) {
				$data[$n]['pk'] = $m[$pk];
				$data[$n][$v->coreField] =  $m[$v->siteField];
			}

		}


		return $this->render('index',[
			'rows' => $data,
			'fields' => $fields,
			'map'  => $map,
			]);
	}


	public function actionImport() {
		$model = new MsupSync;


		if ( $model->save( ) ) 
		{

			return $this->render('view');

		} else {

			if (!Yii::$app->request->post()) {
				throw new NotFoundHttpException("您的表单不能为空");
		
			}

		}


	}
	// 导入 TOP100数据
	public function actionImportTop100Data(){
		$sql = 'SELECT term_taxonomy_id,post_content,post_title,post_modified,post_date FROM  top101.wp_posts as p left join top101.wp_term_relationships as r on p.ID=r.object_id ORDER BY post_modified DESC';
		$model = new \backend\models\MsupCourse;
		$row = $model->findBySql($sql)->asArray()->all();
		$tempModel = array();
		$lecturerModel = new \backend\models\MsupLecturer;

		foreach($row as $k => $v) {
			$lids = [];
			$model = new \backend\models\MsupCourse;
			// 空课程内容过滤
			if (empty($v['post_content']) || !$v['term_taxonomy_id']) continue;

			// 课程存在过滤
			$row = $model->find()->select('courseid')->where(['title' => $v['post_title']])->one();
			if ($row->courseid) continue;
			$content = explode('|||',$v['post_content']);

			// 搜索教练，如果存在就进行关联
			foreach ( (array)explode(',', $content[1]) as $lecturerName) {
				$lecturer = $lecturerModel->find()->select('id')->where(['name' => $lecturerName])->one();
				if ($lecturer->id) {
					$lids[] = $lecturer->id;
					$model->lecturer_id .= empty($model->lecturer_id) ? $lecturerName : ','.$lecturerName;
				}
			}
			$tagId = '';
			$create_admin = 21;
			// 设置默认的添加人和关联角色标签
			switch ($v['term_taxonomy_id']) {
				case 1:
					$tagId = 2;
					$create_admin = 10;
					break;
				case 3:
					$tagId = 5;
					$create_admin = 15;
					break;
				case 4:
					$tagId = 3;
					$create_admin = 8;
					break;
				case 5:
					$tagId = 1;
					$create_admin = 5;
					break;
				case 6:
					$tagId = 4;
					$create_admin = 9;
					break;
				default:
					break;
			}
			$model->created_at = (substr($v['post_date'],1) == 0) ?  (String)time() :  (String)strtotime($v['post_date']);
			if (strlen($content[14]) > 10) {
				$file = json_encode(["fileUrl" => $content[14], "fileName" => $v['post_title']]);
			}
			if (strlen($content[7]) > 10) {
				$thumbs = json_encode(["fileUrl" => $content[7], "fileName" => $v['post_title']]);
			}

			// 给模型赋值
			$model->title = $v['post_title'];
			$model->desc = $content[11];
			$model->updated_at = (String)strtotime($v['post_modified']);
			$model->content = $content[12];
			$model->level = '100';
			$model->usedtimeid = 2;
			$model->price = 0;
			$model->create_admin = $model->update_admin = $create_admin;
			$model->num = 0;
			$model->type = 0;
			$model->file = $file ? $file : '';
			$model->thumbs = $thumbs ? $thumbs : '';
			$model->save();

			// 	如果教练存在教练表中的话，将关联关系保存到关联数据库中
			if ($model->courseid){
				if(!empty($lids)) {
					$relationModel = new \backend\models\MsupCourseLecturer;
					foreach($lids as $lid){
						$relationModel->isNewRecord = true;
						$relationModel->id = '';
						$relationModel->cid = $model->courseid;
						$relationModel->lid = $lid;
						$relationModel->save();	
					}
				}

				// 添加角色标签
				$tagRelationModel = new \backend\models\MsupTagRelation;
				$tagRelationAttributes = [ 'tagId' =>$tagId ];
				$tagRelationModel->tagRelationAdd($model, $tagRelationAttributes);
			}

		}
		echo "导入成功";
	}

}


?>