<?php
class ControllerCheckoutShippingMethod extends Controller {
	public function get_shippings() {
                                    $json = array();
		$this->load->language('checkout/checkout');
                                    $post_data = $this->request->post;
                                    if (isset($post_data['cartid']) && isset($post_data['quantity'])){
                                            //$post_data = array('cartid' => array('62'), 'quantity' => array('62' => 1));
                                            //$shipping_address = array( 'country_id' => 44, 'zone_id' => 685);
                                            $this->load->model('account/address');
                                            $shipping_address = $this->model_account_address->getAddress($post_data['address_id']);
                                            $cartid_items = $post_data['cartid'];
                                            $quantity_items = $post_data['quantity'];
                                            $cart_ids = array();
                                            foreach ($cartid_items as $cart_id){
                                                    if((int)$quantity_items[$cart_id]>0){
                                                        $cart_ids[] = $cart_id;
                                                    }
                                            }
                                            $products = $this->cart->getProducts($cart_ids);
                                    }
		if (!empty($shipping_address) && !empty($products)) {
                                                      $this->load->model('checkout/shipping');
                                                      $method_data = $this->model_checkout_shipping->getShippings($shipping_address, $products);
			$sort_order = array();
			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			array_multisort($sort_order, SORT_ASC, $method_data);
			$this->session->data['shipping_methods'] = $method_data;
		}
		$data['text_shipping_method'] = $this->language->get('text_shipping_method');
		$data['text_comments'] = $this->language->get('text_comments');
		$data['text_loading'] = $this->language->get('text_loading');
		$data['button_continue'] = $this->language->get('button_continue');
		if (empty($this->session->data['shipping_methods'])) {
			$data['error_warning'] = sprintf($this->language->get('error_no_shipping'), $this->url->link('information/contact'));
		} else {
			$data['error_warning'] = '';
		}

		if (isset($this->session->data['shipping_methods'])) {
			$data['shipping_methods'] = $this->session->data['shipping_methods'];
		} else {
			$data['shipping_methods'] = array();
		}

		if (isset($this->session->data['shipping_method']['code'])) {
			$data['code'] = $this->session->data['shipping_method']['code'];
		} else {
			$data['code'] = '';
		}

		if (isset($this->session->data['comment'])) {
			$data['comment'] = $this->session->data['comment'];
		} else {
			$data['comment'] = '';
		}
                                    $json['html'] = $this->load->view('checkout/shipping_method', $data);
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}

	public function save() {
		$this->load->language('checkout/checkout');

		$json = array();

		// Validate if shipping is required. If not the customer should not have reached this page.
		if (!$this->cart->hasShipping()) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
		}

		// Validate if shipping address has been set.
		if (!isset($this->session->data['shipping_address'])) {
			$json['redirect'] = $this->url->link('checkout/checkout', '', true);
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

		if (!isset($this->request->post['shipping_method'])) {
			$json['error']['warning'] = $this->language->get('error_shipping');
		} else {
			$shipping = explode('.', $this->request->post['shipping_method']);

			if (!isset($shipping[0]) || !isset($shipping[1]) || !isset($this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]])) {
				$json['error']['warning'] = $this->language->get('error_shipping');
			}
		}

		if (!$json) {
			$this->session->data['shipping_method'] = $this->session->data['shipping_methods'][$shipping[0]]['quote'][$shipping[1]];

			$this->session->data['comment'] = strip_tags($this->request->post['comment']);
		}

		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}