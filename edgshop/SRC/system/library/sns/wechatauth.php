<?php
namespace Sns;

class WechatConfig
{
        const APPID = 'wxba35e5be5656f4a3';
        const APPSECRET = '033c1fa665a87a0eb8f2c885ba47d6e0';
        const REDIRECT_URL = HTTP_SERVER.'account/login/snscallback?type=weixin';
        const QRREDIRECT_URL = HTTP_SERVER.'account/login/snscallback?type=weixin';
        const USERINFO_URL = 'https://api.weixin.qq.com/sns/userinfo';
}

class Wechatauth
{
        private $redirect_uri;

        private $QRredirect_uri;

        private $openid;

        private $access_token;

        function __construct() {
                $this->redirect_uri = urlencode(WechatConfig::REDIRECT_URL);
                $this->QRredirect_uri = urlencode(WechatConfig::QRREDIRECT_URL);
        }

        /**
        * 
        * 构造获取code的url连接
        * @param string $redirectUrl 微信服务器回跳的url，需要url编码
        * 
        * @return 返回构造好的url
        */
       public function __CreateOauthUrlForCode()
       {
               $urlObj["appid"] = WechatConfig::APPID;
               $urlObj["redirect_uri"] = $this->redirect_uri;
               $urlObj["response_type"] = "code";
               $urlObj["scope"] = "snsapi_base";
               $urlObj["state"] = "STATE"."#wechat_redirect";
               $bizString = $this->ToUrlParams($urlObj);
               //echo "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
               //exit;
               return "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
       }
       
        /**
        * 
        * 构造pc二维码登录获取code的url连接
        * @param string $redirectUrl 微信服务器回跳的url，需要url编码
        * 
        * @return 返回构造好的url
        */
       public function __CreateQROauthForCode()
       {
               $urlObj["appid"] = WechatConfig::APPID;
               $urlObj["redirect_uri"] = $this->QRredirect_uri;
               $urlObj["response_type"] = "code";
               $urlObj["scope"] = "snsapi_login";
               $urlObj["state"] = "STATE"."#wechat_redirect";
               $bizString = $this->ToUrlParams($urlObj);
               //echo "https://open.weixin.qq.com/connect/oauth2/authorize?".$bizString;
               //exit;
               return "https://open.weixin.qq.com/connect/qrconnect?".$bizString;
               //https://open.weixin.qq.com/connect/qrconnect?appid=wxbdc5610cc59c1631&redirect_uri=https%3A%2F%2Fpassport.yhd.com%2Fwechat%2Fcallback.do&response_type=code&scope=snsapi_login&state=3d6be0a4035d839573b04816624a415e#wechat_redirect
       }

        /**
         * 
         * 构造获取openid和access_toke的url地址
         * @param string $code，微信跳转带回的code
         * 
         * @return 请求的url
         */
        private function __CreateOauthUrlForOpenid($code)
        {
                $urlObj["appid"] = WechatConfig::APPID;
                $urlObj["secret"] = WechatConfig::APPSECRET;
                $urlObj["code"] = $code;
                $urlObj["grant_type"] = "authorization_code";
                $bizString = $this->ToUrlParams($urlObj);
                return "https://api.weixin.qq.com/sns/oauth2/access_token?".$bizString;
        }
        
        
        /**
        * 
        * 通过code从工作平台获取 openid&access_token
        * @param string $code 微信跳转回来带上的code
        * 
        * @return openid
        */
       public function GeAuthInfoFromMp($code)
       {

               $url = $this->__CreateOauthUrlForOpenid($code);
               //初始化curl
               $ch = curl_init();
               //设置超时
               curl_setopt($ch, CURLOPT_TIMEOUT, 30);
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
               curl_setopt($ch, CURLOPT_HEADER, FALSE);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

               //运行curl，结果以jason形式返回
               $res = curl_exec($ch);
               curl_close($ch);
               //取出openid
               $data = json_decode($res,true);
               $this->data = $data;
               if(!$data['errcode']){
                        return $data;
               }
       }
       
       public function getUserInfo($openid, $access_token){
               $urlObj = array(
                        'openid' => $openid,
                        'access_token' => $access_token
               );
               $bizString = $this->ToUrlParams($urlObj);
               
               $url = "https://api.weixin.qq.com/sns/userinfo?".$bizString;
               //初始化curl
               $ch = curl_init();
               //设置超时
               curl_setopt($ch, CURLOPT_TIMEOUT, 30);
               curl_setopt($ch, CURLOPT_URL, $url);
               curl_setopt($ch, CURLOPT_SSL_VERIFYPEER,FALSE);
               curl_setopt($ch, CURLOPT_SSL_VERIFYHOST,FALSE);
               curl_setopt($ch, CURLOPT_HEADER, FALSE);
               curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);

               //运行curl，结果以jason形式返回
               $res = curl_exec($ch);
               curl_close($ch);
               //取出userinfo
               $data = json_decode($res, true);
               if(!$data['errcode']){
                        return $data;
               }
       } 


       /**
          * 
          * 拼接签名字符串
          * @param array $urlObj
          * 
          * @return 返回已经拼接好的字符串
          */
         private function ToUrlParams($urlObj)
         {
                 $buff = "";
                 foreach ($urlObj as $k => $v)
                 {
                         if($k != "sign"){
                                 $buff .= $k . "=" . $v . "&";
                         }
                 }

                 $buff = trim($buff, "&");
                 return $buff;
         }
	
        
}

