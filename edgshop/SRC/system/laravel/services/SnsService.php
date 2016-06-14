<?php 
namespace App\Service;
use Sns\WeiboAuth;
use Sns\QQauth;
use Sns\Wechatauth;

class SnsService
{
        protected $opencart;

        protected $params;

        public $errors;

        public function __construct($opencart, $params)
        {
                            $this->opencart = $opencart;
                            $this->params = $params;
                            $this->opencart->load->helper('utils');
        }

        /**
         * sns-oauth验证
         */
        public function snsAuth(){
                $type = $this->params['type'];
                if($type == 'weibo'){
                        $o = new WeiboAuth();
                        $code_url = $o->getAuthorizeURL();
                        $this->opencart->response->redirect($code_url);
                }else if($type=='qq'){
                        $oauth = new QQauth();
                        $oauth->login();
                }else if($type=='weixin'){
                        $wechatauth = new Wechatauth();
                        $redirect_url = $wechatauth->__CreateQROauthForCode();
                        $this->opencart->response->redirect($redirect_url);
                }
        }
        
        /**
         * 获取微博用户openid
         * @return type
         */
        public function getWeiboUserId(){
                if(isset($this->params['code'])){
                        $this->opencart->load->library('sns/weiboauth');
                        $o = new WeiboAuth();
                        $keys = array();
                        $keys['code'] = $this->params['code'];
                        try {
                                $token = $o->getAccessToken( 'code',  $keys ) ;
                                if($token != '' && $o->openid != ''){
                                        return $o->openid;
                                }
                        } catch (OAuthException $e) {
                        }

                }
        }
        
         /**
         * 获取微博用户info
         * @return type
         */
        public function getWeiboUserInfo(){
                if(isset($this->params['code'])){
                        $this->opencart->load->library('sns/weiboauth');
                        $o = new WeiboAuth();
                        $keys = array();
                        $keys['code'] = $this->params['code'];
                        try {
                                $token = $o->getAccessToken( 'code',  $keys ) ;
                                if($token != '' && $o->openid != ''){
                                        return $o->getUserInfo();
                                }
                        } catch (OAuthException $e) {
                        }

                }
        }
        
        /**
         * 获取qq用户info
         * @return type
         */
        public function getQQUserInfo(){
                $oauth = new QQauth();
                return $oauth->get_userinfo();
        }

        /**
         * 获取微信用户info
         * @return type
         */
        public function getWechatUserInfo(){
                $code = $this->params['code'];
                if($code!=''){
                        $oauth = new Wechatauth();
                        $oauth_result = $oauth->GeAuthInfoFromMp($code);
                        if($oauth_result){
                                return $oauth->getUserInfo($oauth_result['openid'], $oauth_result['access_token']);
                        }
                }
        }

}