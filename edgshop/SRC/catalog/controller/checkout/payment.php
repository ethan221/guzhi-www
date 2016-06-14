<?php
class ControllerCheckoutPayment extends EdgController {
	public function index() {
                                $this->document->setTitle('订单支付');
                                $order_id = $this->request->get['orderid'];
                                $order_data = array();
                                if($order_id>0){
                                        $order_cache_data = $this->cache->get('prepay_order_'.$order_id);
                                        if(empty($order_cache_data)){
                                                $this->response->redirect($this->url->link('checkout/cart', true));
                                        }
 //                                       print_r($order_cache_data);
                                        $this->load->model('checkout/order');
                                        $order_data = $this->model_checkout_order->getOrder($order_id);
                                        if($order_data && !$order_data['order_status_id']){
                                                $order_data['address'] = $order_data['shipping_zone'].'，'.$order_data['shipping_city'].'，'.$order_data['shipping_region'].$order_data['shipping_address'];
                                                $order_data['time_expire'] = date('Y-m-d H:i:s', strtotime($order_data['date_added']) + 3600*2);
                                                $data['order_data'] = $order_data;
                                        }else{
                                                $this->response->redirect($this->url->link('checkout/cart', true));
                                        }
                                        //print_r($order_data);
                                        $total = $order_cache_data['totals'];
                                        $address = array();
                                        $address['country_id'] = '44';
                                        $address['zone_id'] = $order_data['shipping_zone_id'];

                                        // Payment Methods
                                        $method_data = array();

                                        $this->load->model('extension/extension');

                                        $results = $this->model_extension_extension->getExtensions('payment');

                                        $recurring = $this->cart->hasRecurringProducts();

                                        foreach ($results as $result) {
                                                if ($this->config->get($result['code'] . '_status')) {
                                                        $this->load->model('payment/' . $result['code']);

                                                        $method = $this->{'model_payment_' . $result['code']}->getMethod($address, $total);

                                                        if ($method) {
                                                                if ($recurring) {
                                                                        if (property_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_payment_' . $result['code']}->recurringPayments()) {
                                                                                $method_data[$result['code']] = $method;
                                                                        }
                                                                } else {
                                                                        $method_data[$result['code']] = $method;
                                                                }
                                                        }
                                                }
                                        }

                                        $sort_order = array();

                                        foreach ($method_data as $key => $value) {
                                                $sort_order[$key] = $value['sort_order'];
                                        }

                                        array_multisort($sort_order, SORT_ASC, $method_data);
                                        
                                        $data['payment_methods'] = $method_data;
                                }
 
                                $data['footer'] = $this->load->controller('common/footer');
                                $data['header'] = $this->load->controller('common/header');

                                $this->response->setOutput($this->load->view('checkout/payment', $data));
	}
        
                  public function pay(){
                                $order_id = $this->request->get['orderid'];
                                $order_data = array();
                                if($order_id>0){
                                        $order_cache_data = $this->cache->get('prepay_order_'.$order_id);
                                        if(empty($order_cache_data)){
                                                echo "不可支付的定单";
                                                exit();
                                        }
 //                                       print_r($order_cache_data);
                                        $this->load->model('checkout/order');
                                        $order_data = $this->model_checkout_order->getOrder($order_id);
                                        if($order_data){
                                                $order_data['address'] = $order_data['shipping_zone'].'，'.$order_data['shipping_city'].'，'.$order_data['shipping_region'].$order_data['shipping_address'];
                                                $data['order_data'] = $order_data;
                                        }
                                        //print_r($order_data);
                                        $total = $order_cache_data['totals'];
                                        $address = array();
                                        $address['country_id'] = '44';
                                        $address['zone_id'] = $order_data['shipping_zone_id'];
                                        
                                        // Payment Methods
                                        $method_data = array();

                                        $this->load->model('extension/extension');

                                        $results = $this->model_extension_extension->getExtensions('payment');

                                        $recurring = $this->cart->hasRecurringProducts();

                                        foreach ($results as $result) {
                                                if ($this->config->get($result['code'] . '_status')) {
                                                        $this->load->model('payment/' . $result['code']);

                                                        $method = $this->{'model_payment_' . $result['code']}->getMethod($address, $total);

                                                        if ($method) {
                                                                if ($recurring) {
                                                                        if (property_exists($this->{'model_payment_' . $result['code']}, 'recurringPayments') && $this->{'model_payment_' . $result['code']}->recurringPayments()) {
                                                                                $method_data[$result['code']] = $method;
                                                                        }
                                                                } else {
                                                                        $method_data[$result['code']] = $method;
                                                                }
                                                        }
                                                }
                                        }

                                }
                  } 
}
