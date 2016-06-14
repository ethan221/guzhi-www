<?php
class ControllerAccountCoupon extends Controller {
	public function index() {
		if (!$this->customer->isLogged()) {
			$this->session->data['redirect'] = $this->url->link('account/reward', '', true);

			$this->response->redirect($this->url->link('account/login', '', true));
		}

		$this->document->setTitle('优惠券');
                                    $this->document->addStyle(THEME_PATH.'css/address.css');
                                    $this->document->addStyle(THEME_PATH.'css/city.css');

		$this->load->model('account/coupon');

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['coupons'] = array();

		$filter_data = array(
			'start' => ($page - 1) * 10,
			'limit' => 10
		);

		$reward_total = $this->model_account_coupon->getTotalCoupons();
                                    if($reward_total>0){
                                                $results = $this->model_account_coupon->getCoupons($filter_data);
                                                $coupon_status = array('0'=> '未使用', '1' => '已使用', '2' => '已使用');
                                                foreach ($results as $result) {
                                                        $result['date_added']  = date($this->language->get('date_format_short'), strtotime($result['date_added']));
                                                        $result['status'] = $coupon_status[$result['coupon_status']];
                                                        $data['coupons'][] = $result;
                                                }
                                    }

		$pagination = new Pagination();
		$pagination->total = $reward_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/coupon', 'page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($reward_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($reward_total - 10)) ? $reward_total : ((($page - 1) * 10) + 10), $reward_total, ceil($reward_total / 10));

		$data['total'] = (int)$this->customer->getRewardPoints();

		$data['continue'] = $this->url->link('account/account', '', true);

		$data['account_left'] = $this->load->controller('common/account_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');

		$this->response->setOutput($this->load->view('account/coupon', $data));
	}
}