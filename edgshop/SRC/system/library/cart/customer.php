<?php
namespace Cart;
class Customer {
	private $customer_id;
                  private $member_id;
	private $fullname;
	private $customer_group_id;
	private $email;
	private $telephone;
	private $newsletter;
	private $address_id;
                  private $type;
                  private $token;

	public function __construct($registry) {
		$this->db = $registry->get('db');
		$this->request = $registry->get('request');
		$this->session = $registry->get('session');

		if (isset($this->session->data['customer_id'])) {
			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND status = '1'");

			if ($customer_query->num_rows) {
				$this->customer_id = $customer_query->row['customer_id'];
                                                                        $this->member_id = $customer_query->row['member_id'];
				$this->fullname = $customer_query->row['fullname'];
				$this->customer_group_id = $customer_query->row['customer_group_id'];
				$this->email = $customer_query->row['email'];
				$this->telephone = $customer_query->row['telephone'];
				//$this->fax = $customer_query->row['fax'];
				$this->newsletter = $customer_query->row['newsletter'];
				$this->address_id = $customer_query->row['address_id'];
                                                                        $this->token = $customer_query->row['token'];
                                                                        $this->type = $customer_query->row['type'];
                                                                        if($this->fullname == ''){
                                                                                if($this->type==''){
                                                                                        $this->fullname = $this->telephone;
                                                                                }else if(isset($this->session->data['nick'])){
                                                                                        $this->fullname = $this->session->data['nick'];
                                                                                }
                                                                        }
 
				$this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

				$query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer_ip WHERE customer_id = '" . (int)$this->session->data['customer_id'] . "' AND ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "'");

				if (!$query->num_rows) {
					$this->db->query("INSERT INTO " . DB_PREFIX . "customer_ip SET customer_id = '" . (int)$this->session->data['customer_id'] . "', ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "', date_added = NOW()");
				}
			} else {
				$this->logout();
			}
		}
	}

//	public function login($email, $password, $override = false) {
//		if ($override) {
//			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND status = '1'");
//		} else {
//			$customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE LOWER(email) = '" . $this->db->escape(utf8_strtolower($email)) . "' AND (password = SHA1(CONCAT(salt, SHA1(CONCAT(salt, SHA1('" . $this->db->escape($password) . "'))))) OR password = '" . $this->db->escape(md5($password)) . "') AND status = '1' AND approved = '1'");
//		}
//
//		if ($customer_query->num_rows) {
//			$this->session->data['customer_id'] = $customer_query->row['customer_id'];
//
//			$this->customer_id = $customer_query->row['customer_id'];
//			$this->fullname = $customer_query->row['fullname'];
//			$this->customer_group_id = $customer_query->row['customer_group_id'];
//			$this->email = $customer_query->row['email'];
//			$this->telephone = $customer_query->row['telephone'];
//			$this->fax = $customer_query->row['fax'];
//			$this->newsletter = $customer_query->row['newsletter'];
//			$this->address_id = $customer_query->row['address_id'];
//
//			$this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");
//
//			return true;
//		} else {
//			return false;
//		}
//	}
        
                  public function login($member_id, $token, $type='', $nick = '') {

                                    $customer_query = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE member_id = '" . $member_id."'");
		if ($customer_query->num_rows) {
			$this->session->data['customer_id'] = $customer_query->row['customer_id'];
                                                      $this->session->data['member_id'] = $customer_query->row['member_id'];
                                                      $this->session->data['nick'] = $nick;
                                                      $this->session->data['type'] = $type;
                                                      $this->session->data['customer_token'] = $customer_query->row['token'];
			$this->customer_id = $customer_query->row['customer_id'];
			$this->fullname = $customer_query->row['fullname'];
			$this->customer_group_id = $customer_query->row['customer_group_id'];
			$this->email = $customer_query->row['email'];
			$this->telephone = $customer_query->row['telephone'];
			$this->newsletter = $customer_query->row['newsletter'];
			$this->address_id = $customer_query->row['address_id'];
                                                      $this->token = $token;
                                                      $this->type = $type;

			$this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "',token='".$this->token."',type='".$type."' WHERE customer_id = '" . (int)$this->customer_id . "'");

			return true;
		} else {
			return false;
		}
	}
	
	public function login_weixin($weixin_login_unionid){
		$customer = $this->db->query("SELECT * FROM " . DB_PREFIX . "customer WHERE weixin_login_unionid = '" . $this->db->escape($weixin_login_unionid) . "'");

		if ($customer->num_rows) {
			$this->session->data['customer_id'] = $customer->row['customer_id'];

			if ($customer->row['cart'] && is_string($customer->row['cart'])) {
				$cart = unserialize($customer->row['cart']);

				foreach ($cart as $key => $value) {
					if (!array_key_exists($key, $this->session->data['cart'])) {
						$this->session->data['cart'][$key] = $value;
					} else {
						$this->session->data['cart'][$key] += $value;
					}
				}
			}

			if ($customer->row['wishlist'] && is_string($customer->row['wishlist'])) {
				if (!isset($this->session->data['wishlist'])) {
					$this->session->data['wishlist'] = array();
				}

				$wishlist = unserialize($customer->row['wishlist']);

				foreach ($wishlist as $product_id) {
					if (!in_array($product_id, $this->session->data['wishlist'])) {
						$this->session->data['wishlist'][] = $product_id;
					}
				}
			}

			$this->customer_id = $customer->row['customer_id'];
			$this->fullname = $customer->row['fullname'];
			$this->email = $customer->row['email'];
			$this->telephone = $customer->row['telephone'];
			$this->fax = $customer->row['fax'];
			$this->newsletter = $customer->row['newsletter'];
			$this->customer_group_id = $customer->row['customer_group_id'];
			$this->address_id = $customer->row['address_id'];

			$this->db->query("UPDATE " . DB_PREFIX . "customer SET ip = '" . $this->db->escape($this->request->server['REMOTE_ADDR']) . "' WHERE customer_id = '" . (int)$this->customer_id . "'");

			return true;
		} else {
			return false;
		}

	}

	public function logout() {
		unset($this->session->data['customer_id']);

		$this->customer_id = '';
                                    $this->member_id = '';
		$this->fullname = '';
		$this->customer_group_id = '';
		$this->email = '';
		$this->telephone = '';
		$this->newsletter = '';
		$this->address_id = '';
	}

	public function isLogged() {
		return $this->customer_id;
	}

	public function getId() {
		return $this->customer_id;
	}
        
                	public function getCustomerId() {
		return $this->customer_id;
	}
        
                  public function getMemberId() {
		return $this->member_id;
	}

	public function getFullName() {
		return $this->fullname;
	}

	public function getGroupId() {
		return $this->customer_group_id;
	}

	public function getEmail() {
		return $this->email;
	}
        
        	public function getToken() {
		return $this->token;
	}

                	public function getType() {
		return $this->type;
	}

	public function getTelephone() {
		return $this->telephone;
	}

	public function getNewsletter() {
		return $this->newsletter;
	}

	public function getAddressId() {
		return $this->address_id;
	}

	public function getBalance() {
		$query = $this->db->query("SELECT SUM(amount) AS total FROM " . DB_PREFIX . "customer_transaction WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}

	public function getRewardPoints() {
		$query = $this->db->query("SELECT SUM(points) AS total FROM " . DB_PREFIX . "customer_reward WHERE customer_id = '" . (int)$this->customer_id . "'");

		return $query->row['total'];
	}
}
