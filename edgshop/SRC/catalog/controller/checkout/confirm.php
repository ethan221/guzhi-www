<?php
class ControllerCheckoutConfirm extends EdgController {
	public function index() {
                                    $redirect = '';
                                    $json = array();
                                    $post_data = $this->request->post;
                                    $product_ids = array();
                                    $coupon_data = array();

                                    if(empty($post_data) || empty($post_data['address_id'])){
                                            return;
                                    }
		if ($this->cart->hasShipping()) {
			// Validate if shipping address has been set.
			if (!isset($post_data['address_id'])) {
				$redirect = $this->url->link('checkout');
			}
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers']))) {
			$redirect = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		//$products = $this->cart->getProducts();
                                    $cart_list = array();
                                    if (isset($post_data['cartid']) && isset($post_data['quantity'])){
                                            $cartid_items = $post_data['cartid'];
                                            $quantity_items = $post_data['quantity'];
                                            $cart_ids = array();
                                            foreach ($cartid_items as $cart_id){
                                                    if((int)$quantity_items[$cart_id]>0){
                                                        $cart_ids[] = $cart_id;
                                                        $cart_list[$cart_id] = (int)$quantity_items[$cart_id];
                                                    }
                                            }
                                            $products = $this->cart->getProducts($cart_ids);
                                    }
                                    if(empty($products)){
                                            $redirect = $this->url->link('checkout/cart', true);
                                    }
                                    $this->load->model('account/address');
                                    $address_data = $this->model_account_address->getAddress($post_data['address_id']);
                                    if(empty($address_data)){
                                            $redirect = $this->url->link('checkout/cart', true);
                                    }

		foreach ($products as &$product) {
			$product_total = 0;
                                                      if(isset($cart_list[$product['cart_id']])){
                                                                $product['quantity'] = $cart_list[$product['cart_id']];
                                                      }
			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$redirect = $this->url->link('checkout/cart');
				break;
			}

                                                      $product_ids[] = $product['product_id'];
		}
                                    unset($product);

                                    if (!$redirect) {
                                                //coupon
                                                if(isset($this->request->post['cc_couponid'])){
                                                            $useablecoupon = $this->cart->getUsableCouponByProductIds($product_ids);
                                                            if($useablecoupon){
                                                                    $couponids = array_column($useablecoupon, 'customer_coupon_id');
                                                                    foreach($this->request->post['cc_couponid'] as $cc_coupon_id){
                                                                            if(!in_array($cc_coupon_id, $couponids)){
                                                                                    $json['error'] = '不可使用的优惠券';
                                                                                    break;
                                                                            }else{
                                                                                    foreach($useablecoupon as $_coupon){
                                                                                            if($_coupon['customer_coupon_id'] == $cc_coupon_id){
                                                                                                    $coupon_data[] = array(
                                                                                                        'customer_coupon_id' => $cc_coupon_id,
                                                                                                         'coupon_id' => $_coupon['coupon_id']
                                                                                                    );
                                                                                                    break;
                                                                                            }
                                                                                    }
                                                                            }
                                                                    }
                                                            }
                                                }
                                    }

		if (!$redirect && !isset($json['error'])) {
			$order_data = array();
			$this->load->language('checkout/checkout');
                                                      $order_data['coupon_data'] = $coupon_data;
			$order_data['invoice_prefix'] = $this->config->get('config_invoice_prefix');
			$order_data['store_id'] = $this->config->get('config_store_id');
			$order_data['store_name'] = $this->config->get('config_name');
                                                      $order_data['invoice'] = trim($post_data['invoice']);

			if ($order_data['store_id']) {
				$order_data['store_url'] = $this->config->get('config_url');
			} else {
				$order_data['store_url'] = HTTP_SERVER;
			}

                                                      $this->load->model('account/customer');

                                                      $customer_info = $this->model_account_customer->getCustomer($this->customer->getId());

                                                      $order_data['customer_id'] = $this->customer->getId();
                                                      $order_data['customer_group_id'] = $customer_info['customer_group_id'];
                                                      $order_data['fullname'] = $this->customer->getFullname();
                                                      $order_data['telephone'] = $customer_info['telephone'];
                                                      $order_data['custom_field'] = '';//json_decode($customer_info['custom_field']);

			$order_data['payment_fullname'] = $address_data['fullname'];
			$order_data['payment_address'] = $address_data['region'].$address_data['address'];
			$order_data['payment_city'] = $address_data['city'];
			$order_data['payment_postcode'] = $address_data['postcode'];
			$order_data['payment_zone'] = $address_data['zone'];
			$order_data['payment_zone_id'] = $address_data['zone_id'];
			$order_data['payment_country'] = $address_data['country'];
			$order_data['payment_country_id'] = $address_data['country_id'];
                                                      $order_data['payment_code'] = '';
                                                      $order_data['payment_method'] = '';
			$order_data['payment_address_format'] = '';//$this->session->data['payment_address']['address_format'];
			$order_data['payment_custom_field'] = (isset($this->session->data['payment_address']['custom_field']) ? $this->session->data['payment_address']['custom_field'] : array());

			$order_data['products'] = array();

			foreach ($products as $product) {
				$option_data = array();

				foreach ($product['option'] as $option) {
					$option_data[] = array(
						'product_option_id'       => $option['product_option_id'],
						'product_option_value_id' => $option['product_option_value_id'],
						'option_id'               => $option['option_id'],
						'option_value_id'         => $option['option_value_id'],
						'name'                    => $option['name'],
						'value'                   => $option['value'],
						'type'                    => $option['type']
					);
				}

				$order_data['products'][] = array(
					'product_id' => $product['product_id'],
                                                                                          'cart_id' => $product['cart_id'],
                                                                                          'sku_id'  => $product['sku_id'],
					'name'       => $product['name'],
					'model'      => $product['model'],
					'option'     => $option_data,
					'quantity'   => $product['quantity'],
					'subtract'   => $product['subtract'],
					'price'      => $product['price'],
					'total'      => $product['total'],
					'tax'        => $this->tax->getTax($product['price'], $product['tax_class_id']),
					'reward'     => $product['reward']
				);
			}

			// Gift Voucher
			$order_data['vouchers'] = array();

			if (!empty($this->session->data['vouchers'])) {
				foreach ($this->session->data['vouchers'] as $voucher) {
					$order_data['vouchers'][] = array(
						'description'      => $voucher['description'],
						'code'             => token(10),
						'to_name'          => $voucher['to_name'],
						'to_email'         => $voucher['to_email'],
						'from_name'        => $voucher['from_name'],
						'from_email'       => $voucher['from_email'],
						'voucher_theme_id' => $voucher['voucher_theme_id'],
						'message'          => $voucher['message'],
						'amount'           => $voucher['amount']
					);
				}
			}
                        
                                                      //shipping
                                                      $shipping_data = array();
                                                      $post_shipping_method = $post_data['shipping_method'];
                                                      $this->load->model('checkout/shipping');
                                                      $shipping_info = $this->model_checkout_shipping->getShippings($address_data, $products);
                                                      
                                                      if ($shipping_info) {
                                                                        $shipping_codes = explode('.', $post_shipping_method);
                                                                        $shipping_code = $shipping_codes[0];
                                                                        if(isset($shipping_info[$shipping_code])){
                                                                                foreach ($shipping_info[$shipping_code] as $quotes){
                                                                                        if(isset($quotes[$shipping_code])){
                                                                                                $quate = $quotes[$shipping_code];
                                                                                                $shipping_data['shipping_method'] = $quate['title'];
                                                                                                $shipping_data['shipping_code'] = $quate['code'];
                                                                                                $shipping_data['cost'] = $quate['cost'];
                                                                                                $shipping_data['tax_class_id'] = $quate['tax_class_id'];
                                                                                                break;
                                                                                        }
                                                                                }
                                                                        }
				$shipping_data['shipping_fullname'] = $address_data['fullname'];
				$shipping_data['shipping_address'] = $address_data['address'];
				$shipping_data['shipping_city'] = $address_data['city'];
				$shipping_data['shipping_postcode'] = $address_data['postcode'];
				$shipping_data['shipping_telephone'] = $address_data['shipping_telephone'];
				$shipping_data['shipping_zone'] = $address_data['zone'];
				$shipping_data['shipping_zone_id'] = $address_data['zone_id'];
                                                                        $shipping_data['shipping_region'] = $address_data['region'];
				$shipping_data['shipping_region_id'] = $address_data['region_id'];
				$shipping_data['shipping_country'] = $address_data['country'];
				$shipping_data['shipping_country_id'] = $address_data['country_id'];
				$shipping_data['shipping_address_format'] = '';///$this->session->data['shipping_address']['address_format'];
				$shipping_data['shipping_custom_field'] = (isset($this->session->data['shipping_address']['custom_field']) ? $this->session->data['shipping_address']['custom_field'] : array());
			}

                                                      if(!isset($shipping_data['shipping_code'])){
                                                              $json['error'] = '该订单配送费无效';
                                                      }

                                                      if(!isset($json['error'])){
                                                                $order_data['shipping'] = $shipping_data;
                                                                $order_data['cost'] = $shipping_data['cost'];

                                                                $totals = array();
                                                                $taxes = FALSE; //$this->cart->getTaxes();
                                                                $total = 0;

                                                                // Because __call can not keep var references so we put them into an array. 
                                                                $total_data = array(
                                                                        'totals' => &$totals,
                                                                        'taxes'  => &$taxes,
                                                                        'total'  => &$total
                                                                );


                                                                $this->load->model('extension/extension');

                                                                $sort_order = array();

                                                                $results = $this->model_extension_extension->getExtensions('total');

                                                                foreach ($results as $key => $value) {
                                                                        $sort_order[$key] = $this->config->get($value['code'] . '_sort_order');
                                                                }

                                                                array_multisort($sort_order, SORT_ASC, $results);

                                                                foreach ($results as $result) {
                                                                        if ($this->config->get($result['code'] . '_status')) {
                                                                                $this->load->model('total/' . $result['code']);
                                                                                $this->{'model_total_' . $result['code']}->getTotal($total_data, $order_data);
                                                                        }
                                                                }
                                                                $sort_order = array();
                                                                foreach ($totals as $key => $value) {
                                                                        $sort_order[$key] = $value['sort_order'];
                                                                }
                                                                array_multisort($sort_order, SORT_ASC, $totals);

                                                                $order_data['totals'] = $totals;

                                                                $order_data['comment'] = '';//$this->session->data['comment'];
                                                                $order_data['total'] = floatval($total_data['total']);

                                                                if (isset($this->request->cookie['tracking'])) {
                                                                        $order_data['tracking'] = $this->request->cookie['tracking'];
                                                                        $subtotal = $this->cart->getSubTotal();

                                                                        // Affiliate
                                                                        $this->load->model('affiliate/affiliate');

                                                                        $affiliate_info = $this->model_affiliate_affiliate->getAffiliateByCode($this->request->cookie['tracking']);
                                                                        if ($affiliate_info) {
                                                                                $order_data['affiliate_id'] = $affiliate_info['affiliate_id'];
                                                                                $order_data['commission'] = ($subtotal / 100) * $affiliate_info['commission'];
                                                                        } else {
                                                                                $order_data['affiliate_id'] = 0;
                                                                                $order_data['commission'] = 0;
                                                                        }

                                                                        // Marketing
                                                                        $this->load->model('checkout/marketing');
                                                                        $marketing_info = $this->model_checkout_marketing->getMarketingByCode($this->request->cookie['tracking']);
                                                                        if ($marketing_info) {
                                                                                $order_data['marketing_id'] = $marketing_info['marketing_id'];
                                                                        } else {
                                                                                $order_data['marketing_id'] = 0;
                                                                        }
                                                                } else {
                                                                        $order_data['affiliate_id'] = 0;
                                                                        $order_data['commission'] = 0;
                                                                        $order_data['marketing_id'] = 0;
                                                                        $order_data['tracking'] = '';
                                                                }

                                                                $order_data['language_id'] = $this->config->get('config_language_id');
                                                                $order_data['currency_id'] = $this->currency->getId($this->session->data['currency']);
                                                                $order_data['currency_code'] = $this->session->data['currency'];
                                                                $order_data['currency_value'] = $this->currency->getValue($this->session->data['currency']);
                                                                $order_data['ip'] = $this->request->server['REMOTE_ADDR'];

                                                                if (!empty($this->request->server['HTTP_X_FORWARDED_FOR'])) {
                                                                        $order_data['forwarded_ip'] = $this->request->server['HTTP_X_FORWARDED_FOR'];
                                                                } elseif (!empty($this->request->server['HTTP_CLIENT_IP'])) {
                                                                        $order_data['forwarded_ip'] = $this->request->server['HTTP_CLIENT_IP'];
                                                                } else {
                                                                        $order_data['forwarded_ip'] = '';
                                                                }

                                                                if (isset($this->request->server['HTTP_USER_AGENT'])) {
                                                                        $order_data['user_agent'] = $this->request->server['HTTP_USER_AGENT'];
                                                                } else {
                                                                        $order_data['user_agent'] = '';
                                                                }

                                                                if (isset($this->request->server['HTTP_ACCEPT_LANGUAGE'])) {
                                                                        $order_data['accept_language'] = $this->request->server['HTTP_ACCEPT_LANGUAGE'];
                                                                } else {
                                                                        $order_data['accept_language'] = '';
                                                                }
                                                                $this->load->model('checkout/order');
                                                                $order_id = $this->model_checkout_order->addOrder($order_data);
                                                                if($order_id>0){
                                                                        $json['order_id'] = $order_id;
                                                                        $this->cache->set('prepay_order_'.$order_id, $order_data, 7200);
                                                                }else{
                                                                        $json['error'] = '订单创建失败';
                                                                }
                                                      }
		} else {
			$json['redirect'] = $redirect;
		}

                                    $this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}
