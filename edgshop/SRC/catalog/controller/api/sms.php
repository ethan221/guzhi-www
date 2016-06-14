<?php

class ControllerApiSms extends EdgController {

        /**
         * 远程调用发送短信接口
         */
        public function send(){
                $content = @$this->request->post['content'];
                $mobile  = @$this->request->post['mobile']; //手机
                $this->load->library('sms');
                $sms = new Sms();
                //帐号验证信息……
                if(!empty($content) && Utils::validate($mobile, 'mobile')){
                        $sms->send($mobile, $content);
                }else{
                        //$sms->send('13427548928', '{test}.....');
                }
        }
}