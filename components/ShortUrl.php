<?php 
namespace components;
/**
 * 短网址生成
 * @link   www.msup.com.cn
 * @author stromKnight <410345759@qq.com>
 * @since  1.0 
 */
use yii;
class ShortUrl {
	public $postUrl = 'http://www.dwz.cn/create.php';
	public $site = 'http://p.msup.cn/';

	/**
	 * [create description]
	 * @param  [string] $url 	   长链接，带 http://
	 * @return [array]  $return    ['errno','errmsg','shortUrl', 'longUrl']
	 */
	public function create($url){
		$shortModel = new \backend\models\MsupShortUrl;
		$short = Yii::$app->security->generateRandomString(4);
		$shortModel->longUrl = $url;
		$shortModel->shortUrl = $this->site.$short;
		if ($shortModel->save()){
			$return = [ 'errno' => 0, 'errmsg' => '', 'shortUrl' => $shortModel->shortUrl, 'longUrl' => $shortModel->longUrl];
		} else {
			$return = ['errno'=> '-1', 'errmsg' => '生成失败'];
		}
		$shortRow = $shortModel->find(['shortUrl' => $shortModel->shortUrl])->one();
		if ($shorRow->id) {
			$this->create($url);
		} else {
			return $return;
		}
		// $ch = curl_init();
		// curl_setopt($ch, CURLOPT_URL, $this->postUrl);

		// curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
		// curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE); 
		// curl_setopt($ch, CURLOPT_HEADER, FALSE);

		// curl_setopt($ch, CURLOPT_POST, TRUE);
		// curl_setopt($ch, CURLOPT_POSTFIELDS, ['url' => $url]);
		// // p($url);
		// $res = curl_exec($ch);
		// curl_close($ch);
		// return json_decode($res, true);
	}
}

?>