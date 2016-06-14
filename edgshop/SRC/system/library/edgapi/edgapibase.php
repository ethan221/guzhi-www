<?php
namespace Edgapi;

class EdgapiBase
{
        public function __construct() {
               
        }

        /**
         * 调用接口
         * @param string $apiurl
         * @param array $post_data
         * @param string $method
         */
        public function request($apiurl, $post_data, $method='GET'){
                  $database = new EdgDataBase();
                  $database->SetData($post_data);
                  $post_data['sign'] = $database->SetSign();
                  try{
                        $result = $this->http($apiurl, $post_data, $method);
                  } catch (\Exception $ex) {
                          $this->log('>>调用api:'.$apiurl." \n ".$ex->getMessage());
                  }
                 if(!empty($result)){
                        return  json_decode($result);
                 }else{
                         $result = new \stdClass();
                         $result->code = '-1';
                         $result->msg = '服务器繁忙[-1]';
                        return  $result;
                 }
        }

        public function http($url, $data='', $method='GET'){   
                $curl = curl_init(); // 启动一个CURL会话  
                curl_setopt($curl, CURLOPT_URL, $url); // 要访问的地址  
                curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false); // 对认证证书来源的检查  
                curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false); // 从证书中检查SSL加密算法是否存在
                curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1); // 使用自动跳转  
                curl_setopt($curl, CURLOPT_AUTOREFERER, 1); // 自动设置Referer  
                if($method=='POST'){  
                        curl_setopt($curl, CURLOPT_POST, 1); // 发送一个常规的Post请求  
                        if ($data != ''){  
                                // prepare post array if available
                                $params_string = '';
                                if (is_array($data) && count($data)) {
                                        foreach ($data as $key => $value) {
                                                $params_string .= $key . '=' . $value . '&';
                                         }
                                        rtrim($params_string, '&');
                                        curl_setopt($curl, CURLOPT_POST, count($data));
                                        curl_setopt($curl, CURLOPT_POSTFIELDS, $params_string);
                                } 
                        }  
                }
                curl_setopt($curl, CURLOPT_TIMEOUT, 30); // 设置超时限制防止死循环  
                curl_setopt($curl, CURLOPT_HEADER, 0); // 显示返回的Header区域内容  
                curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1); // 获取的信息以文件流的形式返回  
                $return_str = curl_exec($curl); // 执行操作  
                curl_close($curl); // 关闭CURL会话  
                return $return_str; // 返回数据
          }

          protected function log($word='') {
	$fp = fopen("log.txt","a");
	flock($fp, LOCK_EX) ;
	fwrite($fp,"执行日期：".strftime("%Y%m%d%H%M%S",time())."\n".$word."\n");
	flock($fp, LOCK_UN);
	fclose($fp);
        }

}