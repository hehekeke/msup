<?php 
namespace components\api;
use Yii;

class UserErrorHandler extends BaseErrorHandler {

	const ERROR_CODE_7 = '7';
	const ERROR_CODE_8 = '8';
	const ERROR_CODE_9 = '9';
	const ERROR_CODE_10 = '10';
	const ERROR_CODE_11 = '11';
	const ERROR_CODE_12 = '12';
	const ERROR_CODE_13 = '13';

	const ERROR_MESSAGE_7 = '该用户已存在';
	const ERROR_MESSAGE_8 = '用户名密码错误';
	const ERROR_MESSAGE_9 = '邮箱已存在';
	const ERROR_MESSAGE_10 = '手机号码不能为空';
	const ERROR_MESSAGE_11 = '密码不能为空';
	const ERROR_MESSAGE_12 = '注册失败';
	const ERROR_MESSAGE_13 = '会员不存在';


	public function userIsExist() {
		$this->setErrorCode(self::ERROR_CODE_7, self::ERROR_MESSAGE_7);
	}
	public function userIsNotExist() {
		$this->setErrorCode(self::ERROR_CODE_13, self::ERROR_MESSAGE_13);
	}

	public function passwordIsError() {
		$this->setErrorCode(self::ERROR_CODE_8, self::ERROR_MESSAGE_8);
	}
	public function emailIsExist(){
		$this->setErrorCode(self::ERROR_CODE_9, self::ERROR_MESSAGE_9);

	}
	// 注册失败信息返回
	public function sendRegisterErrors($errors){
		$return['errno'] = self::ERROR_CODE_12;
		$return['msg'] = self::ERROR_MESSAGE_12;
		$return['data'] = $errors;
		echo $this->formatOut($return);
	}
	public function sendMemberInfoErrors($errors){
		if (!empty($errors['username'])) {
			$this->userIsExist();
		} else if (!empty($errors['email'])) {
			$this->emailIsExist();
		}
	}
}

?>