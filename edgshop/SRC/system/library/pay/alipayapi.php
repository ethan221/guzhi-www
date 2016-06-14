<?php
namespace Pay;
/**
 * alipay api
 * @wql 2016-05-15
 */
require_once 'alipay/alipay.config.php';
require_once 'alipay/lib/alipay_submit.class.php';
require_once 'alipay/lib/alipay_notify.class.php';

class AlipayApi
{
        public function getAlipayConfig(){
                return \alipay_config::getConfig();
        }

        /**
         * 调起支付
         * @param array $parameter
         * @return type
         */
        public function getSubmitHtml($parameter){
                        $alipay_config = \alipay_config::getConfig();
                        $alipaySubmit = new \AlipaySubmit($alipay_config);
                        $parameter['anti_phishing_key'] = $alipaySubmit->query_timestamp();
                        return $alipaySubmit->buildRequestForm($parameter, "get", "确认");
        }

        /**
         * 回调验证
         * @return type
         */
        public function verifyNotify(){
                $alipay_config = \alipay_config::getConfig();
                $alipayNotify = new \AlipayNotify($alipay_config);
                return $alipayNotify->verifyNotify();
        }

        /**
         * 即时返回
         * @return type
         */
        public function verifyReturn(){
                $alipay_config = \alipay_config::getConfig();
                $alipayNotify = new \AlipayNotify($alipay_config);
                return $alipayNotify->verifyReturn();
        }
}

