<?php 
namespace components\api;
use Yii;

class BaseErrorHandler {
	/**
	 * 状态码
	 *   0： 正常
	 *   1: 访问次数过多
	 *   2: 没有权限调用此接口
	 *   3: 模型不存在
	 *   4: 请求的关联模型获取方法不存在
	 *   5: 查询到的结果为空
	 *   6: 无效的请求
	 */
	const ERROR_CODE_0   = '0';
	const ERROR_CODE_1 = '1';
	const ERROR_CODE_2 = '2';
	const ERROR_CODE_3 = '3';
	const ERROR_CODE_4 = '4';
	const ERROR_CODE_5 = '5';
	const ERROR_CODE_6 = '6';
	const ERROR_MESSAGE_0 = '访问成功';
	const ERROR_MESSAGE_1 = '访问次数过多';
	const ERROR_MESSAGE_2 = '没有权限调用此接口';
	const ERROR_MESSAGE_3 = '模型不存在';
	const ERROR_MESSAGE_4 = '请求的关联模型获取方法不存在';
	const ERROR_MESSAGE_5 = '查询到的结果为空';
	const ERROR_MESSAGE_6 = '无效的请求';

	/**
	 * 设置状态码
	 * @param [type] $num [错误码]
	 * @param [type] $msg [错误信息]
	 */
	public function setErrorCode($num, $msg) {
		echo $this->formatOut(json_encode([ 'errno' => (string) $num, 'errmsg' => $msg]));
		exit;
	}

	/**
	 * json格式化输出
	 * @param   mixed $str 需要辈输出的变量
	 * @return [type] [description]
	 */
	public function formatOut($str){
		$str = (is_array($str)) ? json_encode($str) : $str;
		return trim(trim(Yii::$app->request->get('callback'))."(".$str.")");
		
	}

	/**
	 * 将数据用JSON格式化输出
	 * @param  [type] $data [description]
	 * @return [type]       [description]
	 */
	public function pushDataByJson($data) {

		$return = [];
		// 查询到数据空时处理
		if ( empty($data) ) {
			$return['errno'] = self::ERROR_CODE_5;
			$return['errmsg'] = self::ERROR_MESSAGE_5;
			$return['data'] = [];
		} else {
			$return['errno'] = self::ERROR_CODE_0;
			$return['errmsg'] = self::ERROR_MESSAGE_0;
			$return['data'] = $data;			
		}
		echo $this->formatOut($return);
	}
	
	/**
	 * 错误的访问请求
	 * @return [type] [description]
	 */
	public function badRequest()
	{
		$this->setErrorCode(self::ERROR_CODE_6,self::ERROR_MESSAGE_6);
	}
}

?>