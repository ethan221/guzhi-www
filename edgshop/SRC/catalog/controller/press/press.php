<?php
class ControllerPressPress extends Controller {
	private $error = array();

	public function index() {
		$this->load->language('press/press');
                                    $this->load->model('press/category');

		if (isset($this->request->get['press_id'])) {
			$press_id = (int)$this->request->get['press_id'];
		} else {
			$press_id = 0;
		}

                                    if (isset($this->request->get['keyword'])) {
			$keyword = rawurldecode(trim($this->request->get['keyword']));
		} else {
			$keyword = '';
		}
                                   $data['keyword'] = $keyword;

                                   if($keyword != ''){
                                                $categories = $this->model_press_category->getPressCategoriesByKeywords($keyword);
                                                if($press_id==0 && !empty($categories)){
                                                        $first_entry = current($categories);
                                                        $press_id = $first_entry['children'][0]['press_id'];
                                                }
                                    }

                                    $data['press_id'] = $press_id;

		$this->load->model('press/press');
		$this->load->model('catalog/product');

		$press_info = $this->model_press_press->getPress($press_id);

		if ($press_info) {
			$url = '';

			if (isset($this->request->get['tag'])) {
				$url .= '&tag=' . $this->request->get['tag'];
			}

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->document->setTitle($press_info['meta_title']);
			$this->document->setDescription($press_info['meta_description']);
			$this->document->setKeywords($press_info['meta_keyword']);
			$data['heading_title'] = $press_info['title'];
			
			$data['text_empty'] = $this->language->get('text_empty');
			$data['text_press'] = $this->language->get('text_press');
			$data['text_created_date'] = $this->language->get('text_created_date');
			$data['text_loading'] = $this->language->get('text_loading');
			$data['text_related'] = $this->language->get('text_related');
			

			$data['title']        		= html_entity_decode($press_info['title'], ENT_QUOTES, 'UTF-8');
			$data['status']  	   	= $press_info['status'];
			$data['sort_order']   		= $press_info['sort_order'];
			$data['date_added']   		= $press_info['date_added'];
			$data['description'] 		= html_entity_decode($press_info['description'], ENT_QUOTES, 'UTF-8');

			$data['categories'] = array();

                                                      if(isset($categories)){
                                                              $data['categories'] = $categories;
                                                      }else{
                                                              $data['categories'] = $this->model_press_category->getAllPressCategories();
                                                      }

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('press/press', $data));
			
		} else {
                                                      $args = array('keyword' => $keyword);
                                                      if($keyword){
                                                              $args['search'] = '1';
                                                      }
                                                      $url = $this->url->link('press/all', $args);
                                                      $this->response->redirect($url);
/*
			$url = '';

			if (isset($this->request->get['page'])) {
				$url .= '&page=' . $this->request->get['page'];
			}

			if (isset($this->request->get['limit'])) {
				$url .= '&limit=' . $this->request->get['limit'];
			}

			$this->document->setTitle('没有相关内容');

			$data['heading_title'] = $this->language->get('没有相关内容');

			$data['text_error'] = '没有相关内容';

			$data['button_continue'] = $this->language->get('button_continue');

			$data['continue'] = $this->url->link('press/all');

			$this->response->addHeader($this->request->server['SERVER_PROTOCOL'] . ' 404 Not Found');

			$data['footer'] = $this->load->controller('common/footer');
			$data['header'] = $this->load->controller('common/header');

			$this->response->setOutput($this->load->view('error/not_found', $data));
 * 
 */
			
		}
	}

}
