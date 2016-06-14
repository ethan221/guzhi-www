<?php
abstract class Controller {
        protected $registry;

        public function __construct($registry) {
                $this->registry = $registry;
        }

        public function __get($key) {
                return $this->registry->get($key);
        }

        public function __set($key, $value) {
                $this->registry->set($key, $value);
        }
}

class EdgController extends Controller {
        public function __construct() {
                global $registry;
                parent::__construct($registry);
                if(!class_exists('Utils')){
                        $this->load->helper('utils');
                }
        }

        public function logincheck($isajax = false){
                if (!$this->customer->isLogged()){
                        $redirect =  @$this->request->server['HTTP_REFERER'];
                        if($redirect!='' && $this->getRouter()!='account'){
                                preg_match("/^(http:\/\/)?([^\/]+)/i", $redirect, $matches);
                                preg_match("/^(http:\/\/)?([^\/]+)/i", $this->request->server['HTTP_HOST'], $matches_curr);
                                $matches_curr[2] == $matches[2] && $this->session->data['redirect'] = $redirect;
                        }
                        if($isajax){
                                $json = array('code'=>'401', 'error' => '请先登录', 'redirect' => $this->url->link('account/login', '', true));
                                $this->response->addHeader('Content-Type: application/json');
                                $this->response->setOutput(json_encode($json));
                        }else{
                                $this->response->redirect($this->url->link('account/login', '', true));
                        }
                }
        }

        public function getRouter(){
                $route =@(string)$this->request->get['route'];
                // 2016/04/19
                if(strpos($route,'/')===FALSE){
                        $route .= '/'.$route;
                }
                return $route;
        }
}