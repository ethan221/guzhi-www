<?php
namespace Edgapi;

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
require_once 'edgapi.config.php';
require_once 'edgapibase.php';

class Account extends EdgapiBase{

        public function __construct() {
                
        }
        
        /**
         *   注册新用户
         * @param type $phone
         * @param type $codekey
         * @param type $smscode
         * @param type $pwd
         * @return type
         */
        public function create($phone, $codekey, $smscode, $pwd){
                if($phone<>'' && $codekey<>'' && $smscode<>'' &&  $pwd<>''){
                        $post_data = array(
                            'phone' => $phone,
                            'codeKey'   => $codekey,
                            'verifyCode' => $smscode,
                            'pwd' => MD5($pwd)
                        );
                        return parent::request(EdgapiConfig::REGISTER_API, $post_data, 'POST');
                }else{
                        return json_encode(array('code'=>'-1', 'msg'=>'请求参数错误'));
                }
        }
        
        /**
         * 用户名密码登录
         * @param string $phone
         * @param string $pwd
         * @return object
         */
        public function login($phone, $pwd){
                if($phone<>'' && $pwd<>''){
                        $post_data = array(
                            'username' => $phone,
                            'pwd' => MD5($pwd)
                        );
                        return parent::request(EdgapiConfig::LOGIN_API, $post_data, 'POST');
                }else{
                        return json_encode(array('code'=>'-1', 'msg'=>'请求参数错误'));
                }
        }

        /**
         * sns用户登录
         * @param string $type
         * @param string $openid
         * @return object
         */
        public function snslogin($type, $openid){
                if($type<>'' && $openid<>''){
                        $types = array( 'qq' => 0, 'weixin' => 1, 'weibo' => 2);
                        $post_data = array(
                            'types' => $types[$type],
                            'openId' => $openid
                        );
                        return parent::request(EdgapiConfig::SNSLOGIN_API, $post_data, 'POST');
                }else{
                        return json_encode(array('code'=>'-1', 'msg'=>'请求参数错误'));
                }
        }

        /**
         * 注册帐号是否已被占用验证
         * @param string $phone
         */
        public function accountchk($phone){
                return parent::request(EdgapiConfig::CHKPHONE_API, array('phone'=>$phone), 'POST');
        }

        /**
         * 短信修改密码
         * @param string $phone
         * @param string $smscode
         * @param string $smscode_cachekey
         * @param string $newpwd
         */
        public function setpwdbysms($phone, $smscode, $smscode_cachekey, $newpwd){
                return parent::request(EdgapiConfig::UPDATEPWDBYSMS_API, array('phone'=>$phone, 'codeKey'=>$smscode_cachekey, 'verifyCode'=>$smscode, 'password'=>$newpwd), 'POST');
        }

         /**
         * 修改密码
         * @param string $userid
         * @param string $newpwd
         * @param string $oldpwd
         */
        public function modifypwdbyoldpwd($userid, $newpwd,  $oldpwd){
                return parent::request(EdgapiConfig::UPDATEPWDBYOLDPWD_API, array('userId'=>$userid, 'newPassword'=>$newpwd, 'password'=>$oldpwd), 'POST');
        }
}