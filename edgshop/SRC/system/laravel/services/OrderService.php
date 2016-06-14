<?php 
namespace App\Service;

class OrderService
{
        protected $opencart;

        protected $params;

        public $errors;

        public function __construct($opencart, $params)
        {
                            $this->opencart = $opencart;
                            $this->params = $params;
                            $this->opencart->load->helper('utils');
        }

        /**
         * 订单详情
         * @param type $order_id
         * @return type
         */
        public function getOrder($order_id){
                $opencart = $this->opencart;
                $opencart->load->model('checkout/order');
                $orderinfo = $this->opencart->model_checkout_order->getOrder($order_id);
                return $orderinfo;
        }
        
        /**
         * 待支付订单详情
         * @param type $order_id
         * @return type
         */
        public function getPrepayOrder($order_id){
                $opencart = $this->opencart;
                $opencart->load->model('checkout/order');
                $orderinfo = $this->opencart->model_checkout_order->getOrder($order_id);

                if($orderinfo && $orderinfo['order_status_id'] == '0'){
                        $orderinfo['time_expire'] = date('Y-m-d H:i:s', strtotime($orderinfo['date_added']) + 3600*2);
                        if(strtotime($orderinfo['time_expire']) > time()){
                                $opencart->load->model('account/order');
                                $totals = $opencart->model_account_order->getOrderTotals($order_id);
                                $shipping_cost = 0;
                                foreach ($totals as $total) {
                                        if($total['title'] == 'shipping') {
                                                $shipping_cost = $total['value'];
                                        }
                                }
                                $orderinfo['totals'] = $totals;
                                return $orderinfo;
                        }else{
                                $this->payexit();
                        }
                }else{
                        $this->payexit();
                }
               return FALSE;
        }

        protected function payexit(){
                 echo "<script>window.opener.location.reload();window.close();</script>";
                 exit();
        }

        /**
         * 订单详情
         * @param type $order_no
         * @return type
         */
        public function getOrderByOrderno($order_no){
                $opencart = $this->opencart;
                $opencart->load->model('checkout/order');
                $orderinfo = $this->opencart->model_checkout_order->getOrderByOrderno($order_no);
                if($orderinfo){
                        $order_id = $orderinfo['order_id'];
                        $orderinfo['time_expire'] = date('Y-m-d H:i:s', strtotime($orderinfo['date_added']) + 3600*2);
                        $opencart->load->model('account/order');
                        $totals = $opencart->model_account_order->getOrderTotals($order_id);
                        $shipping_cost = 0;
                        foreach ($totals as $total) {
                                if($total['title'] == 'shipping') {
                                        $shipping_cost = $total['value'];
                                }
                        }
                        $orderinfo['totals'] = $totals;
                        return $orderinfo;
                }
               return FALSE;
        }

        /**
         * 处理支付结果
         * @param int $order_id
         * @param string $payment_code
         * @param string $out_trade_no
         * @param float $total_fee
         */
        public function completeOrder($order_id, $payment_code, $out_trade_no='', $total_fee=0){
                $opencart = $this->opencart;
                $opencart->load->model('checkout/order');
                $order_info = $opencart->model_checkout_order->getOrder($order_id);
                if ($order_info) {
                                $cache_key = 'order_qrcode_url_'.$order_id;
                                $opencart->log->write('Pay :: 1: ');
                                switch ($payment_code){
                                        case 'qrcode_wxpay':
                                                $order_status_id = $opencart->config->get('qrcode_wxpay_trade_success_status_id');
                                                break;
                                        case 'alipay_direct':
                                                $order_status_id = $opencart->config->get('alipay_direct_trade_finished_status_id');
                                        case 'upop':
                                                $order_status_id = $opencart->config->get('upop_order_status_id');
                                        default :
                                                $order_status_id = '17';
                                                break;
                                }
                                if($order_info['order_status_id'] == $order_status_id || !empty($opencart->model_checkout_order->getNotifyStatus($order_id, array($order_status_id)))){
                                        $opencart->log->write('Pay :: END: ');
                                        $opencart->cache->delete($cache_key);
                                        return TRUE;
                                }
                                $payment_methods = array(
                                        'qrcode_wxpay' => '微信扫码支付',
                                        'alipay_direct' => '支付宝',
                                        'upop' => '银联在线'
                                    );
                                $update_data = array(
                                        'payment_method' => isset($payment_methods[$payment_code]) ? $payment_methods[$payment_code] : '',
                                        'payment_code' => $payment_code
                                );
                                try{
                                        $opencart->model_checkout_order->updateOrder($order_id, $update_data);
                                        $payment_data = array(
                                             'payment_method' => $update_data['payment_method'],
                                             'payment_code' => $update_data['payment_code'],
                                             'order_id' => $order_id,
                                             'order_no' => $order_info['order_no'],
                                             'out_trade_no' => $out_trade_no,
                                             'total_fee' => $total_fee
                                        );
                                        $opencart->model_checkout_order->addOrderPayment($payment_data);
                                }  catch (\Exception $e){
                                        $opencart->log->write('OrderUpdate ::  ['.$order_id.'] ->'.  var_export($e->getMessage()));
                                }
                                if (!$order_info['order_status_id']) {
                                        $opencart->log->write('Pay :: 2S: ');
                                        $opencart->model_checkout_order->addOrderHistory($order_id, $order_status_id, '', true);
                                        $opencart->log->write('Pay :: 2E: ');
                                } else {
                                        $opencart->log->write('Pay :: 3S: ');
                                        $opencart->model_checkout_order->addOrderHistory($order_id, $order_status_id, '', true);
                                        $opencart->log->write('Pay :: 3E: ');
                                }
                                $opencart->cache->set($cache_key, 'success');
                                $opencart->cache->delete('prepay_order_'.$order_id);
                                $opencart->cart->removeByOrderId($order_id);
                                //return TRUE;
                  }
                  return FALSE;
        }

}