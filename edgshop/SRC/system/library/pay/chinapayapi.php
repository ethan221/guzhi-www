<?php
namespace Pay;
//include_once("chinapay/netpayclient_config.php");
//include_once("chinapay/netpayclient.php");
include_once 'chinapay/SecssUtil.class.php';

class ChinapayApi{

//        public function getReqUrlPay(){
//                return REQ_URL_PAY;
//        }
//
//        public function getMerId(){
//                	//导入私钥文件, 返回值即为您的商户号，长度15位
//	return   buildKey(PRI_KEY);
//        }
//
//        public function sign($string){
//                return sign($string);
//        }
//        
//        public function padstr($num, $len=12){
//                return padstr($num, $len);
//        }

        protected $securityPropFile= "chinapay/security.properties";

        private $secssUtil;

        private $merId = '531111605230009';

        //private $payurl = 'http://newpayment-test.chinapay.com/CTITS/service/rest/page/nref/000000000017/0/0/0/0/0';
        private $payurl = 'https://payment.chinapay.com/CTITS/service/rest/page/nref/000000000017/0/0/0/0/0';
        public function __construct() {
                $this->secssUtil = new SecssUtil();
                $this->secssUtil->init(dirname(__FILE__).'/'.$this->securityPropFile); //初始化安全控件：
        }

        public function sign($paramArray){
                $this->secssUtil->sign($paramArray);
                if("00"!==$this->secssUtil->getErrCode()){
                        echo "签名过程发生错误，错误信息为-->".$this->secssUtil->getErrMsg();
                        return;
                }
        }

        public function verify($paramArray){
                $this->secssUtil->verify($paramArray);
                if("00"==$this->secssUtil->getErrCode()){
                        return TRUE;
                }else{
                        echo "验签过程发生错误，错误信息为-->".$this->secssUtil->getErrMsg();
                        return;
                }
        }

        public function getSign(){
                return $this->secssUtil->getSign();
        }

        public function getMerId(){
                return $this->merId;
        }

        public function getPayUrl(){
                return $this->payurl;
        }
}
?>