<?php
class ModelCheckoutShipping extends Model {
	public function getShippings($shipping_address, $products){
                                    if ($shipping_address && $products) {
			// Shipping Methods
			$method_data = array();
			$this->load->model('extension/extension');
			$results = $this->model_extension_extension->getExtensions('shipping');
                                                      if ($this->config->get('free_status')) {
                                                                        $this->load->model('shipping/free');
                                                                        $quote = $this->{'model_shipping_free'}->getQuote($shipping_address, $products);
                                                                        if ($quote) {
                                                                                $method_data['free'] = array(
                                                                                        'title'      => $quote['title'],
                                                                                        'quote'      => $quote['quote'],
                                                                                        'sort_order' => $quote['sort_order'],
                                                                                        'error'      => $quote['error']
                                                                                );
                                                                        }
                                                      }
                                                      if(!$method_data){
                                                                        foreach ($results as $result) {
                                                                                if ($result['code'] != 'free' && $this->config->get($result['code'] . '_status')) {
                                                                                        $this->load->model('shipping/' . $result['code']);

                                                                                        $quote = $this->{'model_shipping_' . $result['code']}->getQuote($shipping_address, $products);

                                                                                        if ($quote) {
                                                                                                $method_data[$result['code']] = array(
                                                                                                        'title'      => $quote['title'],
                                                                                                        'quote'      => $quote['quote'],
                                                                                                        'sort_order' => $quote['sort_order'],
                                                                                                        'error'      => $quote['error']
                                                                                                );
                                                                                        }
                                                                                }
                                                                        }
                                                      }
			$sort_order = array();

			foreach ($method_data as $key => $value) {
				$sort_order[$key] = $value['sort_order'];
			}
			array_multisort($sort_order, SORT_ASC, $method_data);
			return $method_data;
		}
                  }
}
