<?php
/**
 * 发送短信
 */
class ControllerSmsSend extends EdgController {

        protected $error;

        public function index(){
                $json = array();
                $type = $this->request->post['type'];//短信类型
                $mobile  = trim($this->request->post['mobile']); //手机
                if(!in_array($type, array('user_register', 'user_findpwd')) || !Utils::validate($mobile, 'mobile')){
                        $this->error = '短信发送失败[1001]';
                }else if(0<$this->request->cookie['captcha_'.$type]){
                        $this->error = '另一条短信正在发送中，请稍候再发';
                }
                if(!$this->error){
                        $this->load->library('sms');
                        $sms = new Sms();
                        $sms_code = $sms->getrandchar(6);
                        switch ($type){
                                case 'user_register':
                                        $content = "【EDG商城】注册验证码为：{$sms_code}，5分钟内有效。";
                                        break;
                                default:
                                        $content = "【EDG商城】验证码为：{$sms_code}，5分钟内有效。";
                                        break;
                        }
                        if($_SERVER['SERVER_ADDR']=='120.24.173.74'){
                                $rs = $sms->send($mobile, $content);
                        }else{
                                if(isset($this->request->cookie['captcha'])){
                                        $rs = $sms->cross_send($mobile, $content);
                                        $this->request->cookie['captcha'] = NULL;
                                }else{
                                        
                                }
                        }
                        $rs = ob_get_clean();
                        //$rs = '{"13427548928":"121415223112805453"}';
                        $rs = json_decode($rs);
                       // if(!empty($rs) && 0 < $rs->$mobile){
                                $sms_key = $type.'_'.$mobile; //要缓存的key
                                if($sms->save_code($sms_key, $sms_code)){
                                        $json = array(
                                            'status'=>'ok',
                                            'test'=>$sms_code
                                                );
                                }
                       // }else{
                                //$this->error = '短信发送失败[1002]';
                       // }
                 }
                
                 if($this->error){
                        $json = array('status'=>'err', 'data'=>$this->error);
                 }
                 $this->response->setOutput(json_encode($json));
        }

}