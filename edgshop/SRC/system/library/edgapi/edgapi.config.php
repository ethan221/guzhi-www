<?php
namespace Edgapi;
/**
* EDG api 接口对接配置信息
*/
class EdgapiConfig
{    
        /**
         * 注册API
         */
        const REGISTER_API = 'http://120.24.78.166:8088/guzhi_edg/v1/php/user/register.do';
        /**
         * 登录api
         */
        const LOGIN_API = 'http://120.24.78.166:8088/guzhi_edg/v1/php/user/login.do';
        /**
         * 登录api
         */
        const SNSLOGIN_API = 'http://120.24.78.166:8088/guzhi_edg/v1/php/user/checkBound.do';
        
        /**
         * 帐号验证api
         */
        const CHKPHONE_API = 'http://120.24.78.166:8088/guzhi_edg/v1/php/user/checkPhone.do';
        
         /**
         * 短信修改密码api
         */
        const UPDATEPWDBYSMS_API = 'http://120.24.78.166:8088/guzhi_edg/v1/php/user/password.do';

        /**
         * 修改密码api
         */
        const UPDATEPWDBYOLDPWD_API = 'http://120.24.78.166:8088/guzhi_edg/v1/php/user/rep/password.do';
}
?>