<?php 
namespace components\api;
use Yii;
use components\api\Request;
class InputRequest extends  Request {

	public function unformatInputRequest(array $request){

		foreach ($request as $key => $value) {
			unset($request[$key]);
			$key = $this->unFormatModel($key);
			$request[$key] = $value;
			$request[$key] = $this->unFormatField($value, $key);
		}
		return $request;
	}
}

?>