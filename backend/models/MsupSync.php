<?php 
namespace backend\models;

use backend\models\MsupBase;
use Yii;
use yii\web\NotFoundHttpException;
use backend\models\MsupSitesModelMap;
use backend\models\MsupSitesFieldMap;
use backend\models\MsupModel;
use backend\models\MsupTemp;
class MsupSync extends MsupBase {


	public  static $tableName;
	public  static $db;

	public  $pk;
	public  $mapInfo;
	public  $siteInfo;
	public  $fields;
	public  $model;
	// public  $name;
	// public  $position;
	// public  $content;
	// public  $description;
	// public  $th_id;



	public static function tableName(){
		return self::$tableName;
	}

	public static function getDb() {
		$config = Yii::$app->components;

		if ( !$config[self::$db] ) {
			throw new  NotFoundHttpException("站点".self::$db."的相关信息没有配置，请进行配置",402);
		}

		return Yii::$app->get(self::$db);
	}



	public function save($runValidation = true, $attributeNames = null) {
		$post = Yii::$app->request->post();

		if (!$post['map'] || !$post['pk']) {
			return false;
		}
		
		$this->setBaseInfo($post['map']);

		// 获得站点表的主键
		$pk = $this->primaryKey();
		$pkValues = implode(',', $post['pk']);

		$rows = $this->find()->where($pk[0]." in (".$pkValues.")")->asArray()->all();

		if (!$rows) {
			throw new NotFoundHttpException("您要导入的数据在原站点中不存在");
		}

		$fieldMap  = new MsupSitesFieldMap;
		$this->fields    = $fieldMap->find()->where($post['map'])->asArray()->all();


		$model = $this->mapInfo->getModel0()->one();
		$modelClass = $model->modelClass;
		$this->model = new $modelClass;

		self::$db = 'db';
		self::$tableName = $this->model->tableName();
		$admin = Yii::$app->user->identity->id;
		$time = time();

		// 设置添加时间更新时间和添加人添加管理员
		$this->created_at =time();
        
        $this->updated_at = time();

        
        $this->create_admin = $admin;

        
        $this->update_admin = $admin;

		foreach ($rows as $key => $value) {	

			$_model = null;
			$_model = clone $this;

			foreach ($this->fields as $k => $v) {

				$_model->$v['coreField'] = $value[$v['siteField']];

			}
			if ( $_model->insert() ) {

				$_model->id = 0;
	
			}
		}
		return true;
	}



	//设置基本信息 
	public function setBaseInfo ($map) {

		$mapModel  = new MsupSitesModelMap;
		$this->mapInfo   = $mapModel->findOne($map);
		$siteId    = $this->mapInfo->sitesId;

		$siteModel = new MsupSites;
		$this->siteInfo  = $siteModel->findOne($siteId);

		
		self::$tableName = $this->mapInfo->table;
		self::$db = $this->siteInfo->siteUrl;

		//设置主键名
		$this->pk = $this->primaryKey();
		$this->pk = $this->pk[0];

	}


}


?>