<?php
class ControllerAccountComment extends Controller {

	public function index() {
		$this->load->language('account/order');

		$this->document->setTitle($this->language->get('heading_title'));
		
		$url = '';
                                    $status_name = isset($this->request->get['status']) ? $this->request->get['status'] : 'wait';
                                    $status_data = array('wait' => '0', 'review' => '1');
                                    $status = isset($status_data[$status_name]) ? $status_data[$status_name] : '0';
		if (isset($this->request->get['page'])) {
			$url .= '&page=' . $this->request->get['page'];
		}

		$data['heading_title'] = $this->language->get('heading_title');

		$data['text_empty'] = $this->language->get('text_empty');
                
                                    $this->document->addStyle(THEME_PATH.'css/address.css');
                                    $this->document->addStyle(THEME_PATH.'css/city.css');
                                    $this->document->addStyle(THEME_PATH."css/evaluate.css");
                                   // $this->document->addScript(THEME_PATH.'js/my.js'); 

		if (isset($this->request->get['page'])) {
			$page = $this->request->get['page'];
		} else {
			$page = 1;
		}

		$data['orders'] = array();

		$this->load->model('account/order');

		$comment_total = $this->model_account_order->getReviewProductTotals($status);

                                    if($comment_total>0){
                                                $this->load->model('tool/image');
                                                $results = $this->model_account_order->getReviewProducts($status, ($page - 1) * 10, 10);

                                                foreach ($results as &$product) {
                                                        if (isset($product['image'])) {
                                                                $image = $this->model_tool_image->resize($product['image'], $this->config->get($this->config->get('config_theme') . '_image_cart_width'), $this->config->get($this->config->get('config_theme') . '_image_cart_height'));
                                                        } else {
                                                                $image = '';
                                                        }
                                                        if(isset($comment_data[$product['order_product_id']])){
                                                                $product['comment'] = $comment_data[$product['order_product_id']];
                                                        }
                                                        $product['image'] = $image;
                                                        $data['comment_products'][] = $product;
                                                }
                                                unset($product);
                                    }

		$pagination = new Pagination();
		$pagination->total = $comment_total;
		$pagination->page = $page;
		$pagination->limit = 10;
		$pagination->url = $this->url->link('account/comment', 'status='.$status_name.'&page={page}', true);

		$data['pagination'] = $pagination->render();

		$data['results'] = sprintf($this->language->get('text_pagination'), ($comment_total) ? (($page - 1) * 10) + 1 : 0, ((($page - 1) * 10) > ($comment_total - 10)) ? $comment_total : ((($page - 1) * 10) + 10), $comment_total, ceil($comment_total / 10));

		$data['account_left'] = $this->load->controller('common/account_left');
		$data['footer'] = $this->load->controller('common/footer');
		$data['header'] = $this->load->controller('common/header');
                                    
                                    if($status == 0){
                                                $this->response->setOutput($this->load->view('account/comment_goods_list', $data));
                                    }else{
                                                $this->response->setOutput($this->load->view('account/comment_list', $data));
                                    }
	}
        
                  public function add() {
		$this->load->language('product/product');
		$json = array();
		if ($this->request->server['REQUEST_METHOD'] == 'POST') {
			if ((utf8_strlen($this->request->post['comment']) < 10) || (utf8_strlen($this->request->post['comment']) > 200)) {
				$json['error'] = $this->language->get('error_text');
			}

			if (empty($this->request->post['star']) || $this->request->post['star'] < 0 || $this->request->post['star'] > 5) {
				$json['error'] = $this->language->get('error_rating');
			}

                                                     if (empty($this->request->post['opid']) || $this->request->post['opid'] < 0) {
				$json['error'] = '评论失败:无效的订单号';
			}

			// Captcha
			if ($this->config->get($this->config->get('config_captcha') . '_status') && in_array('review', (array)$this->config->get('config_captcha_page'))) {
				$captcha = $this->load->controller('captcha/' . $this->config->get('config_captcha') . '/validate');
				if ($captcha) {
					$json['error'] = $captcha;
				}
			}

			if (!isset($json['error'])) {
				$this->load->model('catalog/review');
                                                                        $add_data = array(
                                                                            'rating' => $this->request->post['star'],
                                                                            'name' => isset($this->session->data['nick']) ? $this->session->data['nick'] : $this->customer->getFullName(),
                                                                            'text' => trim($this->request->post['comment']),
                                                                            'order_product_id' => $this->request->post['opid']
                                                                        );
				$this->model_catalog_review->addReview($this->request->post['pid'], $add_data);
				$json['success'] = $this->language->get('text_success');
			}
		}
		$this->response->addHeader('Content-Type: application/json');
		$this->response->setOutput(json_encode($json));
	}
}