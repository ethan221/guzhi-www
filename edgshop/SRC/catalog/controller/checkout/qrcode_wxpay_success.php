<?php
class ControllerCheckoutQrcodeWxPaySuccess extends Controller {
	public function index() {
		$this->load->language('checkout/success');

		$order_id = 0;

		if (isset($this->session->data['order_id'])) {
			$order_id = $this->session->data['order_id'];
		}

		$this->document->setTitle($this->language->get('heading_title'));
		$data['heading_title'] = $this->language->get('heading_title');
		$data['code_url'] = $this->session->data['code_url'];

		$this->response->setOutput($this->load->view('common/qrcode_wxpay_success', $data));
		
	}
	
	
	

	
}
