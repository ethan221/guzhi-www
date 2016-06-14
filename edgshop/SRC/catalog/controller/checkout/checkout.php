<?php
class ControllerCheckoutCheckout extends EdgController {
	public function index() {
                                    parent::logincheck();
		// Validate cart has products and has stock.
		//if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
                                    if (($this->request->server['REQUEST_METHOD'] != 'POST') || (!$this->cart->hasProducts() && empty($this->session->data['vouchers']))) {
			$this->response->redirect($this->url->link('checkout/cart'));
		}
		
		//判断是否微信访问，是否获得了微信openid
		$this->load->helper('mobile');
		
		unset($this->session->data['redirect']);
		
		//如果是微信浏览器，并且不存在微信openid，则转去获取微信openid获取程序
		if((is_weixin()) && (!isset($this->session->data['weixin_openid']))) {
			
			
			$this->session->data['redirect'] = HTTPS_SERVER . 'index.php?route=checkout/checkout';
			
			header('Location: ' . HTTPS_SERVER.'system/weixin/get_weixin_openid.php');
			//exit();
				
		}
                
                                    $cart_list = array();
                                    if (isset($this->request->post)){
                                            $cartid_items = $this->request->post['cartid'];
                                            $quantity_items = $this->request->post['quantity'];
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
                                            $this->response->redirect($this->url->link('checkout/cart'));
                                    }

                                    $this->load->model('tool/image');
                                    $this->load->model('tool/upload');

                                    $product_ids = array();

                                    foreach ($products as $product) {
                                                $product_total = 0;
                                                $product_ids[] = $product['product_id'];
                                                if(isset($cart_list[$product['cart_id']])){
                                                        $product['quantity'] = $cart_list[$product['cart_id']];
                                                }

                                                foreach ($products as $product_2) {
                                                        if ($product_2['product_id'] == $product['product_id']) {
                                                                $product_total += $product_2['quantity'];
                                                        }
                                                }

                                                if ($product['minimum'] > $product_total) {
                                                        $data['error_warning'] = sprintf($this->language->get('error_minimum'), $product['name'], $product['minimum']);
                                                }

                                                if ($product['image']) {
                                                        $image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                                                } else {
                                                        $image = '';
                                                }

                                                $option_data = array();

                                                foreach ($product['option'] as $option) {
                                                        if ($option['type'] != 'file') {
                                                                $value = $option['value'];
                                                        }

                                                        $option_data[] = array(
                                                                'name'  => $option['name'],
                                                                'value' => (utf8_strlen($value) > 20 ? utf8_substr($value, 0, 20) . '..' : $value)
                                                        );
                                                }

                                                // Display prices
                                                if (!$this->config->get('config_customer_price')) {
                                                        $price = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency'], '', true, false);
                                                } else {
                                                        $price = false;
                                                }

                                                // Display prices
                                                if (!$this->config->get('config_customer_price')) {
                                                        $total = $this->currency->format($this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'], $this->session->data['currency'], '', true, false);
                                                } else {
                                                        $total = false;
                                                }

                                                $recurring = '';

                                                if ($product['recurring']) {
                                                        $frequencies = array(
                                                                'day'        => $this->language->get('text_day'),
                                                                'week'       => $this->language->get('text_week'),
                                                                'semi_month' => $this->language->get('text_semi_month'),
                                                                'month'      => $this->language->get('text_month'),
                                                                'year'       => $this->language->get('text_year'),
                                                        );

                                                        if ($product['recurring']['trial']) {
                                                                $recurring = sprintf($this->language->get('text_trial_description'), $this->currency->format($this->tax->calculate($product['recurring']['trial_price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['trial_cycle'], $frequencies[$product['recurring']['trial_frequency']], $product['recurring']['trial_duration']) . ' ';
                                                        }

                                                        if ($product['recurring']['duration']) {
                                                                $recurring .= sprintf($this->language->get('text_payment_description'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                                                        } else {
                                                                $recurring .= sprintf($this->language->get('text_payment_cancel'), $this->currency->format($this->tax->calculate($product['recurring']['price'] * $product['quantity'], $product['tax_class_id'], $this->config->get('config_tax')), $this->session->data['currency']), $product['recurring']['cycle'], $frequencies[$product['recurring']['frequency']], $product['recurring']['duration']);
                                                        }
                                                }

                                                $data['products'][] = array(
                                                        'cart_id'   => $product['cart_id'],
                                                        'product_id' => $product['product_id'],
                                                        'thumb'     => $image,
                                                        'name'      => $product['name'],
                                                        'model'     => $product['model'],
                                                        'option'    => $option_data,
                                                        'recurring' => $recurring,
                                                        'quantity'  => $product['quantity'],
                                                        'stock'     => $product['stock'] ? true : !(!$this->config->get('config_stock_checkout') || $this->config->get('config_stock_warning')),
                                                        'reward'    => ($product['reward'] ? sprintf($this->language->get('text_points'), $product['reward']) : ''),
                                                        'price'     => $price,
                                                        'total'     => $total,
                                                        'href'      => $this->url->seolink($product['sku_id'])
                                                );
                                    }
                                    
                                    $coupon_list = $this->cart->getUsableCouponByProductIds($product_ids);
                                    $data['coupon_data'] = $coupon_list;
//print_r($coupon_list);

		$this->load->language('checkout/checkout');

		$this->document->setTitle($this->language->get('heading_title'));

                                    $this->document->addStyle(THEME_PATH.'css/city.css');

		// Required by klarna
		if ($this->config->get('klarna_account') || $this->config->get('klarna_invoice')) {
			$this->document->addScript('http://cdn.klarna.com/public/kitt/toc/v1.0/js/klarna.terms.min.js');
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_checkout_option'] = sprintf($this->language->get('text_checkout_option'), 1);
		$data['text_checkout_account'] = sprintf($this->language->get('text_checkout_account'), 2);
		$data['text_checkout_payment_address'] = sprintf($this->language->get('text_checkout_payment_address'), 2);
		$data['text_checkout_shipping_address'] = sprintf($this->language->get('text_checkout_shipping_address'), 3);
		$data['text_checkout_shipping_method'] = sprintf($this->language->get('text_checkout_shipping_method'), 4);
		
		if ($this->cart->hasShipping()) {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 5);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 6);
		} else {
			$data['text_checkout_payment_method'] = sprintf($this->language->get('text_checkout_payment_method'), 3);
			$data['text_checkout_confirm'] = sprintf($this->language->get('text_checkout_confirm'), 4);	
		}

		if (isset($this->session->data['error'])) {
			$data['error_warning'] = $this->session->data['error'];
			unset($this->session->data['error']);
		} else {
			$data['error_warning'] = '';
		}

		$data['logged'] = $this->customer->isLogged();

		if (isset($this->session->data['account'])) {
			$data['account'] = $this->session->data['account'];
		} else {
			$data['account'] = '';
		}

		$data['shipping_required'] = $this->cart->hasShipping();
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('checkout/checkout', $data));
	}

	public function country() {
		$json = array();

		$this->load->model('localisation/country');

		$country_info = $this->model_localisation_country->getCountry($this->request->get['country_id']);

		if ($country_info) {
			$this->load->model('localisation/zone');

			$json = array(
				'country_id'        => $country_info['country_id'],
				'name'              => $country_info['name'],
				'iso_code_2'        => $country_info['iso_code_2'],
				'iso_code_3'        => $country_info['iso_code_3'],
				'address_format'    => $country_info['address_format'],
				'postcode_required' => $country_info['postcode_required'],
				'zone'              => $this->model_localisation_zone->getZonesByCountryId($this->request->get['country_id']),
				'status'            => $country_info['status']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function customfield() {
		$json = array();

		$this->load->model('account/custom_field');

		// Customer Group
		if (isset($this->request->get['customer_group_id']) && is_array($this->config->get('config_customer_group_display')) && in_array($this->request->get['customer_group_id'], $this->config->get('config_customer_group_display'))) {
			$customer_group_id = $this->request->get['customer_group_id'];
		} else {
			$customer_group_id = $this->config->get('config_customer_group_id');
		}

		$custom_fields = $this->model_account_custom_field->getCustomFields($customer_group_id);

		foreach ($custom_fields as $custom_field) {
			$json[] = array(
				'custom_field_id' => $custom_field['custom_field_id'],
				'required'        => $custom_field['required']
			);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
        
                  
}
