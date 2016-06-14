<?php 
namespace App\Service;
use App\Eloquent\Customer;
use App\Eloquent\Address;
use App\Eloquent\CustomerLogin;
use App\Eloquent\CustomerActivity;
use App\Eloquent\CustomerGroup;

use App\Validation\RegisterValidator;

class AccountService
{
	protected $opencart;

	protected $params;
        
                  protected $accountapi;

	public $errors;

	public function __construct($opencart, $params)
	{
                            $this->opencart = $opencart;
                            $this->params = $params;
                            $this->opencart->load->library('edgapi/account');
                            $this->accountapi = new \Edgapi\Account;
	}

                  /**
                   * 注册对接接口
                   */
                  public function create(){
                        $params = $this->params;
                        $phone = $params['account'];
                        $codekey = 'edg_user_register_'.$phone;
                        $smscode = $params['smscode'];
                        $pwd = $params['password'];
                        $rs = $this->accountapi->create($phone, $codekey, $smscode, $pwd);
                        return $rs;
                  } 
                  
                  public function register($params){
                        $opencart = $this->opencart;
                        $opencart->load->model('account/customer');
                        $customer_id = $opencart->model_account_customer->addCustomer($params);
                        if($customer_id>0 ){
                                $member_id = $params['id'];
                                $token = $params['token'];
                                $username = $params['phone'];
                                $logininfo = array(
                                     'member_id' => $member_id,
                                     'token' => $token, 
                                     'phone' => $username, 
                                     'nick' => '',
                                     'logo' => ''
                                 );
                                // Add to activity log
                                $opencart->load->model('account/activity');
                                $activity_data = array(
                                        'customer_id' => $customer_id,
                                        'name'           => $username
                                );
                                $opencart->model_account_activity->addActivity('register', $activity_data);

                                return $this->logincomplete($logininfo);
                        }
                  }

                  public function register2($params)
	{
		$opencart = $this->opencart;
		if (isset($params['customer_group_id']) && is_array($opencart->config->get('config_customer_group_display')) && in_array($params['customer_group_id'], $opencart->config->get('config_customer_group_display'))) {
			$customer_group_id = $params['customer_group_id'];
		} else {
			$customer_group_id = $opencart->config->get('config_customer_group_id');
		}

		$group = CustomerGroup::find($customer_group_id);
                                    $params['customer_group_id'] = 1;
                                    var_dump($params);
		$customer = Customer::create($params);
		$customer->customer_group_id = $customer_group_id;
		$customer->approved          = !$group->approval;
		$customer->store_id           = $opencart->config->get('config_store_id');
		$customer->ip                = $opencart->request->server['REMOTE_ADDR'];
                                    print_r($customer);die;
		$customer->save();

		//$customer->addAddress($params, true);

		// Send mail...

		CustomerLogin::where('email', $params['email'])->delete();
		
		$opencart->customer->login($opencart->request->post['email'], $opencart->request->post['password']);

		unset($opencart->session->data['guest']);

		$activity_data = array(
			'customer_id' => $opencart->customer->getId(),
			'name'        => $opencart->request->post['firstname'] . ' ' . $opencart->request->post['lastname']
		);

		$activity = new CustomerActivity;
		$activity->customer_id = $opencart->customer->getId();
		$activity->key         = 'register';
		$activity->data        = serialize($activity_data);
		$activity->ip          = $opencart->request->server['REMOTE_ADDR'];

		//$opencart->response->redirect($opencart->url->link('account/success'));
	}
                  
                  /**
                   * 用户名密码登录对接接口
                   */
                  public function login(){
                        $params = $this->params;
                        $phone = $params['account'];
                        $pwd = $params['password'];
                        $result = $this->accountapi->login($phone, $pwd);
                        //print_r($result);
                        if($result->code=='0'){//api登录成功
                                 $userdata = $result->data;
                                 $member_id = $userdata->id;
                                 $token  = $userdata->token;
                                 $nick    = $userdata->nick;
                                 $phone = $userdata->phone;
                                 $logo    = $userdata->logo;
                                 $logininfo = array(
                                     'member_id' => $member_id,
                                     'token' => $token, 
                                     'phone' => $phone, 
                                     'nick' => $nick,
                                     'logo' => $logo
                                 );
                                 $this->logincomplete($logininfo);
                        }
                        return $result;
                  }
                  
                  public function snslogin($type, $openid, $nick){
                          $result = $this->accountapi->snslogin($type, $openid);
                          if($result->code=='0'){//sns登录成功
                                 $userdata = $result->data;
                                 $member_id = $userdata->id;
                                 $token  = $userdata->token;
                                 $api_nick    = $userdata->nick;
                                 $phone = $userdata->phone;
                                 $logo    = $userdata->logo;
                                 $api_nick == '' && $api_nick = $nick;
                                 $logininfo = array(
                                     'member_id' => $member_id,
                                     'token' => $token, 
                                     'phone' => $phone, 
                                     'nick' => $api_nick, 
                                     'type' => $type,
                                     'logo' => $logo
                                 );
                                 $this->logincomplete($logininfo);
                          }
                          return $result;
                  }

                /**
                 * 完成登录信息
                 * @param string $member_id
                 * @param string $token
                 * @param string $phone
                 * @param string $nick
                 * @param string $logo
                 */
                protected function logincomplete($logininfo){
                        $phone = $logininfo['phone'];
                        $nick = $logininfo['nick'];
                        if($phone=='' && $nick==''){
                                return FALSE;
                        }
                        $opencart = $this->opencart;
                        $opencart->load->model('account/customer');
                        $member_id = $logininfo['member_id'];
                        $token = $logininfo['token'];
                        $logo = $logininfo['logo'];
                        $type = isset($logininfo['type']) ? $logininfo['type'] : '';
                        $customer_info = $opencart->model_account_customer->getCustomerByMemberId($member_id);
                        if(empty($customer_info)){//尝试添加至customer表
                                $add_data = array(
                                    'id' => $member_id,
                                    'phone' => trim($phone),
                                    'fullname' => trim($nick),
                                    'token' => $token,
                                    'logo'   => $logo,
                                    'type'   => $type
                                 );
                                $customer_id = $opencart->model_account_customer->addCustomer($add_data);//主要用于SNS用户登录时，可能是首次登录网站的情况，添加注册信息
                        }else{
                                $customer_id = $customer_info['customer_id'];
                        }
                        if($customer_id>0){
                                $opencart->model_account_customer->deleteLoginAttempts($customer_id);
                                $opencart->customer->login($member_id, $token, $type, $nick);

                                // Add to activity log
                                $opencart->load->model('account/activity');
                                $activity_data = array(
                                        'customer_id' => $customer_id,
                                        'name'           => ($nick =='' ?  $phone : $nick)
                                );

                                $opencart->model_account_activity->addActivity('login', $activity_data);
                        }
                  }

                  /**
                   * 短信修改密码对接接口
                   */
                  public function setpwdbysms(){
                          $param = $this->params;
                          $mobile = $param['account'];
                          $newpwd = MD5($param['password']);
                          $codekey = 'edg_user_findpwd_'.$mobile;
                          $smscode= $param['smscode'];
                          return $this->accountapi->setpwdbysms($mobile, $smscode, $codekey, $newpwd);
                  }

                  /**
                   * 修改密码对接接口
                   */
                  public function modifypwd(){
                          $param = $this->params;
                          $oldpwd = MD5($param['password_old']);
                          $newpwd = MD5($param['password']);
                          return $this->accountapi->modifypwdbyoldpwd($this->opencart->customer->getMemberId(), $newpwd, $oldpwd);
                  }
                  
                  /**
                   * 注册帐号是否已注册
                   * @return object
                   */
                  public function accountchk(){
                          $phone = $this->params['mobile'];
                          return $this->accountapi->accountchk($phone);
                  }
}