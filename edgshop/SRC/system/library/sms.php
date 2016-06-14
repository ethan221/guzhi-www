<?php
/**
 * 发送短信接口
 */
use Cache\Red;

class Sms {
        private $sn   = 'SDK-SKY-010-02624';
        private $pwd = '988130';
        private $host = 'http://sdk.entinfo.cn:8060/z_mdsmssend.aspx';
        private $edg_api = 'http://120.24.173.74/index.php?route=api/sms/send';
   
        public function getrandchar($len) {
                $chars = array( "0", "1", "2", "3", "4", "5", "6", "7", "8", "9" ); 
                $charslen = count($chars) - 1; 
                shuffle($chars);   
                $output = ""; 
                for ($i=0; $i<$len; $i++) 
                { 
                         $output .= $chars[mt_rand(0, $charslen)];
                }  
                return $output;
        }
	
        /**
         * 缓存短信
         * @param string $cache_key
         * @param string code
         *  @param int $cache_time
         */
        public function save_code($cache_key, $code,  $cache_time = 300) {
                $cache = new Red($cache_time); //默认5分钟内有效
                return $cache->set($cache_key, $code);
        }

        /**
         * 跨域发送
         * @param type $mobile
         * @param type $content
         */
        public function cross_send($mobile,  $content){
                $post_data['mobile'] = $mobile;
                $post_data['content'] = $content;
                $result = $this->sms_post($this->edg_api, $post_data);
                echo $result;
        }

        public function send($mobile,  $content = ''){
                $mobile_list = array();
                $json = array();
                if(is_array($mobile)){
                        $mobile_list = $mobile;
                }else{
                        $mobile_list[] = $mobile;
                }
                foreach($mobile_list as $mob){
                        if (preg_match("/^1[0-9]{10}$/i", str_replace(' ','',$mob))) {
                                $content == '' && $content = $this->getrandchar(6);
                                $content = iconv("UTF-8", "GBK", $content);
                                $post_data = array();
                                $post_data['sn']   = $this->sn;
                                $post_data['pwd'] = strtoupper( MD5($this->sn.$this->pwd));
                                $post_data['mobile']  = $mob;
                                $post_data['content'] = $content;
                                //$post_data['sendTime'] = '';
                                //$post_data['ext'] = '';
                                $result = $this->sms_post($this->host, $post_data);
                                if($result>0){//发送成功
                                        $json["$mob"] = $result;
                                }
                        }
                }
                header('Content-type: application/json');
                echo json_encode($json);
        }

        /**
         * 验证码验证
         * @param string $cache_key
         * @param string $code
         * @return bool
         */
        public function verify_code($cache_key, $code, $cache_time = 0){
                if($code!=''){
                        $cache = new Red($cache_time);
                        $cache_code = $cache->get($cache_key);
                        return $cache_code<>'' && $code==$cache_code;
                }
        }
        
        /** 
        * 模拟提交参数，支持https提交 可用于各类api请求
        * @param string $url ： 提交的地址 
        * @param array $data :POST数组 
        * @param string $method : POST/GET，默认GET方式 
        * @return mixed 
        */  
       function http($url, $data='', $method='GET'){   
           $curl = curl_init(); // 启动一个CURL会话  
           curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址  
           curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查  
           curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
           curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转  
           curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer  
           if($method=='POST'){  
               curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求  
               if ($data != ''){  
                   curl_setopt($curl, CURLOPT_POSTFIELDS, $data); // Post提交的数据包  
               }  
           }  
           curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环  
           curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
           curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
           $return_str = curl_exec($curl); // 执行操作  
           curl_close($curl); // 关闭CURL会话  
           return $return_str; // 返回数据
       }

        public function sms_post($url, $params){
                // init curl object
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $url);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
                // prepare post array if available
                $params_string = '';
                if (is_array($params) && count($params)) {
                    foreach ($params as $key => $value) {
                        $params_string .= $key . '=' . $value . '&';
                    }
                    rtrim($params_string, '&');
                    curl_setopt($ch, CURLOPT_POST, count($params));
                    curl_setopt($ch, CURLOPT_POSTFIELDS, $params_string);
                }

                // execute request
                $result = curl_exec($ch);

                // close connection
                curl_close($ch);

                return $result;
        }

        public function xml_to_array($xml){
                $arr = array();
                $reg = "/<(\w+)[^>]*>([\\x00-\\xFF]*)<\\/\\1>/";
                if(preg_match_all($reg, $xml, $matches)){
                        $count = count($matches[0]);
                        for($i = 0; $i < $count; $i++){
                        $subxml= $matches[2][$i];
                        $key = $matches[1][$i];
                                if(preg_match( $reg, $subxml )){
                                        $arr[$key] = $this->xml_to_array( $subxml );
                                }else{
                                        $arr[$key] = $subxml;
                                }
                        }
                }
                return $arr;
        }
}