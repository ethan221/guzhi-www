<?php
require_once(DIR_SYSTEM.'laravel/load.php');
use App\Service\AccountService;

class ControllerAccountPassword extends EdgController {

	private $error = array();

	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/password', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}
                
                                    if($this->customer->getType()){
                                                $this->response->redirect($this->url->link('account'));
                                    }

		$this->load->language('account/password');

		$this->document->setTitle($this->language->get('heading_title'));

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_password'] = $this->language->get('text_password');

                                    $this->document->addStyle(THEME_PATH.'css/address.css');
                                    $this->document->addStyle(THEME_PATH.'css/city.css'); 
                                    $this->document->addStyle(THEME_PATH.'css/modify.css');
                                    $this->document->addScript(THEME_PATH.'js/jquery/jquery.validate.min.js');
		if (isset($this->error['password'])) {
			$data['error_password'] = $this->error['password'];
		} else {
			$data['error_password'] = '';
		}

		if (isset($this->error['confirm'])) {
			$data['error_confirm'] = $this->error['confirm'];
		} else {
			$data['error_confirm'] = '';
		}

		$data['action'] = $this->url->link('account/password', '', true);

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

		if (isset($this->request->post['confirm'])) {
			$data['confirm'] = $this->request->post['confirm'];
		} else {
			$data['confirm'] = '';
		}

		$data['back'] = $this->url->link('account/account', '', true);

		$data['account_left'] = $this->load->controller('common/account_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/password', $data));
	}
        
        
                public function modify(){
                            $json = array();
                            if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
                                    $service = new AccountService($this, $this->request->post);
                                    $result = $service->modifypwd();
                                    if($result->code=='0'){//登录成功
                                                $json['success'] = '密码修改成功';
                                    }else if(isset($result->msg)){
                                                $this->error['password'] = $result->msg;
                                    }
                            }
                            if(!empty($this->error['password'])){
                                    $json['error'] = $this->error['password'];
                            }
                            $this->response->addHeader('Content-Type: application/json');
                            $this->response->setOutput(json_encode($json));
                }

	protected function validate() {
		if ((utf8_strlen($this->request->post['password_old']) < 6) || (utf8_strlen($this->request->post['password_old']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}
                
                                     if ((utf8_strlen($this->request->post['password']) < 6) || (utf8_strlen($this->request->post['password']) > 20)) {
			$this->error['password'] = $this->language->get('error_password');
		}

		return !$this->error;
	}
}