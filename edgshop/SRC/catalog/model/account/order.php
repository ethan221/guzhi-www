<?php
class ModelAccountOrder extends Model {
	public function getOrder($order_id) {
		//$order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id > '0'");
                                    $order_status_ids = $this->getInvalidOrderStatusId();
                                    $order_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order` WHERE order_id = '" . (int)$order_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND order_status_id IN ('". implode('\',\'', $order_status_ids)."')");
                
		if ($order_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['payment_country_id'] . "'");

			if ($country_query->num_rows) {
				$payment_iso_code_2 = $country_query->row['iso_code_2'];
				$payment_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$payment_iso_code_2 = '';
				$payment_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['payment_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$payment_zone_code = $zone_query->row['code'];
			} else {
				$payment_zone_code = '';
			}

			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$order_query->row['shipping_country_id'] . "'");

			if ($country_query->num_rows) {
				$shipping_iso_code_2 = $country_query->row['iso_code_2'];
				$shipping_iso_code_3 = $country_query->row['iso_code_3'];
			} else {
				$shipping_iso_code_2 = '';
				$shipping_iso_code_3 = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$order_query->row['shipping_zone_id'] . "'");

			if ($zone_query->num_rows) {
				$shipping_zone_code = $zone_query->row['code'];
			} else {
				$shipping_zone_code = '';
			}

			return array(
				'order_id'                => $order_query->row['order_id'],
                                                                        'order_no'               => $order_query->row['order_no'],
				'invoice_no'              => $order_query->row['invoice_no'],
				'invoice_prefix'          => $order_query->row['invoice_prefix'],
                                                                        'invoice'          => $order_query->row['invoice'],
				'store_id'                => $order_query->row['store_id'],
				'store_name'              => $order_query->row['store_name'],
				'store_url'               => $order_query->row['store_url'],
				'customer_id'             => $order_query->row['customer_id'],
				'fullname'               => $order_query->row['fullname'],
				'telephone'               => $order_query->row['telephone'],
				'fax'                     => $order_query->row['fax'],
				'email'                   => $order_query->row['email'],
				'payment_fullname'       => $order_query->row['payment_fullname'],
				'payment_company'         => $order_query->row['payment_company'],
				'payment_address'       => $order_query->row['payment_address'],
				'payment_postcode'        => $order_query->row['payment_postcode'],
				'payment_city'            => $order_query->row['payment_city'],
				'payment_zone_id'         => $order_query->row['payment_zone_id'],
				'payment_zone'            => $order_query->row['payment_zone'],
				'payment_zone_code'       => $payment_zone_code,
				'payment_country_id'      => $order_query->row['payment_country_id'],
				'payment_country'         => $order_query->row['payment_country'],
				'payment_iso_code_2'      => $payment_iso_code_2,
				'payment_iso_code_3'      => $payment_iso_code_3,
				'payment_address_format'  => $order_query->row['payment_address_format'],
				'payment_method'          => $order_query->row['payment_method'],
				'shipping_fullname'      => $order_query->row['shipping_fullname'],
				'shipping_company'        => $order_query->row['shipping_company'],
				'shipping_address'      => $order_query->row['shipping_address'],
				'shipping_postcode'       => $order_query->row['shipping_postcode'],
				'shipping_telephone'       => $order_query->row['shipping_telephone'],
				'shipping_city'           => $order_query->row['shipping_city'],
				'shipping_zone_id'        => $order_query->row['shipping_zone_id'],
				'shipping_zone'           => $order_query->row['shipping_zone'],
				'shipping_zone_code'      => $shipping_zone_code,
				'shipping_country_id'     => $order_query->row['shipping_country_id'],
				'shipping_country'        => $order_query->row['shipping_country'],
				'shipping_iso_code_2'     => $shipping_iso_code_2,
				'shipping_iso_code_3'     => $shipping_iso_code_3,
				'shipping_address_format' => $order_query->row['shipping_address_format'],
				'shipping_method'         => $order_query->row['shipping_method'],
				'comment'                 => $order_query->row['comment'],
				'total'                   => $order_query->row['total'],
				'order_status_id'         => $order_query->row['order_status_id'],
				'language_id'             => $order_query->row['language_id'],
				'currency_id'             => $order_query->row['currency_id'],
				'currency_code'           => $order_query->row['currency_code'],
				'currency_value'          => $order_query->row['currency_value'],
				'date_modified'           => $order_query->row['date_modified'],
				'date_added'              => $order_query->row['date_added'],
				'ip'                      => $order_query->row['ip']
			);
		} else {
			return false;
		}
	}

	public function getOrders($status='all', $start = 0, $limit = 20) {
		if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 1;
		}
                                    if($status == 'all'){
                                                $order_status_ids = $this->getInvalidOrderStatusId();
                                    }else{
                                                $order_status_ids = array((int)$status);
                                    }
		$query = $this->db->query("SELECT o.order_id, o.order_no, o.invoice, o.fullname, o.order_status_id, o.date_added, o.total, o.currency_code, o.currency_value FROM `" . DB_PREFIX . "order` o  WHERE o.customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id IN ('". implode('\',\'', $order_status_ids) ."') AND o.store_id = '" . (int)$this->config->get('config_store_id') . "'  ORDER BY o.order_id DESC LIMIT " . (int)$start . "," . (int)$limit);

		$orders = $query->rows;
                                    if(!empty($orders)){
                                            $order_status = $this->getOrderStatus();
                                            foreach ($orders as &$order){
                                                    $order['status'] = $order_status[$order['order_status_id']];
                                            }
                                            unset($order);
                                    }
                                    return $orders;
	}

	public function getOrderProduct($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->row;
	}

	public function getOrderProductsOLD($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderOptions($order_id, $order_product_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_option WHERE order_id = '" . (int)$order_id . "' AND order_product_id = '" . (int)$order_product_id . "'");

		return $query->rows;
	}

	public function getOrderVouchers($order_id) {
		$query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->rows;
	}

	public function getOrderTotals($order_id) {
		$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "order_total WHERE order_id = '" . (int)$order_id . "' ORDER BY sort_order");

		return $query->rows;
	}

	public function getOrderHistories($order_id) {
		$query = $this->db->query("SELECT date_added, os.name AS status, oh.comment, oh.notify FROM " . DB_PREFIX . "order_history oh LEFT JOIN " . DB_PREFIX . "order_status os ON oh.order_status_id = os.order_status_id WHERE oh.order_id = '" . (int)$order_id . "' AND os.language_id = '" . (int)$this->config->get('config_language_id') . "' ORDER BY oh.date_added");

		return $query->rows;
	}

	public function getTotalOrders($status = 'all') {
                                    if($status == 'all'){
                                                $order_status_ids = $this->getInvalidOrderStatusId();
                                    }else{
                                                $order_status_ids = array((int)$status);
                                    }
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order` o WHERE customer_id = '" . (int)$this->customer->getId() . "' AND o.order_status_id IN('". implode('\',\'', $order_status_ids) ."') AND o.store_id = '" . (int)$this->config->get('config_store_id') . "'");

		return $query->row['total'];
	}

	public function getTotalOrderProductsByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "order_product WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

	public function getTotalOrderVouchersByOrderId($order_id) {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "order_voucher` WHERE order_id = '" . (int)$order_id . "'");

		return $query->row['total'];
	}

                  public function getOrderProducts($order_id){
                                    $product_query = $this->db->query( "SELECT order_product_id,product_id,name,sku_id,quantity,price,total FROM `" . DB_PREFIX . "order_product` WHERE order_id='". (int)$order_id ."'");
                                    $products = $product_query->rows;
                                    if($products){
                                            $option_query = $this->db->query( "SELECT order_product_id,product_option_id,product_option_value_id,name,value FROM `" . DB_PREFIX . "order_option` WHERE order_id='". (int)$order_id ."'");
                                            $options = array();
                                            $opv_ids = array();
                                            $optimage_keys = array();
                                            foreach($option_query->rows as $row){
                                                    $options[$row['order_product_id']][] = $row;
                                                    $row['product_option_value_id'] && $opv_ids[] = $row['product_option_value_id'];
                                                    $optimage_keys[$row['order_product_id']] = $row['product_option_value_id'];
                                            }
                                            $opv_where = '';
                                            !empty($opv_ids) && $opv_where = " OR product_option_value_id IN('". implode('\',\'', $opv_ids) ."') ";
                                            $opv_where = " AND ( product_option_value_id='0' ". $opv_where .")";
                                            $product_ids = array_column($products, 'product_id');
                                            $optimage_query = $this->db->query("SELECT product_id,product_option_value_id,image FROM `" . DB_PREFIX . "product_image` WHERE product_id IN('". implode('\',\'', $product_ids) ."') ".$opv_where." ORDER BY sort_order");
                                            $option_images = array_column($optimage_query->rows, 'image', 'product_option_value_id');
                                            $image_query = $this->db->query("SELECT product_id,image FROM `" . DB_PREFIX . "product` WHERE product_id IN('". implode('\',\'', $product_ids) ."')");
                                            $images = array_column($image_query->rows, 'image', 'product_id');
                                            foreach ($products as &$product){
                                                    if(isset($options[$product['order_product_id']])){
                                                            $product['options'] = $options[$product['order_product_id']];
                                                    }else{
                                                            $product['options'] = array();
                                                    }
                                                    if(isset($optimage_keys[$product['order_product_id']]) && isset($option_images[$optimage_keys[$product['order_product_id']]])){
                                                            $product['image'] = $option_images[$optimage_keys[$product['order_product_id']]];
                                                    }else if(isset($images[$product['product_id']])){
                                                            $product['image'] = $images[$product['product_id']];
                                                    }
                                            }
                                            unset($product);
                                            return $products;
                                    }
                                    return FALSE;
                  }

                  public function getInvalidOrderStatusId(){
                          return array(0, 1, 2, 3, 5, 7, 11, 15, 17);
                  }

                  public function updateWaitPayOrader(){
                          $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id='7' WHERE customer_id = '" . (int)$this->customer->getId()."' AND order_status_id='0' AND date_added<'". date('Y-m-d H:i:s', time()-7200) ."'");
                  }
                  
                  public function getOrderStatus(){
                                $order_status = $this->cache->get('order_status_'. (int)$this->config->get('config_language_id'));
                                if(!$order_status){
                                            $order_status_query = $query = $this->db->query("SELECT order_status_id,name FROM `" . DB_PREFIX . "order_status` WHERE  language_id = '" . (int)$this->config->get('config_language_id') . "'");
                                            $order_status = array_column($order_status_query->rows, 'name', 'order_status_id');
                                            $order_status[0] = '待付款';
                                            $this->cache->set('order_status_'. (int)$this->config->get('config_language_id'), $order_status);
                                }
                                return $order_status;
                  }

                  public function getOrderBaseProduct($order_id){
                          $product_query = $this->db->query( "SELECT order_product_id,product_id,name,sku_id,quantity,price,total FROM `" . DB_PREFIX . "order_product` WHERE order_id='". (int)$order_id ."'");
                          return $product_query->rows;
                  }

                  public function getOrderProductItem($order_product_id){
                          $product_query = $this->db->query( "SELECT order_product_id,product_id,name,sku_id,quantity,price,total FROM `" . DB_PREFIX . "order_product` WHERE order_product_id='". (int)$order_product_id ."'");
                          return $product_query->row;
                  }
                  
                  public function cannelOrder($order_id){
                          return $this->db->query("UPDATE `" . DB_PREFIX . "order` SET order_status_id='7' WHERE order_id='". (int)$order_id ."' AND customer_id = '" . (int)$this->customer->getId()."' AND order_status_id='0'");
                  }
                  
                  public function getReviewProducts($review_status = '0', $start = 0, $limit = 20){
                                    if ($start < 0) {
			$start = 0;
		}
		if ($limit < 1) {
			$limit = 1;
		}
                                    $status_where = " AND oh.order_status_id=5";
                                    $status_where .= $review_status>0 ? " AND op.review_id>0" : " AND op.review_id=0";
                                    $product_query = $this->db->query( "SELECT op.order_product_id,op.order_id,op.product_id,op.name,op.sku_id,op.quantity,op.price,op.total,op.review_id FROM `" . DB_PREFIX . "order_product` op JOIN  `" . DB_PREFIX . "order_history` oh ON op.order_id=oh.order_id WHERE op.customer_id='". $this->customer->getId() ."'". $status_where ." ORDER BY oh.date_added DESC LIMIT ". $start .",". $limit);
                                    $products = $product_query->rows;
                                    if($products){
                                            $order_product_ids = array_column($products, 'order_product_id');
                                            $order_ids = array_column($products, 'order_id');
                                            $option_query = $this->db->query( "SELECT order_product_id,product_option_id,product_option_value_id,name,value FROM `" . DB_PREFIX . "order_option` WHERE order_product_id IN ('". implode('\',\'', $order_product_ids) ."')");
                                            $options = array();
                                            $opv_ids = array();
                                            foreach($option_query->rows as $row){
                                                    $options[$row['order_product_id']][] = $row;
                                                    $row['product_option_value_id'] && $opv_ids[] = $row['product_option_value_id'];
                                            }
                                            $opv_where = '';
                                            !empty($opv_ids) && $opv_where = " OR product_option_value_id IN('". implode('\',\'', $opv_ids) ."') ";
                                            $opv_where = " AND ( product_option_value_id='0' ". $opv_where .")";
                                            $product_ids = array_column($products, 'product_id');
                                            $image_query = $this->db->query("SELECT product_id,image FROM `" . DB_PREFIX . "product_image` WHERE product_id IN('". implode('\',\'', $product_ids) ."') ".$opv_where." ORDER BY sort_order");
                                            $images = array_column($image_query->rows, 'image', 'product_id');
                                            $order_query = $this->db->query("SELECT order_id,date_added FROM `" . DB_PREFIX . "order` WHERE order_id IN('". implode('\',\'', $order_ids) ."')");
                                            $orders = array_column($order_query->rows, 'date_added', 'order_id');
                                            if($review_status > 0){
                                                         $review_ids = array_column($products, 'review_id');
                                                         $comment_query = $this->db->query("SELECT review_id,order_product_id,text,rating FROM `" . DB_PREFIX . "review` WHERE review_id IN('". implode('\',\'', $review_ids) ."')");
                                                         $comments = array();
                                                         foreach($comment_query->rows as $row){
                                                                 $comments[$row['review_id']] = $row;
                                                         }
                                            }
                                            foreach ($products as &$product){
                                                    if(isset($options[$product['order_product_id']])){
                                                            $product['options'] = $options[$product['order_product_id']];
                                                    }else{
                                                            $product['options'] = array();
                                                    }
                                                    $product['image'] = '';
                                                    if(isset($images[$product['product_id']])){
                                                            $product['image'] = $images[$product['product_id']];
                                                    }
                                                    $product['date_added'] = '';
                                                    if(isset($orders[$product['order_id']])){
                                                            $product['date_added'] = $orders[$product['order_id']];
                                                    }
                                                    if(isset( $comments[$product['review_id']])){
                                                            $product['comment'] = $comments[$product['review_id']];
                                                    }
                                            }
                                            unset($product);
                                            return $products;
                                    }
                                    return FALSE;
                  }
                  
                  public function getReviewProductTotals($review_status = 0){
                                    $status_where = " AND oh.order_status_id=5";
                                    $status_where .= $review_status>0 ? " AND op.review_id>0" : " AND op.review_id=0";
                                    $product_query = $this->db->query( "SELECT COUNT(*) as total FROM `" . DB_PREFIX . "order_product` op JOIN  `" . DB_PREFIX . "order_history` oh ON op.order_id=oh.order_id WHERE op.customer_id='". $this->customer->getId()."'" .$status_where);
                                    return $product_query->row['total'];
                  }
}