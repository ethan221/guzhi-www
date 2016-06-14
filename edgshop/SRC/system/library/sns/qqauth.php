<?php
namespace Sns;
require_once(dirname(__FILE__)."/qq/qqConnectAPI.php");

class QQauth
{
        private $qcapi;
        
        function __construct($access_token='', $open_id='') {
                $this->qcapi = new QC($access_token, $open_id);
        }

        function login(){
                $this->qcapi->qq_login();
        }

        function qq_callback(){
                $this->qcapi->qq_callback();
        }
        
        function get_openid(){
                $this->qcapi->get_openid();
        }
        
        function get_userinfo(){
                $this->qcapi->qq_callback();
                return $this->qcapi->get_userinfo();
        }
}