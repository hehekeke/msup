<?php 
namespace backend\controllers;

use Yii;
use yii\base\Controller;
use backend\models\MsupRequest;
use backend\models\MsupCategorys;
use backend\models\MsupCourse;
use backend\models\MsupLecturer;
use backend\models\MsupTags;
use backend\models\MsupTagRelation;
use backend\models\MsupScheduling;
use backend\models\MsupSchedulingVenueCourse;
use backend\models\MsupCourseLecturer;
use components\api\ApiCache;
use backend\components\ApiAccest;
use components\api\BaseApi;
use yii\helpers\ArrayHelper;
/**
 * API接口
 */
class ApiController extends Controller {


	public  $returnCode = []; 
	private $with = [];
	private $r;
	public $api;
	public function init()
	{
		header('Content-type:application/json');
		$apiAccest = new ApiAccest;
		$this->returnCode =  $apiAccest->checkNumberOfTimes();
		$this->api =  new BaseApi;
		if ( !empty( $this->returnCode ) ) {
			$this->api->errorHandler->setErrorCode($this->returnCode['errno'], $this->returnCode['errmsg']);
		}
		$this->checkCache();
	}

	public function checkCache($request = null) {
		$apiCache = new ApiCache;
		$requestHash = $this->api->generateRequestHash(json_encode($this->checkRequest($request)));
		$checkReturn = $apiCache->checkCache($requestHash);
		if ($checkReturn) {
			echo $this->api->errorHandler->pushDataByJson(json_decode($checkReturn, true));
			exit;
		}
	}


	/**
	 * 将搜索结果存到 Cache 中
	 * @param  [type] $request [description]
	 * @param  [type] $row     [description]
	 * @return [type]          [description]
	 */
	public function saveCache($request, $row) {
		$apiCache = new ApiCache;
		$requestHash = $this->api->generateRequestHash(json_encode($request));
		$row = is_array($row) ? json_encode($row) : $row;
		$apiCache->setCache($requestHash, trim($row));
	}
	/**
	 * 请求入口
	 * 参数格式:
	 * $post = '{"mm":"huichangkecheng","mw":"msvc_date>1", 
	 * "ms":"msvc_courseId","mr":{"kecheng":{}}}';
	 *	// $post = [ 
	 *	 'mm' => 'jiangshi',
	 *	//主表
	 *	 'mw' => 'ml_id>1',
	 *	 'select' => 'id',
	 *	//主表查询条件
	 *	 'select' => 'id, title, startTime, endTime',
	 *	//主表需要获取的字段
	 *	 'mr' => [  //关联表查询
	 *	 	'schedulingVenue' => [ 
	 *	 		// 'mw' => 'msv_id > 27',
	 *	 		// 'ms' => 'venueName',
	 *	 		//查询条件
	 *	  		// 'select' => 'title, lecturer_id', 
	 *	 		//关联表中需要取出来的字段名
	 *	 		'mr' => [
	 *	 			'schedulingVenueCourse' => [
	 *	 				'mw' => 'msvc_id >1',
	 *	 				'ms' => 'startTime, endTime'
	 *	 				// 'relation' => [
	 *	 				// 	'courseTitle' =>[],
	 *	 				// ]
	 *	 			],
	 *	 		],
	 *	 	],
	 *	 	// 'address' => [],
	 *	 ],
	 *	 'mp' => 'rand()', //rand() 为随机获取,其他如id desc则排序
	 *	 'ml' => 10,
	 *	 'mo' => 0,
	 *			// ];
	 * @param  json  $post  json格式传递过来的数据
	 * @return [type] [description]
	 */
	public function actionIndex($request = null) {
		// 是否是一个有效的请求
		$post = $this->checkRequest($request);
		$row = $this->api->queryInit($post)->asArray()->all();
		$this->saveCache($post, $row);
		echo $this->api->errorHandler->pushDataByJson($row);
	}
	public function actionTestShortMessage($value='')
	{
		$request = '{"mobile":"15620828006", "message":"测试发送接口", "company":"麦思博"}';
		$this->actionShortMessage($request);
	}
	public function actionTest() {
		// $this->actionTestShortUrl();
		// $this->actionTestShortMessage();
		// $this->actionTestIndex();
		// $this->actionTestLecturerRecentSchedule();
		// $this->actionTestetCateTagsOrder();
		// $this->actionTestSearch();
		$this->actionTestSearchCourse();
		// $this->actionTestGetTheNumberOfTagsInSearchCourse();
		// $this->actionTestLecturersCourse();
		// $this->actionTestCreateAppoint();
	}
	public function actionTestShortUrl()
	{
		$request = '{"url":"http://www.msup.com.cn"}';
		$this->actionShortUrl($request);
	}
	public function actionTestIndex(){
		
		$request = [
            'mm' => 'huichangkecheng',
            
            // 'mw' => 'msvc_date between UNIX_TIMESTAMP( date_add(curdate(), interval -day(curdate())+1 day) ) AND UNIX_TIMESTAMP(date_add(last_day(curdate()), INTERVAL 1 DAY))',
            'mw' => 'msvc_date > 1430442000 AND msvc_date < 1435420799',
            'ms' => 'msvc_id,msvc_sid,msvc_courseId,msvc_date',
            'mr' => [
                'paike' => [
                    'mm' => 'paike',
                    'mw' => 'ms_type = 1',
                    'ms' => 'ms_id,ms_address'
                ],
                'kecheng' => [
                    'mm' => 'kecheng',
                    'mw' => 'mc_type = 1',
                    'ms' => 'mc_title,mc_courseid'
                ]
            ],
            
            // 关联查询
            'mo' => '0',
//             'mp'=>'msvc_date ASC',
            // 查询条数
            'ml' => '5',
            'mp' => 'msvc_date ASC,msvc_id asc',
            'mgp' => 'msvc_sid'
        ];
		$this->actionIndex(json_encode($request));
	}

	public function actionTestSearch(){
		$request = '{"mm":"kecheng","mw":"c.type = 1 ","ms":"count(c.courseid) as num, c.courseid,tagId"}';
		$this->actionSearch($request);
	}

	public function actionTestSearchCourse(){
		// $request = '{"mm": "kecheng","mw": "c.mc_title LIKE \'%开发%\' AND tr.tagId = 1 AND c.type = 1","ms": "c.title,c.courseid,c.character,c.praises,c.collects,c.comments,c.lecturer_id,c.level,c.created_at,s.address,s.startTime,tr.tagId","mo": 0,"ml": "10","mp": "s.startTime ASC","mgp": "c.courseid,t.id,s.id"}';
		$request = '{"mm":"kecheng","mw":"c.mc_title LIKE \'%大数据%\' AND c.type = 1 AND c.assignToTop1/","ms":"count(c.courseid) as num, c.courseid,tagId,s.id","mgp":"t.id, s.id,c.courseid"}';
		$this->actionSearchCourse($request);
	}

	public function actionTestLecturersCourse(){
		$request = '{"mm":"kecheng","ms":"count(c.courseid) as num, c.courseid,tagId"}';
		$this->actionLecturersCourses($request);
	}
	public function actionTestGetTheNumberOfTagsInSearchCourse(){
		$request = '{"mm":"kecheng","mw":"c.mc_title LIKE \'%开发%\' AND c.type = 1","ms":"count(c.courseid) as num, c.courseid,tagId,s.id","mgp":"t.id, c.courseid,s.id"}';
		$this->actionGetTheNumberOfTagsInSearchCourse($request);
	}
	public function actionTestCreateAppoint() {
		$request = '{"mm":"yuyue","mrq":{"map_cid":"1","map_name":"张三","map_phone":"13000110022","map_company":"MSUP","map_position":"PHPER","map_type":"1","map_time":"2015-04-16 07:00", "map_address":"天津市河北区"}}';
		$this->actionCreateAppoint($request);
	}

	public function actionTestetCateTagsOrder(){
		$request = '{"mm":"biaoqian","mw":{"mtags_modelId":"1"}, "ms":"tagName,modelId"}';
		$this->actionGetCateTagsOrder($request);
	}
	public function actionTestLecturerRecentSchedule(){
		$request = '{"mm": "jiaolian","ms": "c.title,ml_name,c.courseid,s.startTime,s.address","mo": "0","ml": "5"}';
		$this->actionLecturerRecentSchedule($request);
	}

	// 添加一条新的预约
	public function actionCreateAppoint($request = null) 
	{	
		$request = $this->checkRequest($request);
		$request = $this->unFormatRequest($request);
		$apponintModel = new \backend\models\MsupAppoint;
		$return = $apponintModel->createOneAppoint($request['request']);
		if ( $return > 0) {
			echo $this->api->errorHandler->pushDataByJson([ 'appid' => (string)$return]);
		} else {
			echo $this->api->errorHandler->badRequest();
		}
	}

	/**
	 * 获得教练的课程
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionLecturersCourses($request = null)
	{
		$post = $this->checkRequest($request);
		$courseid = $post['mc_id'];
		$post = $this->unFormatRequest($post);

		$courseLecturerModel = new \backend\models\MsupCourseLecturer;
		$query = $courseLecturerModel->find()->with(['lecturerCourses' => function($query) use($select){
			$query->with(['course' => function($query) use ($select){
				$query->select($select);
			}]);
		}]);

		$query = ($courseid) ? $query->where(['cid' => $courseid]) : $query;
		$row = $query->asArray()->all();
		$this->saveCache($this->checkRequest($request), $row);
		echo $this->api->errorHandler->pushDataByJson($row);
	}

	// 本月热销课程
	public function actionHotCourseOnMounth($request = null) {

        $firstday = strtotime(date('Y-M-1 00:00:00', time()));
        $lastday = mktime(23, 59, 59, date('m', time()) + 1, date("d", time()), date('Y', time()));
		$request = $this->checkRequest($request);
		$request = $this->unFormatRequest($request);
		$model = new MsupSchedulingVenueCourse;
		$row = $model->find()
					 ->select('date,c.title,c.courseid')
					 ->innerJoin(MsupCourse::tableName().' c', $model->tableName().'.courseid = c.courseid')
					 ->where($model->tableName().'.date >'.$firstday.' AND '.$model->tableName().'.date <'.$lastday.' AND c.assignToSalon=0 ')
					 ->groupBy('c.courseid,'.$model->tableName().'.sid')
					 ->orderBy($request['order'])
					 ->limit($request['limit'])
					 ->asArray()
					 ->all();

		$this->saveCache($this->checkRequest(Yii::$app->request->get('data')), $row);
		echo $this->api->errorHandler->pushDataByJson($row);
	}
		
	// 检查请求输入数据是否正确
	private function checkRequest($request = null) {
		if (!Yii::$app->request->get('data') && !$request) $this->api->errorHandler->badRequest();
		return json_decode( ($request) ?  $request : Yii::$app->request->get('data'), true );
	}

	/**
	 * 搜索接口，可以获得搜索结果中每个标签的引用的次数
	 * @return [type] [description]
	 */
	public function actionSearch($request = null) {
		$post = $this->checkRequest($request); 
		$post = $this->unFormatRequest($post);
		$model = $this->api->getModel($post['model']);
		$tagRelationModel = new \backend\models\MsupTagRelation;
		$sql = 'SELECT ';

		if ($post['select']) {
			$sql .= $post['select'];
		} else {
			$sql .= '*';
		}

		$sql .= ' from '.$model::tableName().' as c left join ' .$tagRelationModel::tableName().' as tr on c.'.$model->primaryKey()[0].' = tr.pkId where tr.modelId='.$model->modelId;
		
		if (!empty($post['where'])) {
			$sql .= ' AND '.$post['where'].' ';
		}

	    $sql .= ' group by tagId';
	    if ( !empty($post['orderBy'])) {
	    	$sql .= ' order by '.$post['orderBy'];
	    }
		$limit = '';
		if (!empty($post['offset'])) {
			$limit .= $post['offset'].',';
		}
		if (!empty($post['limit'])) {
			$limit .= $post['limit'];
			$sql .= ' limit '.$limit;
		}
		$row = $model->findBySql($sql)->asArray()->all();
		$this->saveCache($this->checkRequest($request), $row);
		$this->api->errorHandler->pushDataByJson($row);
	}

	/**
	 * 搜索排课课程
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionSearchCourse($request = null) {
		$model = new MsupCourse;
		$sql = $this->getSearchCourseSql($request);
		$row = $model->findBySql($sql)->asArray()->all();

		foreach($row as $key => &$value) {
			$model = new \backend\models\MsupCourseLecturer();
			$lecturer = $model->find()->select('lid')->where(['cid' => $value['courseid']])->with('lecturer')->asArray()->all();
			$value['lecturer'] = $lecturer;
		}
		$this->saveCache($this->checkRequest($request), $row);
		$this->api->errorHandler->pushDataByJson($row);
	}
	// 格式化请求数据
	private function unFormatRequest($post){
		$request = new \components\api\Request;
		return $request->unFormatRequest($post);
	}
	/**
	 * 获得某个栏目下的标签的使用排名情况
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionGetCateTagsOrder($request = null){
		$post = $this->unFormatRequest($this->checkRequest($request));

		$model = new \backend\models\MsupTags;
		$order = trim(' num desc,'.$post['orderBy'], ',');
		$select = trim($post['select'].", count(tagId) as num");
		$row = $model->find()
					 ->innerJoin(MsupTagRelation::tableName().' t', $model->tableName().'.id = t.tagId')
					 ->where($post['where'])
					 ->select($select)
					 ->orderBy($order)
					 ->offset($post['offset'])
					 ->limit($post['limit'])
					 ->groupBy('tagId')
					 ->asArray()
					 ->all();
		$this->saveCache($this->checkRequest($request), $row);
		$this->api->errorHandler->pushDataByJson($row);

	}

	// 教练最新排期
	public function actionLecturerRecentSchedule($request = null){
		$post = $this->unFormatRequest($this->checkRequest($request));
		$model = new MsupLecturer;
		$row = $model->find()
					 ->innerJoin(MsupCourseLecturer::tableName() . ' cl', $model->tableName().'.id=cl.lid')
					 ->innerJoin(MsupCourse::tableName() . ' c', 'c.courseid = cl.cid')
					 ->innerJoin(MsupSchedulingVenueCourse::tableName() . ' sc', 'sc.courseid = c.courseid')
					 ->innerJoin(MsupScheduling::tableName() . ' s','sc.sid = s.id')
					 ->where($post['where'])
					 ->select($post['select'])
					 ->orderBy($post['order'])
					 ->offset($post['offset'])
					 ->limit($post['limit'])
					 ->groupBy('c.courseid')
					 ->asArray()
					 ->all();
		$this->saveCache($this->checkRequest($request), $row);
		$this->api->errorHandler->pushDataByJson($row);

	}

	// 获得搜索课程的 SQL 语句
	private function getSearchCourseSql($request){
		$post = $this->checkRequest($request);
		$post = $this->unFormatRequest($post);
		$model = new MsupCourse;
		$tagRelationModel = new MsupTagRelation;
		$sql = 'SELECT ';
		if (!empty($post['select'])) {
			$sql .= $post['select'];
		} else {
			$sql .= ' * ';
		}

		// 初始 SQL
		$sql .= ' from '.$model::tableName().' as c inner join '.MsupTags::tableName().' as t inner join '.MsupTagRelation::tableName().' as tr on c.courseid = tr.pkId  and tr.modelId = 4 and tr.tagId = t.id ';

		// 是否有条件查询
		if (!empty($post['where'])) {
			$where .= ' where '.addslashes($post['where']).' ';
		}
		// 如果有开始或者结束时间则与排课表关联
		if ($where && (strpos($where, 'startTime') || strpos($where, 'endTime'))) {
			$sql .= 'inner join ';
		} else {
			$sql .= ' left join ';
		}
		$sql .= MsupSchedulingVenueCourse::tableName().' as sc  on  c.courseid=sc.courseid left join '.MsupScheduling::tableName().' as s  on sc.sid=s.id ';
		$group .= ' group by '.(isset($post['groupBy']) ? $post['groupBy'] : '  c.courseid');

		if (!empty($post['orderBy'])) {
			$order .= ' order by '.$post['orderBy']; 
		} else {
			$order .= ' order by c.courseid desc ';
		}
		$sql .= $where . $group . $order;
		$limit = '';
		if (!empty($post['offset'])) {
			$limit .= intval($post['offset']).',';
		}
		if (!empty($post['limit'])) {
			$limit .= intval($post['limit']);
			$sql .= ' limit '.$limit;
		}

		return stripcslashes($sql);
	}

	/**
	 * [actionGetTheNumberOfTagsInSearchCourse description]
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionGetTheNumberOfTagsInSearchCourse($request = null){
		$sql = $this->getSearchCourseSql($request);
		$row = $this->countNumberOfTagsBySql($sql);
		$this->saveCache($this->checkRequest($request), $row);
		$this->api->errorHandler->pushDataByJson($row);
	}
	/**
	 * 短信发送接口
	 * @param  integer  $mobile 手机号
	 * @param  string   $message  要发送的信息
	 * @return [type] [description]
	 */
	public function actionShortMessage($request = null){
		$request = $this->checkRequest($request);
		$handler = $this->api->errorHandler;
		if (!$request['mobile'] || !preg_match('/\d{11}/', $request['mobile'])) {
			$errno = 4001;
			$errmsg = '手机号码错误';
		} else {
			$shortMessage = Yii::$app->ShortMessageManager;
			if (!$request['company']) $request['company'] = '麦思博';
			// $request['message'] .= '【'.$request['company'].'】';
			if ( $shortMessage->sendShortMessage($request['mobile'], $request['message'])){
				$errno = $handler::ERROR_CODE_0;
				$errmsg =  $handler::ERROR_MESSAGE_0;
			} else {
				$errno = 4002;
				$errmsg = '短信发送失败';
			}
		}
		$handler->setErrorCode($errno, $errmsg);
	}
	/**
	 * 生成短链接
	 * @param  [type] $request $request['url']
	 * @return [type]          [description]
	 */
	public function actionShortUrl($request){
		$request = $this->checkRequest($request);
		$handler = $this->api->errorHandler;
		if (!$request['url']) {
			$handler->setErrorCode(5001, '长链接错误');
		} else {
			$shortUrl = new \components\ShortUrl;
			$res = $shortUrl->create($request['url']);

			if ($res['errno'] == 0) {
				echo $handler->pushDataByJson($res);
			} else {
				echo $handler->setErrorCode(5002, '服务器忙碌中，请重试');
			}
		}
	}

	/**
	 * 通过 SQL 语句统计标签的数量
	 * @param  [type] $sql [description]
	 * @return [type]      [description]
	 */
	private function countNumberOfTagsBySql($sql){
		$sql = "SELECT count(tagId) as num, tagId from ($sql) AS tagId GROUP BY tagId";
		$model = new MsupCourse;
		$row = $model->findBySql($sql)->asArray()->all();
		return $row;
	}	


}


?>
