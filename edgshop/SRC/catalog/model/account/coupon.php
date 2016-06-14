<?php
class ModelAccountCoupon extends Model {
	public function getCoupons($data = array()) {
		$sql = "SELECT * FROM `" . DB_PREFIX . "customer_coupon` WHERE customer_id = '" . (int)$this->customer->getId() . "'";

		if (isset($data['start']) || isset($data['limit'])) {
			if ($data['start'] < 0) {
				$data['start'] = 0;
			}

			if ($data['limit'] < 1) {
				$data['limit'] = 20;
			}

			$sql .= " LIMIT " . (int)$data['start'] . "," . (int)$data['limit'];
		}

		$customer_query = $this->db->query($sql);
                                    $customer_coupon = $customer_query->rows;
                                    if(!empty($customer_coupon)){
                                            $custom_coupon_ids = array_column($customer_coupon,  'coupon_id', 'customer_coupon_id');
                                            $couponinfo_query = $this->db->query( "SELECT coupon_id,name,code,date_end FROM `" . DB_PREFIX . "coupon` WHERE coupon_id IN('".  implode("','", array_values($custom_coupon_ids))."')");
                                            foreach ($couponinfo_query->rows as $row){
                                                    $couponinfo[$row['coupon_id']] = array(
                                                                'name' => $row['name'],
                                                                'code' => $row['code'],
                                                                'date_end' => $row['date_end']
                                                        );
                                            }
                                            foreach($customer_coupon as &$result){
                                                    if(isset($couponinfo[$result['coupon_id']])){
                                                                $result['coupon_data'] = $couponinfo[$row['coupon_id']];
                                                    }else{
                                                             $result['coupon_data'] = array(
                                                                        'name' => '',
                                                                        'code' => '',
                                                                        'date_end' => ''
                                                                );
                                                    }
                                            }
                                            unset($result);
                                    }
		return $customer_coupon;
	}

	public function getTotalCoupons() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM `" . DB_PREFIX . "customer_coupon` WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row['total'];
	}

}