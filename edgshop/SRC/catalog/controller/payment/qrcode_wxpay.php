<?php
require_once(DIR_SYSTEM.'laravel/load.php');

use App\Service\OrderService;

class ControllerPaymentQrcodeWxPay extends EdgController {
	public function index() {
                                    $order_id = $this->request->get['orderid'];
                                    if(!is_numeric($order_id)){
                                            exit();
                                    }
                                    $cache_order = $this->cache->get('prepay_order_'.$order_id);
                                    if(empty($cache_order)){
                                            echo '不可支付的订单';
                                            exit();
                                    }

                                    $order_service = new OrderService($this, $this->request->get);
                                    $order_info = $order_service->getPrepayOrder($order_id);
                                    if(empty($order_info)){
                                            echo '不可支付的订单';
                                            exit();
                                    }

		//$this->load->library('wxpayexception');
		require_once(DIR_SYSTEM.'library/wxpayexception.php');

		define('APPID', $this->config->get('wxpay_appid'));
		define('MCHID', $this->config->get('wxpay_mchid'));
		define('KEY', $this->config->get('wxpay_key'));
		define('APPSECRET', $this->config->get('wxpay_appsecret'));

		//$this->load->library('wxpaydata');
		require_once(DIR_SYSTEM.'library/wxpaydata.php');
		//$this->load->library('wxpayapi');
		require_once(DIR_SYSTEM.'library/wxpayapi.php');
		
		//$this->load->library('wxpaynativepay');
		require_once(DIR_SYSTEM.'library/wxpaynativepay.php');
		$this->load->language('payment/qrcode_wxpay');
		
//		$this->load->model('checkout/order');
//		$order_info = $this->model_checkout_order->getOrder($order_id);
//		$this->load->model('account/order');
//		$shipping_cost = 0;
//		$totals = $this->model_account_order->getOrderTotals($order_id);
//
//		foreach ($totals as $total) {
//			if($total['title'] == 'shipping') {
//				$shipping_cost = $total['value'];
//			}
//		}
                                    
                                    $cache_key = 'order_qrcode_url_'.$order_id;
                                    $code_url = $this->cache->get($cache_key);
                                    if(empty($code_url)){
                                                $item_name = $this->config->get('config_name');
                                                $fullname = $order_info['payment_fullname'];

                                                $notify_url = HTTP_SERVER.'payment/qrcode_wxpay/callback';
                                                //$order_no = $order_info['order_no'];
                                                //$out_trade_no = $order_id;
                                                $out_trade_no =   $order_info['order_no'];
                                                $subject = $item_name . ' ' . $this->language->get('text_order');
                                                $amount = $order_info['total'];

                                                $currency_value = $this->currency->getValue('CNY');
                                                $price = $amount * $currency_value;
                                                $price = number_format($price, 2, '.', '');

                                                $total_fee = $price * 100;//乘100去掉小数点，以传递整数给微信支付

                                                $notify = new NativePay();
                                                $input = new WxPayUnifiedOrder();
                                                $input->SetBody($subject);
                                                $input->SetAttach("EDG");
                                                $input->SetOut_trade_no($out_trade_no);
                                                $input->SetTotal_fee($total_fee);
                                                $input->SetTime_start(date("YmdHis"));
                                                //$input->SetTime_expire(date("YmdHis", time() + 600));
                                                $input->SetGoods_tag("EDG");
                                                $input->SetNotify_url($notify_url);
                                                $input->SetTrade_type("NATIVE");
                                                $input->SetProduct_id($order_id);
                                                $input->SetTime_expire(date("YmdHis", strtotime($order_info['time_expire'])));
                                                $result = $notify->GetPayUrl($input);

                                                if($result['return_code'] == 'SUCCESS' && isset($result['code_url'])){
                                                            $code_url = $result["code_url"];
                                                            $this->cache->set($cache_key, $result['code_url'],  strtotime($order_info['time_expire'])-strtotime($order_info['date_added']));
                                                }else if(isset($result['err_code_des'])){
                                                        echo $result['err_code_des'];
                                                }else if(isset($result['return_msg'])){
                                                        echo $result['return_msg'];
                                                }
                                    }
                                    if($code_url != ''){
                                                //$data['redirect'] = $this->url->link('checkout/qrcode_wxpay_success');
                                                $this->document->setTitle('微信扫码支付');
                                                $data['code_url'] = $code_url;
                                                $data['order_id'] = $order_id;
                                                $data['code'] = MD5($data['code_url']);
                                                $data['footer'] = $this->load->controller('common/footer');
                                                $data['header'] = $this->load->controller('common/header');
                                                $this->response->setOutput($this->load->view('payment/qrcode_wxpay', $data));
                                    }
	}
	
	
	public function callback() {
		$log = $this->config->get('qrcode_wxpay_log');
		//$this->load->library('wxpayexception');
		require_once(DIR_SYSTEM.'library/wxpayexception.php');
		define('APPID', $this->config->get('wxpay_appid'));
		define('MCHID', $this->config->get('wxpay_mchid'));
		define('KEY', $this->config->get('wxpay_key'));
		define('APPSECRET', $this->config->get('wxpay_appsecret'));
		//$this->load->library('wxpaydata');
		require_once(DIR_SYSTEM.'library/wxpaydata.php');
		//echo "four";
		//$this->load->library('wxpayapi');
		require_once(DIR_SYSTEM.'library/wxpayapi.php');
		//$this->load->library('wxpaynotify');
		require_once(DIR_SYSTEM.'library/wxpaynotify.php');
		//$this->load->library('qrcode_wxpay_notify');
		require_once(DIR_SYSTEM.'library/qrcode_wxpay_notify.php');
		if($log) {
			$this->log->write('QrcodeWxPay :: One ');
		}

		$notify = new PayNotifyCallBack();
		$notify->Handle(false);
		if($log) {
			$this->log->write('QrcodeWxPay :: Two ');
		}
		$getxml = isset($GLOBALS['HTTP_RAW_POST_DATA']) ? $GLOBALS['HTTP_RAW_POST_DATA'] : file_get_contents('php://input');
		libxml_disable_entity_loader(true);
		$result= json_decode(json_encode(simplexml_load_string($getxml, 'SimpleXMLElement', LIBXML_NOCDATA)), true);
		if($notify->GetReturn_code() == "SUCCESS") {
			if ($result["return_code"] == "FAIL") {
				$this->log->write("QrcodeWxPay ::【通信出错】:\n".$getxml."\n");
			}elseif($result["result_code"] == "FAIL"){
				$this->log->write("QrcodeWxPay ::【业务出错】:\n".$getxml."\n");
			}else{
                                                                        $order_service = new OrderService($this, $this->request->get);
                                                                        $order_no  = $result['out_trade_no'];
                                                                        $order_info = $order_service->getOrderByOrderno($order_no);
                                                                        $order_id = $order_info['order_id'];
				if($log) {
					$this->log->write('QrcodeWxPay :: Order ID: '.$order_id);
				}
//				$this->load->model('checkout/order');
//				$order_info = $this->model_checkout_order->getOrder($order_id);
//				if ($order_info) {
//					if($log) {
//						$this->log->write('QrcodeWxPay :: 1: ');
//					}
//					$order_status_id = $this->config->get('qrcode_wxpay_trade_success_status_id');	
//					if (!$order_info['order_status_id']) {
//						$this->model_checkout_order->addOrderHistory($order_id, $order_status_id, '', true);
//						$this->log->write('QrcodeWxPay :: 2: ');
//					} else {
//						$this->model_checkout_order->addOrderHistory($order_id, $order_status_id, '', true);
//						$this->log->write('QrcodeWxPay :: 3: ');
//					}
//					//清除sesssion，避免客户返回不到成功页面而无法清除原有的购物车等信息
//					$this->cart->clear();		
//				}else{
//					if($log) {
//						$this->log->write('QrcodeWxPay :: Three: ');
//					}
//				}
                                                                        $transaction_id = $result['transaction_id'];
                                                                        $total_fee = (int)$result['total_fee'];
                                                                        $total_fee = $total_fee/100;
                                                                        $order_resut = $order_service->completeOrder($order_id, 'qrcode_wxpay', $transaction_id, $total_fee);
			}
		}else{
			$this->log->write('QrcodeWxPay :: Four: '.var_export($result, true));
		}
	}

	public function getstate(){
                                $json = array();
                                $order_id = $this->request->get['orderid'];
                                if(!is_numeric($order_id)){
                                        exit();
                                }
                                $cache_key = 'order_qrcode_url_'.$order_id;
                                $code_url = $this->cache->get($cache_key);
                                if($code_url != ''){
                                        if($code_url == 'success'){
                                                $this->cache->delete($cache_key);
                                                $json['redirect'] = $this->url->link('checkout/success');
                                        }else{
                                                $json['state'] = 500;
                                        }
                                }else{
                                        $json['redirect'] = $this->url->link("account/order/info?order_id=".(int)$order_id);
                                }
                                $this->response->addHeader('Content-Type: application/json');
                                $this->response->setOutput(json_encode($json));
                  }
                  
//                  public function test(){
//                          $order_service = new OrderService($this, $this->request->get);
//                          $order_resut = $order_service->completeOrder('53');
//                  }
}