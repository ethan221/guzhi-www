<?php
/**
 * 工具类
 *
 * @author weiqinglei
 */
class Utils {
    /**
     * 生成uuid
     * @return string
     */
    public static function getUUID(){
        return md5(uniqid(mt_rand(), true));
    }

    /**
    * @method: 数字类型判断
    * @params: @$n string 值； @$i bool 是否是整数；@$z bool 是否大于0
    * @return: bool
    **/
    public  static function is_num($n, $i = TRUE, $z = TRUE){
        if($i && $z)
                return preg_match('/^[0-9]+$/',$n);
        else if($i && !$z)
                return is_int($n);
        else if($i == FALSE && !$z)
                return preg_match('/^\d+\.?\d+$/',$n);
        else if($i == FALSE && !$z)
                return preg_match('/^\-?\d+\.?\d*$/',$n);
        return is_numeric($n);
    }

    /**
     * 类型决断
     * @param void $v
     * @param string $type
     * @return boolean
     */
    public static function is_type($v, $type)
    {
	switch ($type) {
		case 'null':
                    return $v === null;
		case 'int':
		case 'integer':
		case 'long':
			return is_int($v);
		case 'float':
		case 'double':
		case 'real':
		  return is_float($v);
		case 'num':
		case 'numeric':
			return is_numeric($v);
		case 'finite':
			return is_finite($v);
		case 'nan':
			return is_nan($v);
		case 'scalar':
			return is_scalar($v);
		case 'res':
		case 'resource':
			return is_resource($v);
		case 'string':
			return is_string($v);
		case 'object':
			return is_object($v);
		case 'array':
			return is_array($v);
		case 'callable':
			return is_callable($v);
		case 'bool':
		case 'boolean':
			return is_bool($v);
		case 'dir':
			return is_dir($v);
		case 'file':
			return is_file($v);
		case 'readable':
			return is_readable($v);
		case 'writable':
		case 'writeable':
			return is_writable($v);
		case 'exec':
		case 'executable':
			return is_executable($v);
		case 'link':
		case 'symlink':
			return is_link($v);
		case 'uploaded':
		case 'uploaded_file':
			return is_uploaded_file($v);
		case 'soap_fault':
			return is_soap_fault($v);
                case 'date':
                     $unixtime = strtotime($v);
                    if (!$unixtime) { //strtotime转换不对，日期格式显然不对。
                        return false;
                    }
                    $formats = array('Y-m-d', 'Y/m/d');
                    foreach ($formats as $format) {
                        if (date($format, $unixtime) == $v) {
                            return true;
                        }
                    }

	}
	return FALSE;
    }
 

    /**
     * 数据验证
     * @param void $v
     * @param string $type (email|mobile|mac|idno|passport|chinese|phone)
     * @return boolean
     */
    public  static function validate($value, $type){

                  switch($type){
                        case 'email':
                            return preg_match("/^([a-zA-Z0-9_-])+(.)+@([a-zA-Z0-9_-])+((\.[a-zA-Z0-9_-]{2,3}){1,2})$/i", $value);
                        case 'mobile':
                            return preg_match("/^1[0-9]{10}$/i", str_replace(' ','',$value));
                        case 'phone':
                            return preg_match("/^1[0-9]{10}$/i", str_replace(' ','',$value)) || preg_match("/^(([0\+]\d{2,3}-)?(0\d{2,3})-)(\d{7,8})(-(\d{3,}))?$/i", str_replace(' ','',$value));
                        case 'mac':
                            return preg_match("/^[A-F0-9]{2}:[A-F0-9]{2}:[A-F0-9]{2}:[A-F0-9]{2}:[A-F0-9]{2}:[A-F0-9]{2}$/i", $value);
                        case 'idno':
                            $value = strtoupper($value);
                            $vCity = array(
                                '11','12','13','14','15','21','22',
                                '23','31','32','33','34','35','36',
                                '37','41','42','43','44','45','46',
                                '50','51','52','53','54','61','62',
                                '63','64','65','71','81','82','91'
                            );
                            if (!preg_match('/^([\d]{17}[xX\d]|[\d]{15})$/', $value)) return false;
                            if (!in_array(substr($value, 0, 2), $vCity)) return false;
                            $value = preg_replace('/[xX]$/i', 'a', $value);
                            $vLength = strlen($value);
                            if ($vLength == 18)
                            {
                                $vBirthday = substr($value, 6, 4) . '-' . substr($value, 10, 2) . '-' . substr($value, 12, 2);
                            } else {
                                $vBirthday = '19' . substr($value, 6, 2) . '-' . substr($value, 8, 2) . '-' . substr($value, 10, 2);
                            }
                            if (date('Y-m-d', strtotime($vBirthday)) != $vBirthday) return false;
                            if ($vLength == 18)
                            {
                                $vSum = 0;
                                for ($i = 17 ; $i >= 0 ; $i--)
                                {
                                    $vSubStr = substr($value, 17 - $i, 1);
                                    $vSum += (pow(2, $i) % 11) * (($vSubStr == 'a') ? 10 : intval($vSubStr , 11));
                                }
                                if($vSum % 11 != 1) return false;
                            }
                            return true;
                        case 'passport':
                            return preg_match("/^1[45][0-9]{7}|G[0-9]{8}|P[0-9]{7}|S[0-9]{7,8}|D[0-9]+$/i", $value);
                        case 'chinese':
                            return preg_match("/^[\x80-\xff]+$/i", $value);

                  } 
	return FALSE;
    }

    /**
    * 数字转金额（四舍五入）
    * @param number $num
    * @param int $round
    * @return double
    */
    public  static function numbertoprice($num,$round=2){
       return trim(sprintf("%10.2f",round((float)$num, $round)));
    }
    
    /**
    * 数字转万
    * @param number $num
    * @param int $round
    * @return double
    */
    public  static function numberforwan($num, $unit = '万'){
       if($num >= 10000){
            return sprintf("%.0f", $num/10000).$unit;
        }else{
            return $num;
        }
    }
    /**
     * 编号、ID号间转换 
     * @param number $num 编号或系统中的id
     * @param string $type (de解码，en换码）
     * @param string $code 类型代码
     * @return string
     */
    public static function num_change_id($num, $type='en', $code='product'){
        $num = self::find_num($num);
        $num = $type=='de' ? base_convert($num, 8, 16) : base_convert($num, 16, 8);
        if($type=='de'){
            switch ($code){
                case 'product':
                    $num = strval(sprintf("%013d", $num));
                    break;
                default:
                    $num = strval(sprintf("%013d", $num));
                    break;
            }
        }
        return $num;
    }

    /**
     * 提取数字
     * @param string $str
     * @return int
     */
    public static function find_num($str=''){
        $str=trim($str);
        if(empty($str)){return '';}
        $result='';
        for($i=0;$i<strlen($str);$i++){
            if(is_numeric($str[$i])){
                $result.=$str[$i];
            }
        }
        return $result;
    }

    /**
     * 生成sql使用的implode字符
     * @param array $array
     * @return string
     */
    public static function sqlimplode($array){
        return "'".implode("','", $array)."'";
    }

    /**
     * 分code类别获取prosyscode
     * @param array $code_array 获取的prosyscode数组
     * @param string $codetype 指定code类别
     * @return array
     */
    public static function get_prosyscode_column($code_array, $codetype=''){
        $result = array();
        foreach($code_array as $list){
            if(isset($list['code_type']) && ($codetype=='' || $list['code_type']==$codetype)){
                $result[$list['code_type']][] = $list;
            }
        }
        return $result;
    }

    /**
     * 获取数组中某一字段值集合
     * @param string $field
     * @param array $array
     * @return array
     */
    function get_field_value($field, $array)
    {
        if(empty($array)) return NULL;
        $return_array = array();
        foreach($array as $key => $val){
                if(isset($val[$field])){
                        $return_array[] = $val[$field];
                }
        }
        return $return_array;
    }

    /**
     * 合并存在相同key下标的数组
     * @param: @origin_arr array 源数组，@join_arr array 取值数组,@key string 
     * @return: array
    */
    public  static function array_merge_fromsamekey($origin_arr, $join_arr, $key)
    {
        if(!self::is_type($origin_arr, 'array') || !self::is_type($join_arr, 'array')){
            return $origin_arr;
        }
        foreach($origin_arr as &$origin_val){
            if(isset($origin_val[$key]) && isset($join_arr[$origin_val[$key]])){
                foreach($join_arr[$origin_val[$key]] as $join_key => $join_val){
                    $join_key <> $key && $origin_val[$join_key] = $join_val;
                }
            }
        }
        unset($origin_val);
        return $origin_arr;
    }

    /**
     * 返回数组中是否已定义所有的目标key列
     * @param array $array
     * @param object $keys 目标key列
     * @return boolean
     */
    public static function allisset($array,$keys){
        if(is_array($keys)){
            foreach ($keys as $key){
                if(!isset($array[$key]) || $array[$key] == '' || $array[$key] == NULL) return false;
            }
            return true;
        }
        return isset($array[$keys]);
    }

    /**
     * 根据是否存在的键值从二维数组中返回同组的另一键值对
     * @param array $array 源二维数组
     * @param type $exist_key 依据key
     * @param type $exist_val 依据值
     * @param type $find_key 目标key (空为所有)
     */
    public static function findColumnByExistval($array,$exist_key,$exist_val,$find_key=''){
        foreach($array as $list){
            if(is_array($list)){
                if(isset($list[$exist_key]) && $exist_val == $list[$exist_key]){
                    if($find_key==''){
                        return $list;
                    }
                    if(isset($list[$find_key])){
                        return $list[$find_key];
                    }
                }
            }
        }
        return '';
    }

    //反序列化
    public static function mb_unserialize($serial_str, $code='utf8') {
        if($code=='utf8'){
            $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', "'s:'.strlen('$2').':\"$2\";'", $serial_str );
            $serial_str = str_replace("\r", "", $serial_str);echo "<br />";echo $serial_str;
        }else if($code=='asc'){
            $serial_str = preg_replace('!s:(\d+):"(.*?)";!se', '"s:".strlen("$2").":\"$2\";"', $serial_str);
            $serial_str = str_replace("\r", "", $serial_str);
        }
        return unserialize($serial_str);
    }
    
    /** 
        * 字符截取 支持UTF8/GBK 
        * @param $string 
        * @param $length 
        * @param $dot 
        */  
       public static function cutstr($string, $length, $charset = 'utf-8', $dot = '...') {  
           $strlen = strlen($string);  
           if($strlen <= $length) return $string;  
           $string = str_replace(array(' ','&nbsp;', '&amp;', '&quot;', '&#039;', '&ldquo;', '&rdquo;', '&mdash;', '&lt;', '&gt;', '&middot;', '&hellip;'), array('∵',' ', '&', '"', "'", '“', '”', '—', '<', '>', '·', '…'), $string);  
           $strcut = '';  
           if(strtolower($charset) == 'utf-8') {  
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
    
    public static function utf8_cutstr($string, $len){
            if(utf8_strlen($string)<$len){
                    return $string;
            }
            return utf8_substr(strip_tags(html_entity_decode($string, ENT_QUOTES, 'UTF-8')), 0, $len) . '...';
    }

    /**
     * 生成订单号
     * @param int $count
     */
    public static function getorderno($count, $code=''){
        $count = $count > 1 ? $count : 0;
        $count ++;
        return $code.date('ymdH').$count.rand(10000,99999);
    }

    /**
     * 获取间隔时间
     * @param str $diffindex (+1,-1)
     * @param type $unit (D：day/M：month/Y：year/A:year);
     * @param int $unixtime 起始时间(default:today)
     * @return timestr
     */
    public static function getdiffouttime($diffindex, $unit='D', $unixtime=''){
        $unit_arr = array('D'=>'day', 'M'=>'month', 'Y'=>'year', 'A'=>'year');
        $unixtime == '' && $unixtime = strtotime(date('Y-m-d'));
        return strtotime($diffindex.' '.$unit_arr[$unit], $unixtime);
    }

    /**
     * 二维数组排序
     * @param array $arrays
     * @param string $sort_key
     * @param string $sort_order SORT_ASC/SORT_DESC
     * @param string $sort_type SORT_NUMERIC
     * @return array
     */
    public static function multisort(&$arrays, $sort_key, $sort_order=SORT_ASC, $sort_type=SORT_NUMERIC){
        if(is_array($arrays)){
            foreach ($arrays as $array){
                if(is_array($array)){
                    $key_arrays[] = $array[$sort_key];
                }else{
                    return false;
                }
            }
        }else{
            return false;
        }
        array_multisort($key_arrays,$sort_order,$sort_type,$arrays);
    }
    
      /**
        * 字符串半角和全角间相互转换
        * @param string $str  待转换的字符串
        * @param int    $type  TODBC:转换为半角；TOSBC，转换为全角
        * @return string  返回转换后的字符串
      */
     public static function convertStrType($str, $type='TOSBC') {

                $dbc = array( 
                    '０' , '１' , '２' , '３' , '４' ,  
                    '５' , '６' , '７' , '８' , '９' , 
                    'Ａ' , 'Ｂ' , 'Ｃ' , 'Ｄ' , 'Ｅ' ,  
                    'Ｆ' , 'Ｇ' , 'Ｈ' , 'Ｉ' , 'Ｊ' , 
                    'Ｋ' , 'Ｌ' , 'Ｍ' , 'Ｎ' , 'Ｏ' ,  
                    'Ｐ' , 'Ｑ' , 'Ｒ' , 'Ｓ' , 'Ｔ' , 
                    'Ｕ' , 'Ｖ' , 'Ｗ' , 'Ｘ' , 'Ｙ' ,  
                    'Ｚ' , 'ａ' , 'ｂ' , 'ｃ' , 'ｄ' , 
                    'ｅ' , 'ｆ' , 'ｇ' , 'ｈ' , 'ｉ' ,  
                    'ｊ' , 'ｋ' , 'ｌ' , 'ｍ' , 'ｎ' , 
                    'ｏ' , 'ｐ' , 'ｑ' , 'ｒ' , 'ｓ' ,  
                    'ｔ' , 'ｕ' , 'ｖ' , 'ｗ' , 'ｘ' , 
                    'ｙ' , 'ｚ' , '－' , '　'  , '：' ,
                    '．' , '，' , '／' , '％' , '＃' ,
                    '！' , '＠' , '＆' , '（' , '）' ,
                    '＜' , '＞' , '＂' , '＇' , '？' ,
                    '［' , '］' , '｛' , '｝' , '＼' ,
                    '｜' , '＋' , '＝' , '＿' , '＾' ,
                    '￥' , '￣' , '｀'
                );

                $sbc = array( //半角
                            '0', '1', '2', '3', '4',  
                            '5', '6', '7', '8', '9', 
                            'A', 'B', 'C', 'D', 'E',  
                            'F', 'G', 'H', 'I', 'J', 
                            'K', 'L', 'M', 'N', 'O',  
                            'P', 'Q', 'R', 'S', 'T', 
                            'U', 'V', 'W', 'X', 'Y',  
                            'Z', 'a', 'b', 'c', 'd', 
                            'e', 'f', 'g', 'h', 'i',  
                            'j', 'k', 'l', 'm', 'n', 
                            'o', 'p', 'q', 'r', 's',  
                            't', 'u', 'v', 'w', 'x', 
                            'y', 'z', '-', ' ', ':',
                            '.', ',', '/', '%', ' #',
                            '!', '@', '&', '(', ')',
                            '<', '>', '"', '\'','?',
                            '[', ']', '{', '}', '\\',
                            '|', '+', '=', '_', '^',
                            '￥','~', '`'
                );
                if($type == 'TODBC'){
                        return str_replace( $sbc, $dbc, $str );  //半角到全角
                }elseif($type == 'TOSBC'){
                        return str_replace( $dbc, $sbc, $str );  //全角到半角
                }else{
                        return $str;
                }
     }

    /**
    *
    +--------------------------------------------------------------------
    * Description 递归创建目录
    +--------------------------------------------------------------------
    * @param  string $dir 需要创新的目录
    +--------------------------------------------------------------------
    * @return 若目录存在,或创建成功则返回为TRUE
    +--------------------------------------------------------------------
    */
    public static function mkdirs($dir, $mode = 0777){
        if (is_dir($dir) || mkdir($dir)){
            chmod($dir, $mode);
            return TRUE;
        }
        if (!self::mkdirs(dirname($dir), $mode)){
            return FALSE;
        }
        return mkdir($dir, $mode); 
    }

    /**
     * Unix时间戳转日期(处理32bit系统大于2038年的时间戳)
     * @param int $unixtime
     * @param string $format 输出格式(default="Y-m-d H:i:s")
     * @param string $timezone
     * @return int
     */
    public static function unixtime_to_date($unixtime, $format="Y-m-d H:i:s", $timezone = 'PRC') {
        $datetime = new DateTime("@$unixtime"); //DateTime类的bug，加入@可以将Unix时间戳作为参数传入
        $datetime->setTimezone(new DateTimeZone($timezone));
        return $datetime->format($format);
    }

    /**
     * 日期转Unix时间戳(处理32bit系统大于2038年的时间戳)
     * @param string $date
     * @param string $format 输出格式(default="U")
     * @param type $timezone
     * @return unixtime
     */
    public static function date_to_unixtime($date, $format="U", $timezone = 'PRC') {
        $datetime= new DateTime($date, new DateTimeZone($timezone));
        return $datetime->format($format);
    }
    
      /**
     * 获取客户端IP地址
     * @param integer $type 返回类型 0 返回IP地址 1 返回IPV4地址数字
     * @param boolean $adv 是否进行高级模式获取（有可能被伪装） 
     * @return mixed
     */
    public static function get_client_ip($type = 0,$adv=false) {
                $type       =  $type ? 1 : 0;
                static $ip  =   NULL;
                if ($ip !== NULL) return $ip[$type];
                if($adv){
                    if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
                        $arr    =   explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);
                        $pos    =   array_search('unknown',$arr);
                        if(false !== $pos) unset($arr[$pos]);
                        $ip     =   trim($arr[0]);
                    }elseif (isset($_SERVER['HTTP_CLIENT_IP'])) {
                        $ip     =   $_SERVER['HTTP_CLIENT_IP'];
                    }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                        $ip     =   $_SERVER['REMOTE_ADDR'];
                    }
                }elseif (isset($_SERVER['REMOTE_ADDR'])) {
                    $ip     =   $_SERVER['REMOTE_ADDR'];
                }
                // IP地址合法验证
                $long = sprintf("%u",ip2long($ip));
                $ip   = $long ? array($ip, $long) : array('0.0.0.0', 0);
                return $ip[$type];
    }

    /**
     * 模拟POST
     * @param string $url
     * @param void $postFields
     * @return void
     * @throws Exception
     */
    public static function http_reponse($url, $postFields = null) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (compatible; MSIE 5.01; Windows NT 5.1)');
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_FAILONERROR, 0);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

        //curl_setopt($ch,CURLOPT_HTTPHEADER,array("Expect:"));
        $postMultipart = false;
        $postBodyString = '';
        $post_data = null;
        if (is_array($postFields) && 0 < count($postFields)) {
            foreach ($postFields as $k => $v) {
                if ("@" != substr($v, 0, 1)) {//判断是不是文件上传
                    $postBodyString .= "$k=" . urlencode($v) . "&";
                } else {//文件上传用multipart/form-data，否则用www-form-urlencoded
                    $postMultipart = true;
                }
            }
            unset($k, $v);
            $post_data = substr($postBodyString, 0, -1);
        }else{
            $post_data = $postFields;
        }
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if ($postMultipart) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
        } else {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $post_data);
        }
        $reponse = curl_exec($ch);
        if (curl_errno($ch)) {
            throw new Exception(curl_error($ch), 0);
        } else {
            $httpStatusCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if (200 !== $httpStatusCode) {
                throw new Exception($reponse, $httpStatusCode);
            }
        }
        curl_close($ch);
        return $reponse;
    }

    /**
     * 返回ajax数据处理
     * @param string $errcode
     * @param void $resultdata
     * @param string $code (401)
     * @return array ('status' => 'OK', 'data' => object ) || array ('status' => 'ERR', 'msg' => 'errmsg' )
     */
    public static function setAjaxData($errcode, $resultdata = NULL, $code = ''){
        $return_data = array();
        if($errcode == 'ERR'){
            $return_data['status'] = 'ERR';
            $return_data['msg'] = $resultdata == '' ? '系统正忙......' : $resultdata;
        }else{
            $return_data['status'] = $errcode;
            !empty($resultdata) && $return_data['data'] = $resultdata;
        }
        $code <> '' && $return_data['code'] = $code;
        return $return_data;
    }
    
    /**
     * 输出json格式数据
     * @param void $data
     * return object
     */
    public static function json_out($data){
            ob_end_clean();
            header('Content-type: application/json');
            echo is_object($data) ? $data :  json_encode($data);
    }

}
