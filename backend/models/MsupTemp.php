<?php 
namespace backend\models;

use backend\models\MsupBase;
use Yii;
use yii\web\NotFoundHttpException;
use backend\models\MsupSitesModelMap;
use backend\models\MsupSitesFieldMap;
use backend\models\MsupModel;

class MsupTemp extends MsupBase {


	public  static $tableName;
	public  static $db;

	// public  $name;
	// public  $position;
	// public  $content;
	// public  $description;
	// public  $th_id;



	public static function tableName(){
		return 'msup_lecturer';
	}

}


?>