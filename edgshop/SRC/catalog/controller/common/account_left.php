<?php
class ControllerCommonAccountLeft extends EdgController {
	public function index() {
		parent::logincheck();
                                    if(parent::getRouter() == 'account/account'){
                                            $this->response->redirect('account/order');
                                    }
                                    $data['text_account'] = $this->customer->getFullName() == '' ? $this->customer->getTelephone() : $this->customer->getFullName();
                		$data['password'] = $this->url->link('account/password', '', true);
		$data['address'] = $this->url->link('account/address', '', true);
                                    $data['account_type'] = $this->customer->getType();
                		$this->load->model('account/order');

		$data['comment_total'] = $this->model_account_order->getReviewProductTotals(0);
		return $this->load->view('common/account_left', $data);
	}
}
