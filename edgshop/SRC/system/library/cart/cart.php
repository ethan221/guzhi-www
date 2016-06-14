<?php
namespace Cart;
class Cart {
	private $data = array();

	public function __construct($registry) {
		$this->config = $registry->get('config');
		$this->customer = $registry->get('customer');
		$this->session = $registry->get('session');
		$this->db = $registry->get('db');
		$this->tax = $registry->get('tax');
		$this->weight = $registry->get('weight');
                                    $this->cache = $registry->get('cache');

		// Remove all the expired carts with no customer ID
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE customer_id = '0' AND date_added < DATE_SUB(NOW(), INTERVAL 1 HOUR)");

		if ($this->customer->getId()) {
			// We want to change the session ID on all the old items in the customers cart
			$this->db->query("UPDATE " . DB_PREFIX . "cart SET session_id = '" . $this->db->escape($this->session->getId()) . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");

			// Once the customer is logged in we want to update the customer ID on all items he has
			$cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE customer_id = '0' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");

			foreach ($cart_query->rows as $cart) {
				$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart['cart_id'] . "'");

				// The advantage of using $this->add is that it will check if the products already exist and increaser the quantity if necessary.
				$this->add($cart['product_id'], $cart['quantity'], json_decode($cart['option']), $cart['recurring_id']);
			}
		}
	}

	public function getProducts($cartids =array()) {
		$product_data = array();

                                    if(!empty($cartids)){
                                            $whereand = " AND cart_id IN('".implode('\',\'', $cartids)."')";
                                            $cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE customer_id = '" . (int)$this->customer->getId() ."' ". $whereand);
                                    }else{
                                            $cart_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "cart WHERE customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
                                    }
		foreach ($cart_query->rows as $cart) {
			$stock = true;

			$product_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_store p2s LEFT JOIN " . DB_PREFIX . "product p ON (p2s.product_id = p.product_id) LEFT JOIN " . DB_PREFIX . "product_description pd ON (p.product_id = pd.product_id) WHERE p2s.store_id = '" . (int)$this->config->get('config_store_id') . "' AND p2s.product_id = '" . (int)$cart['product_id'] . "' AND pd.language_id = '" . (int)$this->config->get('config_language_id') . "' AND p.date_available <= NOW() AND p.status = '1'");

			if ($product_query->num_rows && ($cart['quantity'] > 0)) {
				$option_price = 0;
				$option_points = 0;
				$option_weight = 0;

				$option_data = array();
                                                                        $cart_option = json_decode($cart['option']);
                                                                        if($cart_option){
                                                                                foreach ($cart_option as $product_option_id => $value) {
                                                                                        $option_query = $this->db->query("SELECT po.product_option_id, po.option_id, od.name, o.type FROM " . DB_PREFIX . "product_option po LEFT JOIN `" . DB_PREFIX . "option` o ON (po.option_id = o.option_id) LEFT JOIN " . DB_PREFIX . "option_description od ON (o.option_id = od.option_id) WHERE po.product_option_id = '" . (int)$product_option_id . "' AND po.product_id = '" . (int)$cart['product_id'] . "' AND od.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                                                                                        if ($option_query->num_rows) {
                                                                                                if ($option_query->row['type'] == 'select' || $option_query->row['type'] == 'radio' || $option_query->row['type'] == 'image') {
                                                                                                        if($option_query->row['type'] == 'image'){
                                                                                                                        $option_value_query = $this->db->query("SELECT pov.option_value_id, pov.option_value_text, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "'");
                                                                                                        }else{	
                                                                                                                        $option_value_query = $this->db->query("SELECT pov.option_value_id, pov.option_value_text, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$value . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
                                                                                                        }
                                                                                                        if ($option_value_query->num_rows) {
                                                                                                                if ($option_value_query->row['price_prefix'] == '+') {
                                                                                                                        $option_price += $option_value_query->row['price'];
                                                                                                                } elseif ($option_value_query->row['price_prefix'] == '-') {
                                                                                                                        $option_price -= $option_value_query->row['price'];
                                                                                                                }

                                                                                                                if ($option_value_query->row['points_prefix'] == '+') {
                                                                                                                        $option_points += $option_value_query->row['points'];
                                                                                                                } elseif ($option_value_query->row['points_prefix'] == '-') {
                                                                                                                        $option_points -= $option_value_query->row['points'];
                                                                                                                }

                                                                                                                if ($option_value_query->row['weight_prefix'] == '+') {
                                                                                                                        $option_weight += $option_value_query->row['weight'];
                                                                                                                } elseif ($option_value_query->row['weight_prefix'] == '-') {
                                                                                                                        $option_weight -= $option_value_query->row['weight'];
                                                                                                                }

                                                                                                                if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
                                                                                                                        $stock = false;
                                                                                                                }

                                                                                                                $option_data[] = array(
                                                                                                                        'product_option_id'       => $product_option_id,
                                                                                                                        'product_option_value_id' => $value,
                                                                                                                        'option_id'               => $option_query->row['option_id'],
                                                                                                                        'option_value_id'         => $option_value_query->row['option_value_id'],
                                                                                                                                                                                                                  'option_value_text'         => $option_value_query->row['option_value_text'],
                                                                                                                        'name'                    => $option_query->row['name'],
                                                                                                                        'value'                   => !empty($option_value_query->row['option_value_text'])?$option_value_query->row['option_value_text']:$option_value_query->row['name'],
                                                                                                                        'type'                    => $option_query->row['type'],
                                                                                                                        'quantity'                => $option_value_query->row['quantity'],
                                                                                                                        'subtract'                => $option_value_query->row['subtract'],
                                                                                                                        'price'                   => $option_value_query->row['price'],
                                                                                                                        'price_prefix'            => $option_value_query->row['price_prefix'],
                                                                                                                        'points'                  => $option_value_query->row['points'],
                                                                                                                        'points_prefix'           => $option_value_query->row['points_prefix'],
                                                                                                                        'weight'                  => $option_value_query->row['weight'],
                                                                                                                        'weight_prefix'           => $option_value_query->row['weight_prefix']
                                                                                                                );
                                                                                                        }
                                                                                                } elseif ($option_query->row['type'] == 'checkbox' && is_array($value)) {
                                                                                                        foreach ($value as $product_option_value_id) {
                                                                                                                $option_value_query = $this->db->query("SELECT pov.option_value_id, pov.option_value_text, ovd.name, pov.quantity, pov.subtract, pov.price, pov.price_prefix, pov.points, pov.points_prefix, pov.weight, pov.weight_prefix FROM " . DB_PREFIX . "product_option_value pov LEFT JOIN " . DB_PREFIX . "option_value ov ON (pov.option_value_id = ov.option_value_id) LEFT JOIN " . DB_PREFIX . "option_value_description ovd ON (ov.option_value_id = ovd.option_value_id) WHERE pov.product_option_value_id = '" . (int)$product_option_value_id . "' AND pov.product_option_id = '" . (int)$product_option_id . "' AND ovd.language_id = '" . (int)$this->config->get('config_language_id') . "'");

                                                                                                                if ($option_value_query->num_rows) {
                                                                                                                        if ($option_value_query->row['price_prefix'] == '+') {
                                                                                                                                $option_price += $option_value_query->row['price'];
                                                                                                                        } elseif ($option_value_query->row['price_prefix'] == '-') {
                                                                                                                                $option_price -= $option_value_query->row['price'];
                                                                                                                        }

                                                                                                                        if ($option_value_query->row['points_prefix'] == '+') {
                                                                                                                                $option_points += $option_value_query->row['points'];
                                                                                                                        } elseif ($option_value_query->row['points_prefix'] == '-') {
                                                                                                                                $option_points -= $option_value_query->row['points'];
                                                                                                                        }

                                                                                                                        if ($option_value_query->row['weight_prefix'] == '+') {
                                                                                                                                $option_weight += $option_value_query->row['weight'];
                                                                                                                        } elseif ($option_value_query->row['weight_prefix'] == '-') {
                                                                                                                                $option_weight -= $option_value_query->row['weight'];
                                                                                                                        }

                                                                                                                        if ($option_value_query->row['subtract'] && (!$option_value_query->row['quantity'] || ($option_value_query->row['quantity'] < $cart['quantity']))) {
                                                                                                                                $stock = false;
                                                                                                                        }

                                                                                                                        $option_data[] = array(
                                                                                                                                'product_option_id'       => $product_option_id,
                                                                                                                                'product_option_value_id' => $product_option_value_id,
                                                                                                                                'option_id'               => $option_query->row['option_id'],
                                                                                                                                'option_value_id'         => $option_value_query->row['option_value_id'],
                                                                                                                                                                                                                                    'option_value_text'         => $option_value_query->row['option_value_text'],
                                                                                                                                'name'                    => $option_query->row['name'],
                                                                                                                                'value'                   => $option_value_query->row['name'],
                                                                                                                                'type'                    => $option_query->row['type'],
                                                                                                                                'quantity'                => $option_value_query->row['quantity'],
                                                                                                                                'subtract'                => $option_value_query->row['subtract'],
                                                                                                                                'price'                   => $option_value_query->row['price'],
                                                                                                                                'price_prefix'            => $option_value_query->row['price_prefix'],
                                                                                                                                'points'                  => $option_value_query->row['points'],
                                                                                                                                'points_prefix'           => $option_value_query->row['points_prefix'],
                                                                                                                                'weight'                  => $option_value_query->row['weight'],
                                                                                                                                'weight_prefix'           => $option_value_query->row['weight_prefix']
                                                                                                                        );
                                                                                                                }
                                                                                                        }
                                                                                                } elseif ($option_query->row['type'] == 'text' || $option_query->row['type'] == 'textarea' || $option_query->row['type'] == 'file' || $option_query->row['type'] == 'date' || $option_query->row['type'] == 'datetime' || $option_query->row['type'] == 'time') {
                                                                                                        $option_data[] = array(
                                                                                                                'product_option_id'       => $product_option_id,
                                                                                                                'product_option_value_id' => '',
                                                                                                                'option_id'               => $option_query->row['option_id'],
                                                                                                                'option_value_id'         => '',
                                                                                                                'name'                    => $option_query->row['name'],
                                                                                                                'value'                   => $value,
                                                                                                                'type'                    => $option_query->row['type'],
                                                                                                                'quantity'                => '',
                                                                                                                'subtract'                => '',
                                                                                                                'price'                   => '',
                                                                                                                'price_prefix'            => '',
                                                                                                                'points'                  => '',
                                                                                                                'points_prefix'           => '',
                                                                                                                'weight'                  => '',
                                                                                                                'weight_prefix'           => ''
                                                                                                        );
                                                                                                }
                                                                                        }
                                                                                }
                                                                        }

				$price = $product_query->row['price'];

				// Product Discounts
				$discount_quantity = 0;

				foreach ($cart_query->rows as $cart_2) {
					if ($cart_2['product_id'] == $cart['product_id']) {
						$discount_quantity += $cart_2['quantity'];
					}
				}

				$product_discount_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_discount WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND quantity <= '" . (int)$discount_quantity . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY quantity DESC, priority ASC, price ASC LIMIT 1");

				if ($product_discount_query->num_rows) {
					$price = $product_discount_query->row['price'];
				}

				// Product Specials
				$product_special_query = $this->db->query("SELECT price FROM " . DB_PREFIX . "product_special WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "' AND ((date_start = '0000-00-00' OR date_start < NOW()) AND (date_end = '0000-00-00' OR date_end > NOW())) ORDER BY priority ASC, price ASC LIMIT 1");

				if ($product_special_query->num_rows) {
					$price = $product_special_query->row['price'];
				}

				// Reward Points
				$product_reward_query = $this->db->query("SELECT points FROM " . DB_PREFIX . "product_reward WHERE product_id = '" . (int)$cart['product_id'] . "' AND customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($product_reward_query->num_rows) {
					$reward = $product_reward_query->row['points'];
				} else {
					$reward = 0;
				}

				// Downloads
//				$download_data = array();
//
//				$download_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "product_to_download p2d LEFT JOIN " . DB_PREFIX . "download d ON (p2d.download_id = d.download_id) LEFT JOIN " . DB_PREFIX . "download_description dd ON (d.download_id = dd.download_id) WHERE p2d.product_id = '" . (int)$cart['product_id'] . "' AND dd.language_id = '" . (int)$this->config->get('config_language_id') . "'");
//
//				foreach ($download_query->rows as $download) {
//					$download_data[] = array(
//						'download_id' => $download['download_id'],
//						'name'        => $download['name'],
//						'filename'    => $download['filename'],
//						'mask'        => $download['mask']
//					);
//				}

				// Stock
				if (!$product_query->row['quantity'] || ($product_query->row['quantity'] < $cart['quantity'])) {
					$stock = false;
				}

				$recurring_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "recurring r LEFT JOIN " . DB_PREFIX . "product_recurring pr ON (r.recurring_id = pr.recurring_id) LEFT JOIN " . DB_PREFIX . "recurring_description rd ON (r.recurring_id = rd.recurring_id) WHERE r.recurring_id = '" . (int)$cart['recurring_id'] . "' AND pr.product_id = '" . (int)$cart['product_id'] . "' AND rd.language_id = " . (int)$this->config->get('config_language_id') . " AND r.status = 1 AND pr.customer_group_id = '" . (int)$this->config->get('config_customer_group_id') . "'");

				if ($recurring_query->num_rows) {
					$recurring = array(
						'recurring_id'    => $cart['recurring_id'],
						'name'            => $recurring_query->row['name'],
						'frequency'       => $recurring_query->row['frequency'],
						'price'           => $recurring_query->row['price'],
						'cycle'           => $recurring_query->row['cycle'],
						'duration'        => $recurring_query->row['duration'],
						'trial'           => $recurring_query->row['trial_status'],
						'trial_frequency' => $recurring_query->row['trial_frequency'],
						'trial_price'     => $recurring_query->row['trial_price'],
						'trial_cycle'     => $recurring_query->row['trial_cycle'],
						'trial_duration'  => $recurring_query->row['trial_duration']
					);
				} else {
					$recurring = false;
				}

				$product_data[] = array(
					'cart_id'         => $cart['cart_id'],
					'product_id'      => $product_query->row['product_id'],
					'name'            => $product_query->row['name'],
					'model'           => $product_query->row['model'],
					'shipping'        => $product_query->row['shipping'],
					'image'           => $product_query->row['image'],
					'option'          => $option_data,
					'quantity'        => $cart['quantity'],
					'minimum'         => $product_query->row['minimum'],
					'subtract'        => $product_query->row['subtract'],
					'stock'           => $stock,
					'price'           => ($price + $option_price),
					'total'           => ($price + $option_price) * $cart['quantity'],
					'reward'          => $reward * $cart['quantity'],
					'points'          => ($product_query->row['points'] ? ($product_query->row['points'] + $option_points) * $cart['quantity'] : 0),
					'tax_class_id'    => $product_query->row['tax_class_id'],
					'weight'          => ($product_query->row['weight'] + $option_weight) * $cart['quantity'],
					'weight_class_id' => $product_query->row['weight_class_id'],
					'length'          => $product_query->row['length'],
					'width'           => $product_query->row['width'],
					'height'          => $product_query->row['height'],
					'length_class_id' => $product_query->row['length_class_id'],
					'recurring'       => $recurring,
                                                                                          'sku_id'          => $cart['sku_id']
				);
			} else {
				$this->remove($cart['cart_id']);
			}
		}

		return $product_data;
	}

	public function add($sku_id, $product_id, $quantity = 1, $option = array(), $recurring_id = 0) {
                                    if((int)$this->customer->getId()>0){
                                                $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE customer_id = '" . (int)$this->customer->getId() . "' AND sku_id='". (int)$sku_id ."' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "'");
                                                if (!$query->row['total']) {
                                                        $this->db->query("INSERT " . DB_PREFIX . "cart SET customer_id = '" . $this->customer->getId() . "', session_id = '" . $this->db->escape($this->session->getId()) . "', sku_id='". (int)$sku_id ."', product_id = '" . (int)$product_id . "', recurring_id = '" . (int)$recurring_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
                                                } else {
                                                        $this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = (quantity + " . (int)$quantity . ") WHERE customer_id = '" . (int)$this->customer->getId() . "' AND sku_id='". $sku_id ."' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "'");
                                                }
                                    }else{
                                                $query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "cart WHERE customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND sku_id='". (int)$sku_id ."' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "'");

                                                if (!$query->row['total']) {
                                                        $this->db->query("INSERT " . DB_PREFIX . "cart SET customer_id = '" . (int)$this->customer->getId() . "', session_id = '" . $this->db->escape($this->session->getId()) . "', sku_id='". (int)$sku_id ."', product_id = '" . (int)$product_id . "', recurring_id = '" . (int)$recurring_id . "', `option` = '" . $this->db->escape(json_encode($option)) . "', quantity = '" . (int)$quantity . "', date_added = NOW()");
                                                } else {
                                                        $this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = (quantity + " . (int)$quantity . ") WHERE customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "' AND sku_id='". $sku_id ."' AND product_id = '" . (int)$product_id . "' AND recurring_id = '" . (int)$recurring_id . "'");
                                                }
                                    }
	}

	public function update($cart_id, $quantity) {
		$this->db->query("UPDATE " . DB_PREFIX . "cart SET quantity = '" . (int)$quantity . "' WHERE cart_id = '" . (int)$cart_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function remove($cart_id) {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id = '" . (int)$cart_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function clear() {
		$this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE customer_id = '" . (int)$this->customer->getId() . "' AND session_id = '" . $this->db->escape($this->session->getId()) . "'");
	}

	public function getRecurringProducts() {
		$product_data = array();

		foreach ($this->getProducts() as $value) {
			if ($value['recurring']) {
				$product_data[] = $value;
			}
		}

		return $product_data;
	}

	public function getWeight() {
		$weight = 0;

		foreach ($this->getProducts() as $product) {
			if ($product['shipping']) {
				$weight += $this->weight->convert($product['weight'], $product['weight_class_id'], $this->config->get('config_weight_class_id'));
			}
		}

		return $weight;
	}

	public function getSubTotal($products) {
		$total = 0;

		foreach ($products as $product) {
			$total += $product['total'];
		}

		return $total;
	}

	public function getTaxes() {
		$tax_data = array();

		foreach ($this->getProducts() as $product) {
			if ($product['tax_class_id']) {
				$tax_rates = $this->tax->getRates($product['price'], $product['tax_class_id']);

				foreach ($tax_rates as $tax_rate) {
					if (!isset($tax_data[$tax_rate['tax_rate_id']])) {
						$tax_data[$tax_rate['tax_rate_id']] = ($tax_rate['amount'] * $product['quantity']);
					} else {
						$tax_data[$tax_rate['tax_rate_id']] += ($tax_rate['amount'] * $product['quantity']);
					}
				}
			}
		}

		return $tax_data;
	}

	public function getTotal() {
		$total = 0;

		foreach ($this->getProducts() as $product) {
			$total += $this->tax->calculate($product['price'], $product['tax_class_id'], $this->config->get('config_tax')) * $product['quantity'];
		}

		return $total;
	}

	public function countProducts() {
		$product_total = 0;

		$products = $this->getProducts();

		foreach ($products as $product) {
			$product_total += $product['quantity'];
		}

		return $product_total;
	}

	public function hasProducts() {
		return count($this->getProducts());
	}

	public function hasRecurringProducts() {
		return count($this->getRecurringProducts());
	}

	public function hasStock() {
		foreach ($this->getProducts() as $product) {
			if (!$product['stock']) {
				return false;
			}
		}

		return true;
	}

	public function hasShipping() {
//		foreach ($this->getProducts() as $product) {
//			if ($product['shipping']) {
//				return true;
//			}
//		}
//
//		return false;
                                return true;
	}
        
                  public function getAllPrepayOrder(){
                                $order_query = $this->db->query( "SELECT * FROM `". DB_PREFIX ."order` WHERE  customer_id='". (int)$this->customer->getId() ."' AND date_added>'". date('Y-m-d H:i:s', time()-3600) ."'");
                                $cus_order = $order_query->rows;
                                if($cus_order){
                                            $order_ids = array_column($cus_order, 'order_id');
                                            $history_order_query = $this->db->query( "SELECT order_id FROM `". DB_PREFIX ."order_history` WHERE order_id IN ('". implode('\',\'', $order_ids) ."')");
                                            $history_order = $history_order_query->rows;
                                            foreach($cus_order as $key => $_order_id){
                                                    $history_order_ids = empty($history_order) ? NULL : array_column($history_order, 'order_id');
                                                    if($history_order_ids && in_array($_order_id, $history_order_ids)){
                                                            unset($cus_order[$key]);
                                                    }
                                            }
                                }
                                return $cus_order;
                  }

        
                 public function getUsableCouponByProductIds($product_ids = array()){
                         $cumtomcoupon_query = $this->db->query("SELECT cc.customer_coupon_id, cc.coupon_id FROM `". DB_PREFIX ."customer_coupon` cc LEFT JOIN `". DB_PREFIX ."coupon_product` cp ON cc.coupon_id=cp.coupon_id WHERE cp.product_id IN('". implode('\',\'', $product_ids)."') AND coupon_status='0'");
                         $customer_coupon = $cumtomcoupon_query->rows;
                         if(!empty($customer_coupon)){
                                            $unuse_cc_ids = array();
                                            //检查是否存在正在使用的优惠券
                                            $prepayOrders = $this->getAllPrepayOrder();
                                            foreach ($prepayOrders as $order){
                                                $prepay_order = $this->cache->get('prepay_order_'.$order['order_id']);
                                                if(!empty($prepay_order)){
                                                            foreach($prepay_order['totals'] as $totals){
                                                                    if($totals['code'] == 'coupon' && isset($totals['customer_coupon_id'])){
                                                                            $unuse_cc_ids[] = $totals['customer_coupon_id'];
                                                                    }
                                                            }
                                                }
                                            }

                                            $custom_coupon_ids = array_column($customer_coupon,  'coupon_id', 'customer_coupon_id');
                                            $couponinfo_query = $this->db->query( "SELECT coupon_id,name,code,discount,date_end FROM `" . DB_PREFIX . "coupon` WHERE coupon_id IN('".  implode("','", array_values($custom_coupon_ids))."') AND status='1' AND type='F' AND date_end>'". date('Y-m-d') ."'");
                                            foreach ($couponinfo_query->rows as $row){
                                                    $couponinfo[$row['coupon_id']] = array(
                                                                'name' => $row['name'],
                                                                'code' => $row['code'],
                                                                'discount' => $row['discount'],
                                                                'date_end' => $row['date_end']
                                                        );
                                            }

                                            foreach($customer_coupon as $key => &$result){
                                                    if(!empty($unuse_cc_ids) && in_array($result['customer_coupon_id'], $unuse_cc_ids)){
                                                            unset($customer_coupon[$key]);
                                                    }else{
                                                                if(isset($couponinfo[$result['coupon_id']])){
                                                                            $result['coupon_data'] = $couponinfo[$row['coupon_id']];
                                                                            $usable_product_query = $this->db->query("SELECT product_id FROM `". DB_PREFIX ."coupon_product` WHERE coupon_id='". (int)$result['coupon_id'] ."'");
                                                                            $result['product_data'] = array_values(array_column($usable_product_query->rows, 'product_id'));
                                                                }else{
                                                                         $result['coupon_data'] = array(
                                                                                    'name' => '',
                                                                                    'code' => '',
                                                                                    'product_data' => array(),
                                                                                    'date_end' => ''
                                                                            );
                                                                }
                                                    }
                                            }
                                            unset($result);
                                }
                                return $customer_coupon;
                 } 

                 /**
                  * 用于删除购物车中成功结算的商品
                  * @param type $order_id
                  */
                 public function removeByOrderId($order_id) {
                                    $cartid_query = $this->db->query( "SELECT cart_id FROM `" . DB_PREFIX . "order_product` WHERE order_id='". (int)$order_id ."'");
                                    $cartids = $cartid_query->rows;
                                    if($cartids){
                                            $cartids = array_column($cartids, 'cart_id');
                                                $this->db->query("DELETE FROM " . DB_PREFIX . "cart WHERE cart_id IN ('" . implode('\',\'', $cartids) . "')");
                                    }
                   }
}
