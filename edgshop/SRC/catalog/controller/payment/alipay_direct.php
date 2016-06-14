<?php
require_once(DIR_SYSTEM.'laravel/load.php');

use Pay\AlipayApi;
use App\Service\OrderService;

class ControllerPaymentAlipayDirect extends Controller {
	public function index() {
                                    $order_id = $this->request->get['orderid'];
                                    $order_service = new OrderService($this, $this->request->get);
                                    $order_id !='' && $order_info = $order_service->getPrepayOrder($order_id);
                                    if(empty($order_info)){
                                            echo '不可支付的订单';
                                            exit();
                                    }
                                    $cache_order = $this->cache->get('prepay_order_'.$order_id);
                                    if(empty($cache_order)){
                                            echo '不可支付的订单';
                                            exit();
                                    }

		$this->load->language('payment/alipay_direct');
                		$alipay_config['partner']	=      $this->config->get('alipay_direct_partner');
		$alipay_config['input_charset']  = strtolower('utf-8');
		$item_name = $this->config->get('config_name');
		$fullname = $order_info['payment_fullname'];
//		$shipping_cost = 0;
//		$totals = $this->model_account_order->getOrderTotals($order_id);
//		foreach ($totals as $total) {	
//			if($total['title'] == 'shipping') {
//                                                                $shipping_cost = $total['value'];
//			}
//		}

                                    $payment_type = "1";
                                    $notify_url = HTTPS_SERVER.'payment/alipay_direct/callback';
                                    $return_url = $this->url->link('payment/alipay_direct/result_show');
                                    $seller_email = $this->config->get('alipay_direct_seller_email');
                                    $out_trade_no = $order_info['order_no'];
                                    $subject = $item_name . ' ' . $this->language->get('text_order') .' '. $out_trade_no;
                                    $amount = $order_info['total'];

		$currency_value = $this->currency->getValue('CNY');
		$price = $amount * $currency_value;
		$price = number_format($price, 2, '.', '');
		$total_fee = $price;
		//$total_fee = 0.01; //test

                                    $body =  $this->language->get('text_owner') . ' ' . $fullname;
                                    $show_url = $this->url->link('/');
                                    $anti_phishing_key = "";
                                    $exter_invoke_ip = Utils::get_client_ip();
		$parameter = array(
				"service" => "create_direct_pay_by_user",
				"partner" => trim($alipay_config['partner']),
				"payment_type"	=> $payment_type,
				"notify_url"	=> $notify_url,
				"return_url"	=> $return_url,
				"seller_email"	=> $seller_email,
				"out_trade_no"	=> $out_trade_no,
				"subject"	=> $subject,
				"total_fee"	=> $total_fee,
                                                                         //'it_b_pay' => '',//$it_b_pay,//超时时间（h,d,1c;1c为当天结束）
				"body"	=> $body,
				"show_url"	=> $show_url,
				"anti_phishing_key"	=> $anti_phishing_key,
				"exter_invoke_ip"	=> $exter_invoke_ip,
				"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
		);

                                    $alipaySubmit = new AlipayApi();
                                    $data['html_text'] = $alipaySubmit->getSubmitHtml($parameter);
		$this->response->setOutput($this->load->view('payment/alipay_direct', $data));
	}
	
	public function callback() {
		$alipayNotify = new AlipayApi();
		$verify_result = $alipayNotify->verifyNotify();
                                    $log = true;
		if($log) {
			$this->log->write('Alipay_Direct :: Two: ' . $verify_result);
                                                      $this->log->write('Alipay_Direct :: Data: ' . var_export($_POST, true));
		}
		if($verify_result) {		
			$out_trade_no = $_POST['out_trade_no'];
			$order_no   = $out_trade_no; 

//			$trade_status = $this->request->post['trade_status'];

                                                      $order_service = new OrderService($this, $this->request->post);
                                                      $order_info = $order_service->getOrderByOrderno($order_no);
                                                      $order_id = $order_info['order_id'];

			if($log) {
				$this->log->write('Alipay_Direct :: Three: ');
			}
			if ($order_info) {
				if($log) {
					$this->log->write('Alipay_Direct :: Four: ');
				}
				if($_POST['trade_status'] == 'TRADE_FINISHED' || $_POST['trade_status'] == 'TRADE_SUCCESS') {
					if($log) {
						$this->log->write('Alipay_Direct :: Five: ');
					}
                                                                                          $trade_no = $this->request->post['trade_no'];
                                                                                          $total_fee = $this->request->post['total_fee'];
                                                                                          $order_service->completeOrder($order_id, 'alipay_direct', $trade_no, $total_fee);
					echo "success";
				} else if ($_POST['trade_status'] == 'TRADE_SUCCESS') {
					
					if($log) {
						$this->log->write('Alipay_Direct :: Six: ');
					}
					$order_service->completeOrder($order_id, 'alipay_direct');
					echo "success";
				}
			}else{
				if($log) {
					$this->log->write('Alipay_Direct :: Seven: ');
				}
				echo "fail";
			}
		} else {
			if($log) {
				$this->log->write('Alipay_Direct :: Eight: ');
			}
			echo "fail";
		}
	}

                  //支付宝支付返回页面
                  function result_show(){
                        unset($_GET['route']);
                        //计算得出通知验证结果
                        $alipayNotify = new AlipayApi();
                        $verify_result = $alipayNotify->verifyReturn();
                        if($verify_result) {//验证成功
                                //商户订单号
                                $order_no = $_GET['out_trade_no'];
                                $total_fee = $_GET['total_fee'];
                                //交易状态
                                $trade_status = $_GET['trade_status'];
                                if($trade_status == 'TRADE_FINISHED' || $trade_status == 'TRADE_SUCCESS') {
                                        $this->log->write('Alipay_Direct_Return :: One: ');
                                        $order_service = new OrderService($this, $this->request->get);
                                        $order_info = $order_service->getOrderByOrderno($order_no);
                                        $order_id = $order_info['order_id'];
                                        $trade_no = $this->request->get['trade_no'];
                                        //交易状态
                                        $order_service->completeOrder($order_id, 'alipay_direct', $trade_no, $total_fee);
                                        $this->response->redirect($this->url->link("checkout/success"));
                                } else {
                                        $this->log->write('Alipay_Direct_Return :: Two: ');
                                }
                                
                        }else{
                                //验证失败
                                $this->log->write('Alipay_Direct :: 验证失败: ');
                                $order_service = new OrderService($this, $this->request->get);
                                $order_no = $_GET['out_trade_no'];
                                $order_info = $order_service->getOrderByOrderno($order_no);
                                $order_id = $order_info['order_id'];
                                $this->response->redirect($this->url->link("account/order/info?order_id=".(int)$order_id));
                        }
                }

}