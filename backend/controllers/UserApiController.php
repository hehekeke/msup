<?php
namespace backend\controllers;

use Yii;
use yii\base\Controller;
use backend\models\MsupCourse;
use backend\models\MsupLecturer;
use backend\models\MsupScheduling;
use backend\models\MsupMemberInfo;
use backend\models\MsupUserMember;
use backend\models\MsupSites;
use backend\models\MsupCaseSubmit;
use backend\components\ApiAccest;

use components\api\BaseApi;
use yii\helpers\ArrayHelper;
/**
 * 用户相关 API
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
     
class UserApiController extends Controller
{
	public $returnCode;
	public $api;
	public function init()
	{
		header('Content-type:application/json');
		$apiAccest = new ApiAccest;
		$this->returnCode =  $apiAccest->checkNumberOfTimes();
		$this->api =  new BaseApi;
		$errorHandler = new \components\api\UserErrorHandler();
		$this->api->setErrorHandler($errorHandler);
		$this->api->setRequest(new \components\api\InputRequest);
		if ( !empty( $this->returnCode ) ) {
			$this->api->errorHandler->setErrorCode($this->returnCode['errno'], $this->returnCode['errmsg']);
		}
	}
	private function checkRequest($request = null) {
		if (!Yii::$app->request->get('data') && !$request) $this->api->errorHandler->badRequest();
		$request = json_decode( ($request) ?  $request : Yii::$app->request->get('data'), true );
		return $request;
	}
	public function actionTestRegister(){
		$request = [
						'huiyuan' => [
							'mu_email' => '41034a3189@qq.com',
							'mu_userName' => '15233828826',
							'mu_phone' => '15233828826',
							'mu_password' => 'z1991921'
						],
						'huiyuanxinxi' => [
							'mmi_company' => 'msup',
							'mmi_position' => 'phper',
							'mmi_name' => '王五',
						]
				   ];

		$this->actionRegister(json_encode($request));
	}

	public function actionTestLogin(){
		$request = [
						'huiyuan' => [
							'mu_userName' => '15233828826',
							'mu_password' => 'z199192'
						]
					];
		$this->actionLogin(json_encode($request));
	}
	public function actionTestEdit(){
				$request = [
						'huiyuan' => [
							'mu_email' => '41034a3199@qq.com',
							'mu_userName' => '15620828006',
							'mu_phone' => '15620828006',
							'mu_password' => 'z1991920'
						],
						'huiyuanxinxi' => [
							'mmi_company' => 'msuper',
							'mmi_position' => 'php',
							'mmi_name' => '王五麻子',
						]
				   ];

		$this->actionEdit('{"huiyuan":{"mu_phone":"13672138493","mu_email":"624810010@qq.com","mu_password":"111111","mu_userName":"13672138493"},"huiyuanxinxi":{"mmi_name":"\u6731\u654f","mmi_company":"\u9ea6\u601d\u535a","mmi_position":"php"}}');
	}
	public function actionTestResetPassword($value='')
	{
		$request = [
			'huiyuan' => [
				'mu_phone' => '15620828006',
				'mu_password' => 'z1991921'
			],
	   ];
	   $this->actionResetPassword(json_encode($request));
	}


	public function actionRegister($request = []){

		$memberModel = new MsupUserMember;
		$infoModel = new MsupMemberInfo;
		$request = $this->api->request->unformatInputRequest($this->checkRequest($request));

		// 检查手机号是否已经被注册
		$user = $this->checkUserIsExsits($request['userMember']['phone']);
		if (!$user->id) {
			$request['userMember']['create_admin'] = 0;
			$request['userMember']['source_site'] = MsupSites::getSiteId($_SESSION['HTTP_REFERER']);
			$member = $memberModel->create($request['userMember']);
		} else {
			$this->api->errorHandler->userIsExist();
		}

		// 先保存创建会员帐号密码，再保存会员的信息
		if ($member->id) {
			$request['memberInfo']['userId'] = $member->id;
			$info = $infoModel->create($request['memberInfo']);
			if ( $info->id ){
				echo $this->api->errorHandler->pushDataByJson(['userId' => $member->id,'username' => $member->username]);
			} else {
				$this->api->errorHandler->sendRegisterErrors($info);
			}
		} else {
			$this->api->errorHandler->sendRegisterErrors($member->errors);
		}
	}

	/**
	 * 编辑修改会员信息
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionEdit($request = null){
		$request = $this->api->request->unformatInputRequest($this->checkRequest($request));
		$phone = $request['userMember']['phone'];
		$membermodel = new MsupUserMember;
		// 根据手机号码查询该会员是否存在
		$member = $membermodel->getOneMemberByPhone($phone);
		if (!$member->id) {
			echo $this->api->errorHandler->userIsNotExist();exit;
		}
		if ( $request['userMember']['password'] ) {
			$member->resetPassword($request['userMember']['password']);
		}
		// 完善会员表的信息
		$membermodel = $membermodel->ifNotExistsThenCreateOne(['id' => $member->id], $request['userMember']);
		$memberInfoModel = new MsupMemberInfo;

		// 完善该会员的详细信息
		$memberInfoModel = $memberInfoModel->ifNotExistsThenCreateOne(['userId' => $member->id], $request['memberInfo']);
		if(!$membermodel->errors && !$memberInfoModel->errors){
				echo $this->api->errorHandler->pushDataByJson(['userId' => $member->id,'username' => $membermodel->username]);
		} else  {
			echo json_encode($membermodel->errors);
			echo json_encode($memberInfoModel->errors);
		}
	}

	/**
	 * 重设密码
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionResetPassword($request = null){
		$request = $this->api->request->unformatInputRequest($this->checkRequest($request));
		$phone = $request['userMember']['phone'];
		// 检查用户密码是否正确
		if (!$request['userMember']['password']) {
			echo $this->api->errorHandler->passwordIsError();exit;
		}
		$memberModel = new MsupUserMember;
		$member = $memberModel->getOneMemberByPhone($phone);
		// 检查用户是否存在
		if (!$member->id) {
			echo $this->api->errorHandler->userIsNotExist();exit;
		}
		$member->resetPassword($request['userMember']['password']);
		echo $this->api->errorHandler->pushDataByJson(['password' => $member->password_hash]);
	}

	/**
	 * 用户案例提交
	 * @return [type] [description]
	 */
	public function actionTestCaseSubmit($value=''){
		$request = [
						'anlitijiao' => [
		                    'mcs_courseTitle' => '大数据的研究',
		                    'mcs_lecturerName' => '王宇奇',
		                    'mcs_lecturerDescription' => 'phper',
		                    'mcs_lecturerThumbs' => '照片111',
		                    'mcs_courseTag' => '1',
		                    'mcs_companyThumbs' => '照片22',
		                    'mcs_courseDescription' => '不错',
		                    'mcs_lecturerPosition' => '不错',
		                    'mcs_companyDescription' => '9',
		                    'mcs_companyName' => '天津市公司',
		                    'mcs_courseThumbs' => '照片33',
		                    'mcs_companySize' => '22',
		                    'mcs_ccompanyPosition' => '飞机',
		                    'mcs_courseContent' => '你好',
		                    'mcs_userid'=>'1',
						]
						
				   ];
		$this->actionCaseSubmit(json_encode($request));
	}
	public function actionCaseSubmit($request = null){
	
		$model = new MsupCaseSubmit;
        $request = $this->api->request->unformatInputRequest($this->checkRequest($request));

		$info = $model->create($request['caseSubmit']);
			
		if ( $info->id ){
			echo $this->api->errorHandler->pushDataByJson(['userId' => $member->id,'username' => $member->username]);
		} else {
			$this->api->errorHandler->sendRegisterErrors($info);
		}
	}
	
	/**
	 * 获得用户的案例列表
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */

	public function actionGetCaseSubmitList($request = null)
	{
		$model = new MsupCaseSubmit;
        $request = $this->api->request->unformatInputRequest($this->checkRequest($request));
        
        $row = $model->find()->where(['user_id' => $request['caseSubmit']])->asArray()->all();
		// $this->saveCache($this->checkRequest($request), $row);

		$this->api->errorHandler->pushDataByJson($row);

	}
	/**
	 * 添加案例评委的意见
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionTestAddCaseSubmitAdvice($value=''){
		$request = [
						'anlitijiao' => [
		                    'mcs_caseAdvice'=>'这个案例写的太短了111',
		                    'mcs_id'=>'3'
						]
						
				   ];
		$this->actionAddCaseSubmitAdvice(json_encode($request));
	}
	public function actionAddCaseSubmitAdvice($request = null)
	{

		$model = new MsupCaseSubmit;
		$request = $this->api->request->unformatInputRequest($this->checkRequest($request));
		
		$model->id = $request['caseSubmit']['id'];
     	$model->addCaseSubmitAdvice($request['caseSubmit']['caseAdvice']);
		// $this->saveCache($this->checkRequest($request), $row);
	
		// $this->saveCache($this->checkRequest($request), $row);

		
	}

	/**
	 * 获得用户的案例的详细内容 
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
public function actionTestGetCaseSubmitDetailById($value='')
	{
		$request = [
            'mm' => 'anlitijiao',
            
          
//             'mw' => 'msvc_date > 1430442000 AND msvc_date < 1435420799',
            'ms' => '*',
            'mr' => [
                'huiyuan' => [
                    'mm' => 'huiyuan',
                    'ms' => '*'
                ]
            ],
            
//             // 关联查询
//             'mo' => '0',
// //             'mp'=>'msvc_date ASC',
//             // 查询条数
//             'ml' => '5',
//             'mp' => 'msvc_date ASC,msvc_id asc',
//             'mgp' => 'msvc_sid'
        ];
	    $this->actionGetCaseSubmitDetailById(json_encode($request));
				  
	}

	public function actionGetCaseSubmitDetailById($request = null)
	{
		// $model = new MsupCaseSubmit;
  //       $request = $this->api->request->unformatInputRequest($this->checkRequest($request));
       
  //       $row = $model->find()->where(['id' => $request['caseSubmit']])->asArray()->all();
		// // $this->saveCache($this->checkRequest($request), $row);
		$post = $this->checkRequest($request);
		$this->api->queryInit($post)->asArray()->all();
		p($this->api->queryInit($post)->asArray()->all());
		$this->api->errorHandler->pushDataByJson($row);

	}

	/**
	 * 登录
	 * @param  [type] $request [description]
	 * @return [type]          [description]
	 */
	public function actionLogin($request = null){
		$model = new MsupUserMember;
		$request = $this->api->request->unformatInputRequest($this->checkRequest($request));
		$user = $this->checkUserIsExsits($request['userMember']['username']);
		// 检查用户是否存在
		if (!$user->id) {
			$this->api->errorHandler->userIsNotExist();
		}
		// 检查密码是否正确
		if ($user->validatePassword($request['userMember']['password'])) {
				echo $this->api->errorHandler->pushDataByJson(['userId' => $user->id,'username' => $user->username]);
		} else {
			$this->api->errorHandler->passwordIsError();
		}

	}

	/**
	 * 检查用户是否存在
	 * @param  [string]   $phone 用户手机
	 * @return [bollean]         true 存在，false 不存在
	 */
	private function checkUserIsExsits($phone){
		$userModel = new MsupUserMember;
		$user = $userModel->find()->where(['phone' => $phone])->orWhere(['username' => $phone])->one();
		if ($user->id) {
			return $user;
		} else {
			return false;
		}
	}

}

?> 