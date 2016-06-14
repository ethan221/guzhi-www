<?php
class ControllerCheckoutShippingAddress extends EdgController {
	public function index() {
		$this->load->language('checkout/checkout');

		$data['text_address_existing'] = $this->language->get('text_address_existing');
		$data['text_address_new'] = $this->language->get('text_address_new');
		$data['text_select'] = $this->language->get('text_select');
		$data['text_none'] = $this->language->get('text_none');
		$data['text_loading'] = $this->language->get('text_loading');

		$data['entry_fullname'] = $this->language->get('entry_fullname');
		$data['entry_company'] = $this->language->get('entry_company');
		$data['entry_address'] = $this->language->get('entry_address');
		$data['entry_postcode'] = $this->language->get('entry_postcode');
		$data['entry_city'] = $this->language->get('entry_city');
		$data['entry_country'] = $this->language->get('entry_country');
		$data['entry_zone'] = $this->language->get('entry_zone');
		$data['entry_shipping_telephone'] = $this->language->get('entry_shipping_telephone');

		$data['button_continue'] = $this->language->get('button_continue');
		$data['button_upload'] = $this->language->get('button_upload');

		if (isset($this->session->data['shipping_address']['address_id'])) {
			$data['address_id'] = $this->session->data['shipping_address']['address_id'];
		} else {
			$data['address_id'] = $this->customer->getAddressId();
		}

		$this->load->model('account/address');

                                    $limit = 5;
                                    if(isset($this->request->get['type']) && 'all' == $this->request->get['type']){
                                            $limit = 10;
                                    }
		$address_data = $this->model_account_address->getAddresses($limit);
                                    if(!empty($address_data)){
                                                foreach ($address_data as $key => $row) {
                                                        $tmp[$key] = $row['address_id'] == $data['address_id'];
                                                } 
                                                array_multisort($tmp, SORT_DESC, $address_data);
                                    }
                                    $data['addresses'] = $address_data;

		// Custom Fields
		//$this->load->model('account/custom_field');

		//$data['custom_fields'] = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

		if (isset($this->session->data['shipping_address']['custom_field'])) {
			$data['shipping_address_custom_field'] = $this->session->data['shipping_address']['custom_field'];
		} else {
			$data['shipping_address_custom_field'] = array();
		}

		$this->response->setOutput($this->load->view('checkout/shipping_address', $data));
	}

	public function save() {
                                parent::logincheck(true);
                                $this->load->language('checkout/checkout');
                                $json = array();
                                if ((utf8_strlen(trim($this->request->post['fullname'])) < 2) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
                                        $json['error']['fullname'] = $this->language->get('error_fullname');
                                }
                                if (!Utils::validate($this->request->post['shipping_telephone'], 'phone')) {
                                        $json['error']['shipping_telephone'] = '收货人电话无效';
                                }
                                if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
                                        $json['error']['address'] = $this->language->get('error_address');
                                }
                                 if (!isset($this->request->post['city']) || $this->request->post['city'] == '' || !is_numeric($this->request->post['city'])) {
                                        $json['error']['city'] = $this->language->get('error_city');
                                }
                                if (!isset($this->request->post['region']) || $this->request->post['region'] == '' || !is_numeric($this->request->post['region'])) {
                                        $json['error']['region'] = '请选择所在地区';
                                }
                                if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
                                        $json['error']['zone'] = $this->language->get('error_zone');
                                }
                                // Default Shipping Address
                                $this->load->model('account/address');
                                $address_id = $this->model_account_address->addAddress($this->request->post);
                                $this->load->model('account/activity');
                                $activity_data = array(
                                        'customer_id' => $this->customer->getId(),
                                        'name'        => $this->customer->getFullName()
                                );
                                $this->model_account_activity->addActivity('address_add', $activity_data);
                                $this->response->addHeader('Content-Type: application/json');
                                $this->response->setOutput(json_encode($json));
	}
        
        	public function edit() {
                                parent::logincheck(true);
                                $this->load->language('checkout/checkout');
                                $json = array();
                                $address_id = $this->request->post['addressid'];
                                if($address_id>0){
                                        if ((utf8_strlen(trim($this->request->post['fullname'])) < 2) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
                                                $json['error']['fullname'] = $this->language->get('error_fullname');
                                        }
                                        if (!Utils::validate($this->request->post['shipping_telephone'], 'phone')) {
                                                $json['error']['shipping_telephone'] = '收货人电话无效';
                                        }
                                        if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
                                                $json['error']['address'] = $this->language->get('error_address');
                                        }
                                         if (!isset($this->request->post['city']) || $this->request->post['city'] == '' || !is_numeric($this->request->post['city'])) {
                                                $json['error']['city'] = $this->language->get('error_city');
                                        }
                                        if (!isset($this->request->post['region']) || $this->request->post['region'] == '' || !is_numeric($this->request->post['region'])) {
                                                $json['error']['region'] = '请选择所在地区';
                                        }
                                        if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
                                                $json['error']['zone'] = $this->language->get('error_zone');
                                        }
                                        // Default Shipping Address
                                        $this->load->model('account/address');
                                        $address_id = $this->model_account_address->editAddress($address_id, $this->request->post);
                                }
                                $this->response->addHeader('Content-Type: application/json');
                                $this->response->setOutput(json_encode($json));
	}
        
        
        
                        public function delete(){
                                parent::logincheck(true);
                                $this->load->language('checkout/checkout');
                                $json = array();
                                $address_id = $this->request->post['addressid'];
                                if($address_id>0){
                                         $this->load->model('account/address');
                                         $result = $this->model_account_address->deleteAddress($address_id);
                                         if($result){
                                                 $json['success'] = true;
                                         }
                                }
                                $this->response->addHeader('Content-Type: application/json');
                                $this->response->setOutput(json_encode($json));
                        }
                        
                        public function setdefault(){
                                parent::logincheck(true);
                                $this->load->language('checkout/checkout');
                                $json = array();
                                $address_id = $this->request->post['addressid'];
                                if($address_id>0){
                                         $this->load->model('account/address');
                                         $result = $this->model_account_address->setdefaultAddress($address_id);
                                         if($result){
                                                 $this->session->data['shipping_address']['address_id'] = $address_id;
                                                 $json['success'] = true;
                                         }
                                }
                                $this->response->addHeader('Content-Type: application/json');
                                $this->response->setOutput(json_encode($json));
                        }






                        public function save_bak() {
                                    parent::logincheck(true);
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout', '', true);
		}

		// Validate cart has products and has stock.
		if ((!$this->cart->hasProducts() && empty($this->session->data['vouchers'])) || (!$this->cart->hasStock() && !$this->config->get('config_stock_checkout'))) {
			$json['redirect'] = $this->url->link('checkout/cart');
		}

		// Validate minimum quantity requirements.
		$products = $this->cart->getProducts();

		foreach ($products as $product) {
			$product_total = 0;

			foreach ($products as $product_2) {
				if ($product_2['product_id'] == $product['product_id']) {
					$product_total += $product_2['quantity'];
				}
			}

			if ($product['minimum'] > $product_total) {
				$json['redirect'] = $this->url->link('checkout/cart');

				break;
			}
		}

		if (!$json) {
			if (isset($this->request->post['shipping_address']) && $this->request->post['shipping_address'] == 'existing') {
				$this->load->model('account/address');

				if (empty($this->request->post['address_id'])) {
					$json['error']['warning'] = $this->language->get('error_address');
				} elseif (!in_array($this->request->post['address_id'], array_keys($this->model_account_address->getAddresses()))) {
					$json['error']['warning'] = $this->language->get('error_address');
				}

				if (!$json) {
					// Default Shipping Address
					$this->load->model('account/address');

					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($this->request->post['address_id']);

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);
				}
			} else {
				if ((utf8_strlen(trim($this->request->post['fullname'])) < 2) || (utf8_strlen(trim($this->request->post['fullname'])) > 32)) {
					$json['error']['fullname'] = $this->language->get('error_fullname');
				}
				
				if ((utf8_strlen($this->request->post['shipping_telephone']) < 3) || (utf8_strlen($this->request->post['shipping_telephone']) > 32)) {
					$json['error']['shipping_telephone'] = $this->language->get('error_shipping_telephone');
				}

				if ((utf8_strlen(trim($this->request->post['address'])) < 3) || (utf8_strlen(trim($this->request->post['address'])) > 128)) {
					$json['error']['address'] = $this->language->get('error_address');
				}

				if ((utf8_strlen(trim($this->request->post['city'])) < 2) || (utf8_strlen(trim($this->request->post['city'])) > 128)) {
					$json['error']['city'] = $this->language->get('error_city');
				}
				
				$this->load->model('localisation/country');

				$country_info = $this->model_localisation_country->getCountry($this->request->post['country_id']);

				if ($country_info && $country_info['postcode_required'] && (utf8_strlen(trim($this->request->post['postcode'])) < 2 || utf8_strlen(trim($this->request->post['postcode'])) > 10)) {
					$json['error']['postcode'] = $this->language->get('error_postcode');
				}

				if ($this->request->post['country_id'] == '') {
					$json['error']['country'] = $this->language->get('error_country');
				}

				if (!isset($this->request->post['zone_id']) || $this->request->post['zone_id'] == '' || !is_numeric($this->request->post['zone_id'])) {
					$json['error']['zone'] = $this->language->get('error_zone');
				}

				// Custom field validation
				$this->load->model('account/custom_field');

				$custom_fields = $this->model_account_custom_field->getCustomFields($this->config->get('config_customer_group_id'));

				foreach ($custom_fields as $custom_field) {
					if (($custom_field['location'] == 'address') && $custom_field['required'] && empty($this->request->post['custom_field'][$custom_field['custom_field_id']])) {
						$json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field'), $custom_field['name']);
					} elseif (($custom_field['type'] == 'text' && !empty($custom_field['validation']) && $custom_field['location'] == 'address') && !filter_var($this->request->post['custom_field'][$custom_field['custom_field_id']], FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => $custom_field['validation'])))) {
                        $json['error']['custom_field' . $custom_field['custom_field_id']] = sprintf($this->language->get('error_custom_field_validate'), $custom_field['name']);
                    }
				}

				if (!$json) {
					// Default Shipping Address
					$this->load->model('account/address');

					$address_id = $this->model_account_address->addAddress($this->request->post);

					$this->session->data['shipping_address'] = $this->model_account_address->getAddress($address_id);

					unset($this->session->data['shipping_method']);
					unset($this->session->data['shipping_methods']);

					$this->load->model('account/activity');

					$activity_data = array(
						'customer_id' => $this->customer->getId(),
						'name'        => $this->customer->getFullName()
					);

					$this->model_account_activity->addActivity('address_add', $activity_data);
				}
			}
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}