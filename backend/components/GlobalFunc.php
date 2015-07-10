<?php 
namespace backend\components;
use Yii;

/**
 * 公共函数类
 * @author <410345759@qq.com>
 * @license
 * 
 */

class GlobalFunc{
	

	/**
	 * json格式化输出上传文件后的表单
	 *
	 * @input  json  json_encode($upload)
	 * @return array json_deconde($upload)
	 */
	public static function uploadFormat($upload) {

		if (is_array($upload) && !empty($upload)) {
			return  json_encode($upload);
 		} else if ( is_string($upload) ) {
 			
 			$data = json_decode($upload, 1);

 			return (empty($data))? null :$data;

 		} else {
 			return null;
 		}
	}

	/**
	 * 返回经addslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_addslashes($string){
		if(!is_array($string)) return addslashes($string);
		foreach($string as $key => $val) $string[$key] = $this->new_addslashes($val);
		return $string;
	}

	/**
	 * 返回经stripslashes处理过的字符串或数组
	 * @param $string 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_stripslashes($string) {
		if(!is_array($string)) return stripslashes($string);
		foreach($string as $key => $val) $string[$key] = $this->new_stripslashes($val);
		return $string;
	}

	/**
	 * 返回经htmlspecialchars处理过的字符串或数组
	 * @param $obj 需要处理的字符串或数组
	 * @return mixed
	 */
	function new_html_special_chars($string) {
		$encoding = 'utf-8';
		if(strtolower(CHARSET)=='gbk') $encoding = 'ISO-8859-15';
		if(!is_array($string)) return htmlspecialchars($string,ENT_QUOTES,$encoding);
		foreach($string as $key => $val) $string[$key] = $this->new_html_special_chars($val);
		return $string;
	}

	function new_html_entity_decode($string) {
		$encoding = 'utf-8';
		if(strtolower(CHARSET)=='gbk') $encoding = 'ISO-8859-15';
		return html_entity_decode($string,ENT_QUOTES,$encoding);
	}

	function new_htmlentities($string) {
		$encoding = 'utf-8';
		if(strtolower(CHARSET)=='gbk') $encoding = 'ISO-8859-15';
		return htmlentities($string,ENT_QUOTES,$encoding);
	}

	/**
	 * 安全过滤函数
	 *
	 * @param $string
	 * @return string
	 */
	function safe_replace($string) {
		$string = str_replace('%20','',$string);
		$string = str_replace('%27','',$string);
		$string = str_replace('%2527','',$string);
		$string = str_replace('*','',$string);
		$string = str_replace('"','&quot;',$string);
		$string = str_replace("'",'',$string);
		$string = str_replace('"','',$string);
		$string = str_replace(';','',$string);
		$string = str_replace('<','&lt;',$string);
		$string = str_replace('>','&gt;',$string);
		$string = str_replace("{",'',$string);
		$string = str_replace('}','',$string);
		$string = str_replace('\\','',$string);
		return $string;
	}
	
	
	/**
	 * xss过滤函数
	 *
	 * @param $string
	 * @return string
	 */
	function remove_xss($string) { 
	    $string = preg_replace('/[\x00-\x08\x0B\x0C\x0E-\x1F\x7F]+/S', '', $string);

	    $parm1 = Array('javascript', 'vbscript', 'expression', 'applet', 'meta', 'xml', 'blink', 'link', 'script', 'embed', 'object', 'iframe', 'frame', 'frameset', 'ilayer', 'layer', 'bgsound', 'title', 'base');

	    $parm2 = Array('onabort', 'onactivate', 'onafterprint', 'onafterupdate', 'onbeforeactivate', 'onbeforecopy', 'onbeforecut', 'onbeforedeactivate', 'onbeforeeditfocus', 'onbeforepaste', 'onbeforeprint', 'onbeforeunload', 'onbeforeupdate', 'onblur', 'onbounce', 'oncellchange', 'onchange', 'onclick', 'oncontextmenu', 'oncontrolselect', 'oncopy', 'oncut', 'ondataavailable', 'ondatasetchanged', 'ondatasetcomplete', 'ondblclick', 'ondeactivate', 'ondrag', 'ondragend', 'ondragenter', 'ondragleave', 'ondragover', 'ondragstart', 'ondrop', 'onerror', 'onerrorupdate', 'onfilterchange', 'onfinish', 'onfocus', 'onfocusin', 'onfocusout', 'onhelp', 'onkeydown', 'onkeypress', 'onkeyup', 'onlayoutcomplete', 'onload', 'onlosecapture', 'onmousedown', 'onmouseenter', 'onmouseleave', 'onmousemove', 'onmouseout', 'onmouseover', 'onmouseup', 'onmousewheel', 'onmove', 'onmoveend', 'onmovestart', 'onpaste', 'onpropertychange', 'onreadystatechange', 'onreset', 'onresize', 'onresizeend', 'onresizestart', 'onrowenter', 'onrowexit', 'onrowsdelete', 'onrowsinserted', 'onscroll', 'onselect', 'onselectionchange', 'onselectstart', 'onstart', 'onstop', 'onsubmit', 'onunload');

	    $parm = array_merge($parm1, $parm2); 

		for ($i = 0; $i < sizeof($parm); $i++) { 
			$pattern = '/'; 
			for ($j = 0; $j < strlen($parm[$i]); $j++) { 
				if ($j > 0) { 
					$pattern .= '('; 
					$pattern .= '(&#[x|X]0([9][a][b]);?)?'; 
					$pattern .= '|(&#0([9][10][13]);?)?'; 
					$pattern .= ')?'; 
				}
				$pattern .= $parm[$i][$j]; 
			}
			$pattern .= '/i';
			$string = preg_replace($pattern, ' ', $string); 
		}
		return $string;
	}

	/**
	 * 过滤ASCII码从0-28的控制字符
	 * @return String
	 */
	function trim_unsafe_control_chars($str) {
		$rule = '/[' . chr ( 1 ) . '-' . chr ( 8 ) . chr ( 11 ) . '-' . chr ( 12 ) . chr ( 14 ) . '-' . chr ( 31 ) . ']*/';
		return str_replace ( chr ( 0 ), '', preg_replace ( $rule, '', $str ) );
	}

	/**
	 * 格式化文本域内容
	 *
	 * @param $string 文本域内容
	 * @return string
	 */
	function trim_textarea($string) {
		$string = nl2br ( str_replace ( ' ', '&nbsp;', $string ) );
		return $string;
	}

	/**
	 * 将文本格式成适合js输出的字符串
	 * @param string $string 需要处理的字符串
	 * @param intval $isjs 是否执行字符串格式化，默认为执行
	 * @return string 处理后的字符串
	 */
	function format_js($string, $isjs = 1) {
		$string = addslashes(str_replace(array("\r", "\n", "\t"), array('', '', ''), $string));
		return $isjs ? 'document.write("'.$string.'");' : $string;
	}

	/**
	 * 转义 javascript 代码标记
	 *
	 * @param $str
	 * @return mixed
	 */
	 function trim_script($str) {
		if(is_array($str)){
			foreach ($str as $key => $val){
				$str[$key] = trim_script($val);
			}
	 	}else{
	 		$str = preg_replace ( '/\<([\/]?)script([^\>]*?)\>/si', '&lt;\\1script\\2&gt;', $str );
			$str = preg_replace ( '/\<([\/]?)iframe([^\>]*?)\>/si', '&lt;\\1iframe\\2&gt;', $str );
			$str = preg_replace ( '/\<([\/]?)frame([^\>]*?)\>/si', '&lt;\\1frame\\2&gt;', $str );
			$str = str_replace ( 'javascript:', 'javascript：', $str );
	 	}
		return $str;
	}
	/**
	 * 获取当前页面完整URL地址
	 */
	function get_url() {
		$sys_protocal = isset($_SERVER['SERVER_PORT']) && $_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://';
		$php_self = $_SERVER['PHP_SELF'] ? $this->safe_replace($_SERVER['PHP_SELF']) : $this->safe_replace($_SERVER['SCRIPT_NAME']);
		$path_info = isset($_SERVER['PATH_INFO']) ? $this->safe_replace($_SERVER['PATH_INFO']) : '';
		$relate_url = isset($_SERVER['REQUEST_URI']) ? $this->safe_replace($_SERVER['REQUEST_URI']) : $php_self.(isset($_SERVER['QUERY_STRING']) ? '?'.$this->safe_replace($_SERVER['QUERY_STRING']) : $path_info);
		return $sys_protocal.(isset($_SERVER['HTTP_HOST']) ? $_SERVER['HTTP_HOST'] : '').$relate_url;
	}
	/**
	 * 字符截取 支持UTF8/GBK
	 * @param $string
	 * @param $length
	 * @param $dot
	 */
	function str_cut($string, $length, $dot = '...') {
		$strlen = strlen($string);
		if($strlen <= $length) return $string;
		$string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);
		$strcut = '';
		if(strtolower(CHARSET) == 'utf-8') {
			$length = intval($length-strlen($dot)-$length/3);
			$n = $tn = $noc = 0;
			while($n < strlen($string)) {
				$t = ord($string[$n]);
				if($t == 9 || $t == 10 || (32 <= $t && $t <= 126)) {
					$tn = 1; $n++; $noc++;
				} elseif(194 <= $t && $t <= 223) {
					$tn = 2; $n += 2; $noc += 2;
				} elseif(224 <= $t && $t <= 239) {
					$tn = 3; $n += 3; $noc += 2;
				} elseif(240 <= $t && $t <= 247) {
					$tn = 4; $n += 4; $noc += 2;
				} elseif(248 <= $t && $t <= 251) {
					$tn = 5; $n += 5; $noc += 2;
				} elseif($t == 252 || $t == 253) {
					$tn = 6; $n += 6; $noc += 2;
				} else {
					$n++;
				}
				if($noc >= $length) {
					break;
				}
			}
			if($noc > $length) {
				$n -= $tn;
			}
			$strcut = substr($string, 0, $n);
			$strcut = str_replace(array('∵', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), array(' ', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), $strcut);
		} else {
			$dotlen = strlen($dot);
			$maxi = $length - $dotlen - 1;
			$current_str = '';
			$search_arr = array('&',' ', '"', "'", '“', '”', '—', '<', '>', '·', '…','∵');
			$replace_arr = array('&amp;','&nbsp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;',' ');
			$search_flip = array_flip($search_arr);
			for ($i = 0; $i < $maxi; $i++) {
				$current_str = ord($string[$i]) > 127 ? $string[$i].$string[++$i] : $string[$i];
				if (in_array($current_str, $search_arr)) {
					$key = $search_flip[$current_str];
					$current_str = str_replace($search_arr[$key], $replace_arr[$key], $current_str);
				}
				$strcut .= $current_str;
			}
		}
		return $strcut.$dot;
	}



	/**
	 * 获取请求ip
	 *
	 * @return ip地址
	 */
	function ip() {
		if(getenv('HTTP_CLIENT_IP') && strcasecmp(getenv('HTTP_CLIENT_IP'), 'unknown')) {
			$ip = getenv('HTTP_CLIENT_IP');
		} elseif(getenv('HTTP_X_FORWARDED_FOR') && strcasecmp(getenv('HTTP_X_FORWARDED_FOR'), 'unknown')) {
			$ip = getenv('HTTP_X_FORWARDED_FOR');
		} elseif(getenv('REMOTE_ADDR') && strcasecmp(getenv('REMOTE_ADDR'), 'unknown')) {
			$ip = getenv('REMOTE_ADDR');
		} elseif(isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], 'unknown')) {
			$ip = $_SERVER['REMOTE_ADDR'];
		}
		return preg_match ( '/[\d\.]{7,15}/', $ip, $matches ) ? $matches [0] : '';
	}

	function get_cost_time() {
		$microtime = microtime ( TRUE );
		return $microtime - SYS_START_TIME;
	}
	/**
	 * 程序执行时间
	 *
	 * @return	int	单位ms
	 */
	function execute_time() {
		$stime = explode ( ' ', SYS_START_TIME );
		$etime = explode ( ' ', microtime () );
		return number_format ( ($etime [1] + $etime [0] - $stime [1] - $stime [0]), 6 );
	}

	/**
	* 产生随机字符串
	*
	* @param    int        $length  输出长度
	* @param    string     $chars   可选的 ，默认为 0123456789
	* @return   string     字符串
	*/
	function random($length, $chars = '0123456789') {
		$hash = '';
		$max = strlen($chars) - 1;
		for($i = 0; $i < $length; $i++) {
			$hash .= $chars[mt_rand(0, $max)];
		}
		return $hash;
	}

	/**
	* 将字符串转换为数组
	*
	* @param	string	$data	字符串
	* @return	array	返回数组格式，如果，data为空，则返回空数组
	*/
	public static function string2array($data) {
		if($data == '') return array();
		@eval("\$array = $data;");
		return $array;
	}
	/**
	* 将数组转换为字符串
	*
	* @param	array	$data		数组
	* @param	bool	$isformdata	如果为0，则不使用new_stripslashes处理，可选参数，默认为1
	* @return	string	返回字符串，如果，data为空，则返回空
	*/
	function array2string($data, $isformdata = 1) {
		if($data == '') return '';
		if($isformdata) $data = $this->new_stripslashes($data);
		
		return addslashes(var_export($data, TRUE));
	}


	/**
	 * 以KB MB GB TB 格式显示文件大小
	 * @param  [type] $fileSize [文件大小]
	 * @return [type] $fileSize [格式化后的文件大小]
	 */
	function format_bytes($fileSize){
		$units = array('B', 'KB', 'MB', 'GB', 'TB');
		for($i=0;$fileSize >= 1024 && $i<4; $i++) $fileSize /=1024;
		return round($fileSize,2).$units[$i];
	}

	/**
	 * 获得文件大小
	 * @param  [type] $file [description]
	 * @return [type]       [description]
	 */
	function getFileSize($file) {
		$file = @stat($file);
		$fileSize = $this->format_bytes($file[7]);
		return $fileSize;
	}

	/**
	 * 查询字符是否存在于某字符串
	 *
	 * @param $haystack 字符串
	 * @param $needle 要查找的字符
	 * @return bool
	 */
	function str_exists($haystack, $needle)
	{
		return !(strpos($haystack, $needle) === FALSE);
	}

	/**
	 * 取得文件扩展
	 *
	 * @param $filename 文件名
	 * @return 扩展名
	 */
	function fileext($filename) {
		return strtolower(trim(substr(strrchr($filename, '.'), 1, 10)));
	}

	/**
	 * 判断email格式是否正确
	 * @param $email
	 */
	function is_email($email) {
		return strlen($email) > 6 && preg_match("/^[\w\-\.]+@[\w\-\.]+(\.\w+)+$/", $email);
	}


	/**
	 * Function dataformat
	 * 时间转换
	  * @param $n INT时间
	 */
	 function dataformat($n) {
		$hours = floor($n/3600);
		$minite	= floor($n%3600/60);
		$secend = floor($n%3600%60);
		$minite = $minite < 10 ? "0".$minite : $minite;
		$secend = $secend < 10 ? "0".$secend : $secend;
		if($n >= 3600){
			return $hours.":".$minite.":".$secend;
		}else{
			return $minite.":".$secend;
		}

	 } 


	 /**
	  * 获得字符串$char在另外一个字符串 $str 中任意出现第N次时的位置
	  * @param  [type] $str    被查找的字符串
	  * @param  [type] $char   查找的字符串
	  * @param         $n      第几次
	  * @param  [type] $offset 从什么位置开始查
	  * @return [type] $num    0：在字符串中$str 查找不到第 $N 次 $char 出现的位置
	  */
	 public static function getCharPost($str, $char, $n, $offset = 0) {
	 	
	 	$nums = substr_count($str, $char);
	 	if ($nums < $n) return 0;
	 	$pos = stripos($str, $char, $offset);
	 	$n--;
	 	if ( $n > 0 && $pos !== false ) {
	 		$pos = self::getCharPost($str, $char, $n, $pos+1);
	 	}
	 	return $pos;
	 }
	 
	 /**
	  * 获得字符串$char在另外一个字符串 $str 中倒数任意出现第N次时的位置
	  * @param  [type] $str    被查找的字符串
	  * @param  [type] $char   查找的字符串
	  * @param         $n      第几次
	  * @param  [type] $offset 从什么位置开始查
	  * @return [type] $num    0：在字符串中$str 查找不到第 $N 次 $char 出现的位置
	  */
	 public static function rGetCharPost($str, $char, $n, $offset = 0) {
	 	
	 	$nums = substr_count($str, $char);
	 	if ($nums < $n) return 0;
	 	$pos = strrpos($str, $char,$offset);
	 	$n--;
	 	if ( $n > 0 && $pos !== false ) {
	 		$pos = self::rGetCharPost($str, $char, $n, ($pos-strlen($str)-1));
	 	}
	 	return $pos;
	 }
	 /**
	  * 将数组存到数据库中的函数
	  * @param array|string $arr 需要转换的的数组或者是反转的字符串
	  * @param boolean $decode
	  * @return array|string
	  */
	 public static function serializeMysql($arr,$decode = false){
	     if($decode){
	         return unserialize(stripslashes($arr));
	     }
	     return addslashes(serialize($arr));
	 }

	 
}
?>
