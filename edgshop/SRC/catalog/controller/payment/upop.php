<?php
require_once(DIR_SYSTEM.'laravel/load.php');

use Pay\ChinapayApi;
use App\Service\OrderService;
class ControllerPaymentupop extends Controller {
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
                                    //****************************************************************************//
                                    $order_no = $order_info['order_no'];
                                    $chinapay = new ChinapayApi();
                                    $merid = $chinapay->getMerId();
                                    //订单金额，定长12位，以分为单位，不足左补0，必填
                                    $transamt = $order_info['total'] * 100;

                                    //订单日期
                                    $transdate = date('Ymd', strtotime($order_info['time_expire']));
                                    //页面返回地址(您服务器上可访问的URL)，最长80位，当用户完成支付后，银行页面会自动跳转到该页面，并POST订单结果信息，可选
                                    $pagereturl = $this->url->link('payment/upop/callback');
                                    //后台返回地址(您服务器上可访问的URL)，最长80位，当用户完成支付后，我方服务器会POST订单结果信息到该页面，必填
                                    $bgreturl = $this->url->link('payment/upop/notify');

                                    //***********************************************************************//
                                    $paramArray=array(
                                                'Version' => '20140728',
                                                //'AccessType' => 0,
                                                'MerId' => $merid,
                                                'MerOrderNo' => $order_no,
                                                'TranDate' => $transdate,
                                                'TranTime' => date('His', strtotime($order_info['time_expire'])),
                                                'OrderAmt' => $transamt,
                                                //'TranType'
                                                'BusiType' => '0001',
                                                'MerPageUrl' => $pagereturl,
                                                'MerBgUrl' => $bgreturl
                                    );
                                    $chinapay->sign($paramArray);
                                    $sign = $chinapay->getSign();

                                    $paramArray['Signature'] = $sign;
                                    $data['parameter'] = $paramArray;
                                    $data['payurl'] = $chinapay->getPayUrl();
                                    $this->response->setOutput($this->load->view('payment/upop', $data));
	}
	
	public function callback() {
                        //计算得出通知验证结果
                        $chinapay = new ChinapayApi();
                        $verify_result = $chinapay->verify($_POST);
                        //商户订单号
                        $order_no = $_POST['MerOrderNo'];
                        $order_service = new OrderService($this, $this->request->get);
                        $order_info = $order_service->getOrderByOrderno($order_no);
                        $order_id = $order_info['order_id'];
                        if($verify_result) {//验证成功
                                //交易状态
                                $trade_status = $_POST['OrderStatus'];
                                if($trade_status == '0000') {
                                        $this->log->write('Upop_Return :: One: ');
                                        $trade_no = $_POST['AcqSeqId'];
                                        $total = (int)$_POST['OrderAmt'];
                                        $total = $total/100;
                                        //交易状态
                                        $order_service->completeOrder($order_id, 'upop', $trade_no, $total);
                                        $this->response->redirect($this->url->link("checkout/success"));
                                } else {
                                        $this->log->write('Upop_Return :: Two: ');
                                }
                        }else{
                                //验证失败
                                $this->log->write('Upop :: 验证失败: ');
                                $this->log->write('Upop_Data:: : '.  var_export($_POST, true));
                                $this->response->redirect($this->url->link("account/order/info?order_id=".(int)$order_id));
                        }
	}

                  public function notify() {
                        $chinapay = new ChinapayApi();
                        foreach ($_POST as $key => $val){
                                $_POST[$key] = urldecode($val);
                        }
                        $verify_result = $chinapay->verify($_POST);
                        if($verify_result) {//验证成功
                                //交易状态
                                $trade_status = $_POST['OrderStatus'];
                                if($trade_status == '0000') {
                                        $this->log->write('Upop_Return :: One: ');
                                        $this->log->write('Upop_Data:: : '.  var_export($_POST, true));
                                        //商户订单号
                                        $order_no = $_POST['MerOrderNo'];
                                        $trade_no = $_POST['AcqSeqId'];
                                        $total = (int)$_POST['OrderAmt'];
                                        $total = $total/100;
                                        $order_service = new OrderService($this, $this->request->get);
                                        $order_info = $order_service->getOrderByOrderno($order_no);
                                        $order_id = $order_info['order_id'];
                                        //交易状态
                                        $order_service->completeOrder($order_id, 'upop', $trade_no, $total);
                                        $this->response->redirect($this->url->link("checkout/success"));
                                } else {
                                        $this->log->write('Upop_Return :: Two: ');
                                }
                        }
                  }
}
