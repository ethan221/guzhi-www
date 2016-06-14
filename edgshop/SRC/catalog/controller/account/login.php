<?php
require_once(DIR_SYSTEM.'laravel/load.php');

use App\Service\AccountService;
use App\Service\SnsService;
use Cache\Red;

class ControllerAccountLogin extends EdgController {
	private $error = array();

	public function index() {
                         if ($this->customer->isLogged()){
                                 $this->response->redirect($this->url->link('account'));
                         }
                        $this->document->setTitle('用户登录');
                        $this->document->addScript(THEME_PATH.'js/jquery/jquery.cookie.js');
                        $this->document->addScript(THEME_PATH.'js/login.js');
                        $this->document->addStyle(THEME_PATH.'css/signin.css');
                        $data['register'] = $this->url->link('account/register', '', true);
                        $data['header'] = $this->load->controller('common/account_header');
                        $data['footer'] = $this->load->controller('common/footer');
                        $redirect =  @$this->request->server['HTTP_REFERER'];
                        if($redirect!=''){
                                preg_match("/^(http:\/\/)?([^\/]+)/i", $redirect, $matches);
                                preg_match("/^(http:\/\/)?([^\/]+)/i", $this->request->server['HTTP_HOST'], $matches_curr);
                                $matches_curr[2] == $matches[2] && $this->session->data['redirect'] = $redirect;
                        }
                        $this->response->setOutput($this->load->view('account/login', $data));
                  }
                  
                  public function snsauth(){
                          $type   = trim($this->request->get['type']);
                          if(in_array($type, array('weibo', 'qq', 'weixin'))){
                                $service = new SnsService($this, $this->request->get);
                                $service->snsAuth();
                          }
                  }
                  
                  public function snscallback($type=''){
                          if($type==''){
                                $type   = trim($this->request->get['type']);
                          }
                          if(in_array($type, array('weibo', 'qq', 'weixin'))){
                                  $service = new SnsService($this, $this->request->get);
                                  $open_id = '';
                                  $nick = '';
                                  switch ($type){
                                          case 'weibo':
                                                  $userinfo = $service->getWeiboUserInfo();
                                                  //print_r($userinfo);
                                                  if(isset($userinfo['id'])){
                                                        $open_id = $userinfo['id'];
                                                        $nick = $userinfo['screen_name'];
                                                  }
                                                  break;
                                          case 'qq':
                                                  $userinfo = $service->getQQUserInfo();
                                                  @ob_clean();
                                                  if(isset($userinfo['open_id'])){
                                                        $open_id = $userinfo['open_id'];
                                                        $nick = $userinfo['nickname'];
                                                  }
                                                  break;
                                          case 'weixin':
                                                  $code = trim($this->request->get['code']);
                                                  if($code!=''){
                                                          $userinfo = $service->getWechatUserInfo();
                                                          if($userinfo){
                                                                  $open_id = $userinfo['openid'];
                                                                  $nick = $userinfo['nickname'];
                                                          }
                                                  }
                                                  break;
                                          default :
                                                  break;
                                  }
                                  if($open_id!=''){//授权成功
                                        $service = new AccountService($this, $this->request->get);
                                        $result = $service->snslogin($type, $open_id, $nick);
                                        if($result->code=='0'){//登录成功
                                                $this->response->redirect($this->url->link('account/snsauthsuc', '', true));
                                        }else if(isset($result->msg)){
                                                $this->error = $result->msg;
                                        }else{
                                                $this->error = '服务器异常';
                                        }
                                  }
                                  if(is_string($this->error)){
                                          echo $this->error;
                                  }else{
                                          var_dump($this->error);
                                  }
                          }
                  }
                  
                  public function qqcallback(){
                          $this->snscallback('qq');
                  }

                  public function passport(){
                          $json = array();
                          if($this->validate()){
                                $service = new AccountService($this, $this->request->post);
                                $result = $service->login();
                                if($result->code=='0'){//登录成功
                                        $json['code'] = 'ok';
                                        $json['href'] = isset($this->session->data['redirect']) ? $this->session->data['redirect'] : $this->url->link('account', '', true);
                                }else if(isset($result->msg)){
                                        $this->error = $result->msg;
                                }else{
                                        $this->error = '服务器异常';
                                }
                          }
                          if($this->error){
                                  $json = array('code'=>'err', 'msg'=>$this->error);
                          }
                          $this->response->setOutput(json_encode($json));
                  }
                  
                  public function findpwd(){
                          $json = array();
                          if($this->findpwd_validate()){
                                   $service = new AccountService($this, $this->request->post);
                                   $result = $service->setpwdbysms();
                                   if($result->code=='0'){//修改成功
                                             $json['code'] = 'ok';
                                             $json['href'] = $this->url->link('account/login', '', true);
                                   }else if(isset($result->msg)){
                                        $this->error = $result->msg;
                                   }else{
                                        $this->error = '服务器异常';
                                   }
                          }
                          if($this->error){
                                  if(strpos($this->error,'手机验证码')!==FALSE){
                                          $code = 1001;
                                  }else{
                                          $code = 1002;
                                  }
                                  $json = array('code'=>$code, 'msg'=>$this->error);
                          }
                         $this->response->setOutput(json_encode($json));
                  }
                  
                  public function findpwdctx(){
                          $json = array();
                          $mobile   = trim($this->request->post['mobile']); //手机号码
                          $smscode = trim($this->request->post['smscode']);
                          if(Utils::validate($mobile, 'mobile') && 6 == strlen($smscode)){
                                $cache = new Red(0);
                                if($smscode == $cache->get('user_findpwd_'.$mobile)){
                                        $json['code'] = 'ok';
                                }else{
                                        $this->error = '无效的手机验证码';
                                }
                          }else{
                                $this->error = '无效的手机号码或验证码';
                          }
                          if($this->error){
                                  $json = array('code'=>'err', 'msg'=>$this->error);
                          }
                         $this->response->setOutput(json_encode($json));
                  }
                  
                  protected function findpwd_validate(){
                        $mobile   = trim($this->request->post['account']); //手机号码
                        $password = trim($this->request->post['password']); //密码
                        $smscode = trim($this->request->post['smscode']);
                        if (!Utils::validate($mobile, 'mobile')) {
                                $this->error = '无效的手机号码';
                        }else if(6!=strlen($smscode)){
                                $this->error = '无效的手机验证码';
                        }else if ((utf8_strlen($password) < 8) || (utf8_strlen($password) > 16)){
                                $this->error = '无效的用户密码';
                        }else{
                                $cache = new Red(0);
                                if($smscode != $cache->get('user_findpwd_'.$mobile)){
                                        $this->error = '无效的手机验证码';
                                }
                        }
                        return !$this->error;
                  }

                  protected function validate() {
                        $mobile   = trim($this->request->post['account']); //手机号码
                        $password = trim($this->request->post['password']); //密码
                        if (!Utils::validate($mobile, 'mobile')) {
                                $this->error = '手机号码输入错误';
                        }else if ((utf8_strlen($password) < 8) || (utf8_strlen($password) > 16)){
                                $this->error = '输入密码无效';
                        }
                        return !$this->error;
                  }
                  
                  public function test(){
                          $this->load->model('account/customer');
                          
                          if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
                                $this->error['warning'] = $this->language->get('error_login');

                                $this->model_account_customer->addLoginAttempt($this->request->post['email']);
                        } else {
                                $this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
                        }
                          
                          die;
                          // Unset guest
                                unset($this->session->data['guest']);

                                // Default Shipping Address
                                $this->load->model('account/address');

                                if ($this->config->get('config_tax_customer') == 'payment') {
                                        $this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                                }

                                if ($this->config->get('config_tax_customer') == 'shipping') {
                                        $this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
                                }

                                // Wishlist
                                if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
                                        $this->load->model('account/wishlist');

                                        foreach ($this->session->data['wishlist'] as $key => $product_id) {
                                                $this->model_account_wishlist->addWishlist($product_id);

                                                unset($this->session->data['wishlist'][$key]);
                                        }
                                }

                                // Add to activity log
                                $this->load->model('account/activity');

                                $activity_data = array(
                                        'customer_id' => $this->customer->getId(),
                                        'name'        => $this->customer->getFullName()
                                );

                                $this->model_account_activity->addActivity('login', $activity_data);
                                var_dump($this->session->data);
                  }

                  public function index_old() {
		$this->load->model('account/customer');

		// Login override for admin users
		if (!empty($this->request->get['token'])) {
			$this->customer->logout();
			$this->cart->clear();

			unset($this->session->data['order_id']);
			unset($this->session->data['payment_address']);
			unset($this->session->data['payment_method']);
			unset($this->session->data['payment_methods']);
			unset($this->session->data['shipping_address']);
			unset($this->session->data['shipping_method']);
			unset($this->session->data['shipping_methods']);
			unset($this->session->data['comment']);
			unset($this->session->data['coupon']);
			unset($this->session->data['reward']);
			unset($this->session->data['voucher']);
			unset($this->session->data['vouchers']);

			$customer_info = $this->model_account_customer->getCustomerByToken($this->request->get['token']);

			if ($customer_info && $this->customer->login($customer_info['email'], '', true)) {
				// Default Addresses
				$this->load->model('account/address');

				if ($this->config->get('config_tax_customer') == 'payment') {
					$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				if ($this->config->get('config_tax_customer') == 'shipping') {
					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
				}

				$this->response->redirect($this->url->link('account/account', '', true));
			}
		}

		if ($this->customer->isLogged()) {
			$this->response->redirect($this->url->link('account/account', '', true));
		}

		$this->load->language('account/login');

		$this->document->setTitle($this->language->get('heading_title'));

		if (($this->request->server['REQUEST_METHOD'] == 'POST') && $this->validate()) {
			// Unset guest
			unset($this->session->data['guest']);

			// Default Shipping Address
			$this->load->model('account/address');

			if ($this->config->get('config_tax_customer') == 'payment') {
				$this->session->data['payment_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			if ($this->config->get('config_tax_customer') == 'shipping') {
				$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->customer->getAddressId());
			}

			// Wishlist
			if (isset($this->session->data['wishlist']) && is_array($this->session->data['wishlist'])) {
				$this->load->model('account/wishlist');

				foreach ($this->session->data['wishlist'] as $key => $product_id) {
					$this->model_account_wishlist->addWishlist($product_id);

					unset($this->session->data['wishlist'][$key]);
				}
			}

			// Add to activity log
			$this->load->model('account/activity');

			$activity_data = array(
				'customer_id' => $this->customer->getId(),
				'name'        => $this->customer->getFullName()
			);

			$this->model_account_activity->addActivity('login', $activity_data);

			// Added strpos check to pass McAfee PCI compliance test (http://forum.opencart.com/viewtopic.php?f=10&t=12043&p=151494#p151295)
			if (isset($this->request->post['redirect']) && (strpos($this->request->post['redirect'], $this->config->get('config_url')) !== false || strpos($this->request->post['redirect'], $this->config->get('config_ssl')) !== false)) {
				$this->response->redirect(str_replace('&amp;', '&', $this->request->post['redirect']));
			} else {
				$this->response->redirect($this->url->link('account/account', '', true));
			}
		}


		$data['heading_title'] = $this->language->get('heading_title');

		$data['register'] = $this->url->link('account/register', '', true);

		if (isset($this->request->post['password'])) {
			$data['password'] = $this->request->post['password'];
		} else {
			$data['password'] = '';
		}

                                    $data['header'] = $this->load->controller('common/account_header');
		$data['footer'] = $this->load->controller('common/footer');

		$this->response->setOutput($this->load->view('account/login', $data));
	}

	protected function validate_old() {
		// Check how many login attempts have been made.
		$login_info = $this->model_account_customer->getLoginAttempts($this->request->post['email']);

		if ($login_info && ($login_info['total'] >= $this->config->get('config_login_attempts')) && strtotime('-1 hour') < strtotime($login_info['date_modified'])) {
			$this->error['warning'] = $this->language->get('error_attempts');
		}

		// Check if customer has been approved.
		$customer_info = $this->model_account_customer->getCustomerByEmail($this->request->post['email']);

		if ($customer_info && !$customer_info['approved']) {
			$this->error['warning'] = $this->language->get('error_approved');
		}

		if (!$this->error) {
			if (!$this->customer->login($this->request->post['email'], $this->request->post['password'])) {
				$this->error['warning'] = $this->language->get('error_login');

				$this->model_account_customer->addLoginAttempt($this->request->post['email']);
			} else {
				$this->model_account_customer->deleteLoginAttempts($this->request->post['email']);
			}
		}

		return !$this->error;
	}
}
