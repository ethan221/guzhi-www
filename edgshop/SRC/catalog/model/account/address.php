<?php
class ModelAccountAddress extends Model {
	public function addAddress($data) {
		//$this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$this->customer->getId() . "', fullname = '" . $this->db->escape($data['fullname']) . "', company = '" . $this->db->escape($data['company']) . "', address = '" . $this->db->escape($data['address']) . "', postcode = '" . $this->db->escape($data['postcode']) . "', city = '" . $this->db->escape($data['city']) . "', zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "', shipping_telephone = '" . $this->db->escape($data['shipping_telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "'");
                                    $count_query = $this->db->query("SELECT COUNT(*) AS count FROM  " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "' AND is_del='0'");
                                    if($count_query->row['count']>9){
                                            return FALSE;
                                    }
                                    !isset($data['country_id']) && $data['country_id'] = 44;
                                    $this->db->query("INSERT INTO " . DB_PREFIX . "address SET customer_id = '" . (int)$this->customer->getId() . "', fullname = '" . $this->db->escape($data['fullname']) . "', address = '" . $this->db->escape($data['address']) . "', city_id = '" . (int)$data['city'] . "', region_id='".(int)$data['region']."',zone_id = '" . (int)$data['zone_id'] . "', country_id = '" . (int)$data['country_id'] . "', shipping_telephone = '" . $this->db->escape($data['shipping_telephone']) . "'");
		$address_id = $this->db->getLastId();
		//edit mcc
		$total_address = $this->getTotalAddresses();
		
		if($total_address == 1) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}else{
			if (!empty($data['default'])) {
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
			}
		}
		//end mcc
		return $address_id;
	}

	public function editAddress($address_id, $data) {

		$this->db->query("UPDATE " . DB_PREFIX . "address SET fullname = '" . $this->db->escape($data['fullname']) . "', address = '" . $this->db->escape($data['address']) . "', zone_id = '" . (int)$data['zone_id'] . "', shipping_telephone = '" . $this->db->escape($data['shipping_telephone']) . "', custom_field = '" . $this->db->escape(isset($data['custom_field']) ? json_encode($data['custom_field']) : '') . "' WHERE address_id  = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");

		if (!empty($data['default'])) {
			$this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
		}

	}

                  public function setdefaultAddress($address_id) {
                                      return $this->db->query("UPDATE " . DB_PREFIX . "customer SET address_id = '" . (int)$address_id . "' WHERE customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function deleteAddress($address_id) {
		//$this->db->query("DELETE FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
                                    return $this->db->query("UPDATE `" . DB_PREFIX . "address` SET is_del='1' WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "'");
	}

	public function getAddress($address_id) {
		$address_query = $this->db->query("SELECT DISTINCT * FROM " . DB_PREFIX . "address WHERE address_id = '" . (int)$address_id . "' AND customer_id = '" . (int)$this->customer->getId() . "' AND is_del='0'");

		if ($address_query->num_rows) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$address_query->row['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$address_query->row['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
			} else {
				$zone = '';
			}
                                                      $city_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "region` WHERE id = '" . (int)$address_query->row['city_id'] . "'");
			if ($city_query->num_rows) {
				$city = $city_query->row['name'];
			} else {
				$city = '';
			}
                        
                                                      $region_query = $this->db->query("SELECT id,code,name FROM `".DB_PREFIX."region` WHERE id = '" . (int)$address_query->row['region_id'] . "'");
                                                      if ($region_query->num_rows) {
				$region = $region_query->row['name'];
                                                                        $region_id = $region_query->row['id'];
				$zone_code = $region_query->row['code'];
			} else {
				$region = '';
				$zone_code = '';
                                                                        $region_id = '';
			}

			$address_data = array(
				'address_id'     => $address_query->row['address_id'],
				'fullname'      => $address_query->row['fullname'],
				'address'      => $address_query->row['address'],
				'postcode'       => $zone_code,
				'shipping_telephone'       => $address_query->row['shipping_telephone'],
				'city'           => $city,
                                                                        'region'      => $region,
                                                                        'region_id'    => $region_id,
				'zone_id'        => $address_query->row['zone_id'],
				'zone'           => $zone,
				'zone_code'      => $zone_code,
				'country_id'     => $address_query->row['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => json_decode($address_query->row['custom_field'], true)
			);

			return $address_data;
		} else {
			return false;
		}
	}

	public function getAddresses($limit = 0) {
		$address_data = array();
                                    $limit_str = '';
                                    if($limit>0){
                                            $limit_str = " LIMIT 0,{$limit}";
                                    }
                                    $query = $this->db->query("SELECT * FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "' AND is_del='0' {$limit_str}");

		foreach ($query->rows as $result) {
			$country_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "country` WHERE country_id = '" . (int)$result['country_id'] . "'");

			if ($country_query->num_rows) {
				$country = $country_query->row['name'];
				$iso_code_2 = $country_query->row['iso_code_2'];
				$iso_code_3 = $country_query->row['iso_code_3'];
				$address_format = $country_query->row['address_format'];
			} else {
				$country = '';
				$iso_code_2 = '';
				$iso_code_3 = '';
				$address_format = '';
			}

			$zone_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "zone` WHERE zone_id = '" . (int)$result['zone_id'] . "'");

			if ($zone_query->num_rows) {
				$zone = $zone_query->row['name'];
				//$zone_code = $zone_query->row['code'];
			} else {
				$zone = '';
				//$zone_code = '';
			}
                        
                                                      $city_query = $this->db->query("SELECT * FROM `" . DB_PREFIX . "region` WHERE id = '" . (int)$result['city_id'] . "'");
			if ($city_query->num_rows) {
				$city = $city_query->row['name'];
				//$zone_code = $zone_query->row['code'];
			} else {
				$city = '';
				//$zone_code = '';
			}
                        
                                                      $region_query = $this->db->query("SELECT id,code,name FROM `".DB_PREFIX."region` WHERE id = '" . (int)$result['region_id'] . "'");
                                                      if ($region_query->num_rows) {
				$region = $region_query->row['name'];
				$zone_code = $region_query->row['code'];
			} else {
				$region = '';
				$zone_code = '';
			}

			$address_data[$result['address_id']] = array(
				'address_id'     => $result['address_id'],
				'fullname'      => $result['fullname'],
				'address'      => $result['address'],
				'postcode'       => $zone_code,
				'shipping_telephone'       => $result['shipping_telephone'],
                                                                        'city_id' => (int)$result['city_id'] ,
				'city'           => $city,
                                                                        'region'        => $region,
				'zone_id'        => $result['zone_id'],
				'zone'           => $zone,
                                                                        'region_id' => (int)$result['region_id'] ,
				'zone_code'      => $zone_code,
				'country_id'     => $result['country_id'],
				'country'        => $country,
				'iso_code_2'     => $iso_code_2,
				'iso_code_3'     => $iso_code_3,
				'address_format' => $address_format,
				'custom_field'   => json_decode($result['custom_field'], true)

			);
		}

		return $address_data;
	}

	public function getTotalAddresses() {
		$query = $this->db->query("SELECT COUNT(*) AS total FROM " . DB_PREFIX . "address WHERE customer_id = '" . (int)$this->customer->getId() . "'");

		return $query->row['total'];
	}
}